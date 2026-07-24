import os
import PyPDF2
from google import genai
from dotenv import load_dotenv
import json

caminho_script = os.path.dirname(os.path.abspath(__file__))
caminho_env = os.path.join(caminho_script, '.env')

load_dotenv(caminho_env)

chave_secreta = os.getenv("GEMINI_API_KEY") 

client = genai.Client(api_key=chave_secreta)

def extrair_texto_pdf(arquivo_pdf):
    texto = ""

    leitor = PyPDF2.PdfReader(arquivo_pdf)
    for pagina in leitor.pages:
        texto_pagina = pagina.extract_text()

        if texto_pagina:
            texto += texto_pagina
        
    return texto
    
def extrair_dados_candidato(texto_curriculo):
    prompt = f"""
    Você é um sistema especializado em extração de informações de currículos.

    Analise o currículo abaixo e extraia as seguintes informações:

    - Nome completo
    - Idade
    - Data de nascimento
    - Gênero
    - Raça
    - E-mail
    - Telefone
    - Cidade
    - Estado
    - Formação acadêmica
    - Nome da instituição de ensino
    - Skills e competências profissionais
    
    Se alguma informação não estiver presente no currículo,
    retorne uma string vazia ou uma lista vazia para esse campo.
    Não invente informações.
    
    CURRÍCULO:
    {texto_curriculo}

    Responda APENAS com um JSON válido no seguinte formato:
    {{
    "nome": "nome completo",
    "idade": "idade",
    "nascimento": "nascimento",
    "genero": "genero",
    "raca": "raca",
    "email": "email",
    "telefone": "telefone",
    "cidade": "cidade",
    "estado": "estado",
    "formacao": ["formacao encontrada"],
    "instituicao": ["instituicao encontrada"],
    "skills": ["skill 1", "skill 2", "skill 3"]
    }}
    Não escreva nenhum texto antes ou depois do JSON
    """
    response = client.models.generate_content(model='gemini-2.5-flash', 
            contents=prompt)
    texto_resposta = response.text.strip()
    texto_limpo = texto_resposta.replace("```json", "").replace("```", "").strip()

    try:
        dados_candidato = json.loads(texto_limpo)
        
        return dados_candidato
            
    except json.JSONDecodeError:
        return {"nome": "", "idade": "", "nascimento": "","genero": "", "raca": "", "email": "", "telefone": "",                
    "cidade": "","estado": "", "formacao": [],"instituicao": [], "skills": [],
    "erro": "Erro ao processar os dados do currículo." }
    
def criar_perfil_protegido(dados_candidato):
    perfil_protegido = {"estado": dados_candidato.get("estado", ""), 
                        "formacao": dados_candidato.get("formacao", []),
                        "skills": dados_candidato.get("skills", [])}
    
    return perfil_protegido

def calcular_match_ia(candidato, vaga):
    prompt = f"""
você é um especialista em recrutamento e inclusão. Avalie a compatibilidade 
entre o candidato e a vaga abaixo.

DADOS DA VAGA:
Título: {vaga.get('titulo')}
Senioridade exigida: {vaga.get('seniority')}
Skills obrigatórias: {', '.join(vaga.get('skills_obrigatorias',[]))}
Skills desejáveis: {', '.join(vaga.get('skills_desejaveis', []))}

DADOS DO CANDIDATO:
Senioridade: {candidato.get('seniority')}
Skills: {', '.join(candidato.get('skills', []))}

Responda APENAS com um JSON válido, no formato exato abaixo,
sem nenhum texto antes ou depois:
{{"score": (número de 0 a 100, representando o percentual de compatibilidade),
"justificativa": "(explicação curta, em português, do porquê dessa pontuação)"}}
"""
    response = client.models.generate_content(model='gemini-2.5-flash', 
            contents=prompt)

    texto_resposta = response.text.strip()
    texto_limpo = texto_resposta.replace("```json", "").replace("```", "").strip()

    try:
        resultado = json.loads(texto_limpo)

        return resultado        
    except json.JSONDecodeError:
        return {"score": 0, "justificativa": "Erro ao processar resposta da IA."}
    

if __name__ == '__main__':
    caminho_pdf_teste = os.path.join(caminho_script, 'uploads', 'curriculo_teste.pdf')
    
    with open(caminho_pdf_teste, 'rb') as arquivo_pdf:
        texto_curriculo = extrair_texto_pdf(arquivo_pdf)
    
    dados_candidato = extrair_dados_candidato(texto_curriculo)
    perfil_protegido = criar_perfil_protegido(dados_candidato)

    print("DADOS DO CANDIDATO: ")
    print(dados_candidato)

    print("\nPERFIL PROTEGIDO: ")
    print(perfil_protegido)
