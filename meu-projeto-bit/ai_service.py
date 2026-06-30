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

def extrair_texto_pdf(caminho_pdf):
    '''
Observação: Como não será usada a função PDF, deixei ela aqui,
para uma futura funcionalidade de upload de currículo.
'''

    texto = ""
    
    try:
        with open(caminho_pdf, 'rb') as ficheiro:
            leitor = PyPDF2.PdfReader(ficheiro)
            for pagina in leitor.pages:
                if pagina. extract_text():
                    texto += pagina.extract_text()
        
        return texto
    except FileNotFoundError:
        return 'Erro: Ficheiro PDF não encontrado.'


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
    candidato_teste = {
        'seniority': 'Pleno',
        'skills': ['React', 'Node.js', 'SQL']
    }
    
    vaga_teste = {
        'titulo': 'Desenvolvedor(a) Front-end',
        'seniority': 'Pleno',
        'skills_obrigatorias': ['React', 'TypeScript', 'Node.js', 'CSS-in-JS'],
        'skills_desejaveis': ['UI/UX', 'Scrum', 'TailwindCSS']
    }
    
    resultado = calcular_match_ia(candidato_teste, vaga_teste)
    print(resultado)