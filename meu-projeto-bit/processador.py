import pandas as pd

lista_candidatos = [{'nome': 'Ana Júlia dos Santos Ferreira', 'idade': 28,'raca': 'Preta',
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
    
vagas = {'vaga_1':{'titulo': 'Desenvolvedor(a) Back-end Sênior',
                    'seniority': 'Senior',
                    'skills_obrigatorias': ['PHP', 'Laravel', 'MySQL'],
                    'skills_desejaveis': ['Python', 'FastAPI', 'Microsserviços'],
                    'municipio': 'Florianópolis',
                    'cluster_origem': 'UFSC'},
        
        'vaga_2':{'titulo': 'Cientista de Dados',
                'seniority':'Junior',
                'skills_obrigatorias': ['Python', 'SQL'] ,
                'skills_desejaveis': ['PySpark', 'AWS', 'GCP'],
                'municipio': 'São José',
                'cluster_origem': 'SAO_JOSE_KOBRASOL'},
        
        'vaga_3':{'titulo': 'Desenvolvedor(a) Front-end',
                'seniority': ' Pleno',
                'skills_obrigatorias': ['React', 'TypeScript', 'Node.js', 'CSS-in-JS'],
                'skills_desejaveis': ['UI/UX', 'Scrum', 'TailwindCSS'],
                'municipio': 'Palhoça',
                'cluster_origem': 'PALHOCA_PEDRA_BRANCA'}
}
def mascarar_dados(candidato_completo):

    colunas_para_esconder = ['nome', 'idade', 'raca', 'genero', 'is_pcd', 
                            'municipio', 'lat', 'long']
    candidato_mascarado = {k: v for k, v in candidato_completo.items() if k not in colunas_para_esconder}
    return candidato_mascarado

def processar_math(candidato, vaga):
    
    badge = 'Badge: Diversidade' if (candidato['genero'] == 'Feminino' 
                            or candidato['is_pcd']) else 'Badge: Padrão'
    score = 0

    skill_match = processador_nlp(candidato['skills'], vaga['skills_obrigatorias'])
    recomendacao = gerar_recomendacao(candidato['skills'], vaga['skills_obrigatorias'])
    for skill in vaga ['skills_obrigatorias']:
        if skill in candidato['skills']: score += 20
    
    dados_para_recrutador = mascarar_dados(candidato)

    dados_para_recrutador ['score_match'] = score
    dados_para_recrutador ['badge_diversidade'] = badge
    dados_para_recrutador ['recomendacao'] = recomendacao
    
    return dados_para_recrutador

def processador_nlp(skills_candidatos,skills_vaga):
    
    candito_set = set(skills_candidatos)
    vaga_set = set(skills_vaga)

    habilidades_encontradas = candito_set.intersection(vaga_set)
    return list(habilidades_encontradas)

def gerar_recomendacao(skills_candidato, skills_vaga):

    skills_faltantes = set(skills_vaga) - set(skills_candidato)
    if not skills_faltantes:
        return "Candidato ideal para a skills desta vaga!"
    return f"Recomendação: O candidato pode se aperfeiçoar em:{', '.join(skills_faltantes)}"