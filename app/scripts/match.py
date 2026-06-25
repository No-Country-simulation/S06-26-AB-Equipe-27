import json
import sys
import logging

def mascarar_dados(candidato_completo):
    colunas_para_esconder = ['nome', 'idade', 'raca', 'genero', 'is_pcd', 
                            'municipio', 'lat', 'long']
    candidato_mascarado = {k: v for k, v in candidato_completo.items() if k not in colunas_para_esconder}
    return candidato_mascarado

def processar_math(candidato, vaga):
    badge = 'Diversidade' if (candidato.get('genero') == 'Feminino' 
                            or candidato.get('is_pcd')) else 'Padrão'
    score = 0

    skill_match = processador_nlp(candidato['skills'], vaga['skills_obrigatorias'])
    recomendacao = gerar_recomendacao(candidato['skills'], vaga['skills_obrigatorias'])

    score = len(skill_match) * 20
    
    dados_para_recrutador = mascarar_dados(candidato)

    dados_para_recrutador['score_match'] = score
    dados_para_recrutador['skills_em_comum'] = skill_match
    dados_para_recrutador['badge_diversidade'] = badge
    dados_para_recrutador['recomendacao'] = recomendacao
    
    return dados_para_recrutador

def processador_nlp(skills_candidatos, skills_vaga):
    candito_set = {skill.lower() for skill in skills_candidatos}
    vaga_set = {skill.lower() for skill in skills_vaga}

    habilidades_encontradas = candito_set.intersection(vaga_set)

    return list(habilidades_encontradas)

def gerar_recomendacao(skills_candidato, skills_vaga):
    skills_faltantes = set(skills_vaga) - set(skills_candidato)
    if not skills_faltantes:
        return "Candidato ideal para as habilidades desta vaga!"
    return f"Recomendação: O candidato pode se aperfeiçoar em: {', '.join(skills_faltantes)}"

def gerar_candidatos_amostra():
    return [{'nome': 'Ana Júlia dos Santos Ferreira', 'idade': 28,'raca': 'Preta',
        'genero': 'Feminino','is_pcd': False,'cluster_origem':'CAMPECHE', 
        'municipio': 'Florianópolis', 'lat': -27.68, 'long':-48.48, 'skills': ['React', 
        'Node.js', 'SQL'], 'seniority':'Pleno'}, {'nome': 'Carlos Eduardo Ribeiro Filho', 
        'idade': 35, 'raca': 'Pardo', 'genero': 'Masculino', 'is_pcd': True, 'cluster_origem':
        'SAO_JOSE_KOBRASOL', 'municipio':'São José', 'lat': -27.595, 'long':-48.63, 'skills': 
        ['Python', 'Django', 'PostgreSQL'], 'seniority':'Senior'},{'nome': 'Jade Cavalcanti Prado', 
        'idade': 24, 'raca': 'Branca', 'genero': 'Não-Binário', 'is_pcd': False, 'cluster_origem':'PALHOCA_PEDRA_BRANCA', 
        'municipio':'Palhoça', 'lat': -27.625, 'long':-48.69, 'skills': ['React', 'TypeScript', 
        'Figma'],'seniority':'Junior'},{'nome': 'Mayara Tembé Tukano', 'idade': 31, 'raca':'Indígena',
        'genero': 'Feminino', 'is_pcd': False, 'cluster_origem':'BIGUACU_BR101_NORTE', 'municipio':'Biguaçu', 
        'lat': -27.495, 'long':-48.655, 'skills': ['Java', 'Spring Boot', 'SQL'],'seniority':'Pleno'},
        {'nome': 'Roberto Albuquerque Schmidt', 'idade': 42, 'raca': 'Branco',
        'genero': 'Masculino', 'is_pcd': False, 'cluster_origem':'UFSC', 
        'municipio':'Florianópolis', 'lat': -27.5969, 'long':-48.55, 'skills': 
        ['Node.js', 'AWS', 'Docker'],'seniority':'Senior'},{'nome':'Aline Maria da Silva Quadros', 'idade': 23, 
        'raca': 'Parda', 'genero': 'Feminino', 'is_pcd': False, 'cluster_origem':'SAO_JOSE_CENTRO', 
        'municipio':'São José', 'lat': -27.61, 'long': -48.618, 'skills': ['React', 'Next.js', 
        'GraphQL'], 'seniority':'Junior'},{'nome': 'Kenji Takahashi', 'idade': 29, 'raca': 'Amarelo',
        'genero': 'Masculino', 'is_pcd': False, 'cluster_origem':'PALHOCA_CENTRO', 
        'municipio':'Palhoça', 'lat': -27.645, 'long':-48.67, 'skills': 
        ['Python', 'Flask', 'MongoDB'], 'seniority':'Pleno'}, {'nome':'Beatriz Rezende Barbosa', 'idade': 38, 
        'raca': 'Branca','genero': 'Feminino', 'is_pcd': True, 'cluster_origem':'CBD_BEIRAMAR', 
        'municipio':'Florianópolis', 'lat': -27.5954, 'long': -48.548, 'skills': ['Java', 
        'Microserviços', 'Oracle'],'seniority':'Senior'}, {'nome': 'Alex Souza de Moura', 'idade': 26, 'raca': 'Preto',
        'genero': 'Masculino', 'is_pcd': False, 'cluster_origem':'TRINDADE', 'municipio':
        'Florianópolis', 'lat': -27.6011, 'long':-48.532, 'skills': ['React', 'Tailwind','Git'],'seniority':'Junior'},
        {'nome':'Marcelo Oliveira de Souza', 'idade': 45, 'raca': 'Pardo',
        'genero': 'Masculino','is_pcd': False, 'cluster_origem':'SAO_JOSE_BARREIROS', 
        'municipio':'São José', 'lat': -27.645, 'long':-48.65, 'skills':['Python', 'FastAPI', 
        'Kubernetes'],'seniority':'Senior'}]

try:
    # Entrada de dados
    payload = json.loads(sys.stdin.read())

    # ... mais processamento ...

    candidatos = payload.get("candidatos", [])
    if not candidatos:
        candidatos = gerar_candidatos_amostra()
    
    vaga = payload['vaga']

    shortlist = []
    for c in candidatos:
            resultado = processar_math(c, vaga)
            shortlist.append(resultado)

    # Ordenar por score_match decrescente
    shortlist_ordenada = sorted(shortlist, key=lambda x: x['score_match'], reverse=True)

    result = {
        "success": True,
        "shortlist": shortlist_ordenada
    }

    logging.debug(result)

    # Apenas uma saída
    sys.stdout.write(json.dumps(result))

except Exception as e:
    print(json.dumps({
        "success": False,
        "error": str(e)
    }))
    sys.exit(1)
