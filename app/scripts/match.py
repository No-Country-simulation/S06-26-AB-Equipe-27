import json
import sys
import logging
import hashlib


def mascarar_dados(candidato_completo):
    colunas_para_esconder = [
        'nome', 'idade', 'raca', 'genero', 'is_pcd',
        'municipio', 'lat', 'long'
    ]
    return {
        k: v for k, v in candidato_completo.items()
        if k not in colunas_para_esconder
    }


def gerar_external_id(candidato):
    base = f"{candidato.get('nome','')}_{candidato.get('idade','')}_{candidato.get('cluster_origem','')}"
    return hashlib.md5(base.encode()).hexdigest()


def processador_nlp(skills_candidatos, skills_vaga):
    candito_set = {s.lower() for s in skills_candidatos}
    vaga_set = {s.lower() for s in skills_vaga}
    return list(candito_set.intersection(vaga_set))


def gerar_recomendacao(skills_candidato, skills_vaga):
    skills_faltantes = set(skills_vaga) - set(skills_candidato)

    if not skills_faltantes:
        return "Candidato ideal para as habilidades desta vaga!"

    return "Recomendação: O candidato pode se aperfeiçoar em: " + ", ".join(skills_faltantes)


def processar_math(candidato, vaga):

    badge = (
        'Diversidade'
        if (candidato.get('genero') == 'Feminino' or candidato.get('is_pcd'))
        else 'Padrão'
    )

    skills_vaga = vaga.get('skills_obrigatorias', [])

    skill_match = processador_nlp(
        candidato.get('skills', []),
        skills_vaga
    )

    recomendacao = gerar_recomendacao(
        candidato.get('skills', []),
        skills_vaga
    )

    total_skills_exigidas = len(vaga['skills_obrigatorias'])

    if total_skills_exigidas > 0:
        score = (100 / total_skills_exigidas) * len(skill_match)
    else:
        score = 0
    dados = mascarar_dados(candidato)

    dados['external_id'] = gerar_external_id(candidato)
    dados['score_match'] = score
    dados['skills'] = candidato.get('skills', [])
    dados['badge_diversidade'] = badge
    dados['recomendacao'] = recomendacao
    dados['seniority'] = candidato.get('seniority', 'N/A')

    return dados


def gerar_candidatos_amostra():
    return [
        {
            'nome': 'Ana Júlia dos Santos Ferreira',
            'idade': 28,
            'raca': 'Preta',
            'genero': 'Feminino',
            'is_pcd': False,
            'cluster_origem': 'CAMPECHE',
            'municipio': 'Florianópolis',
            'lat': -27.68,
            'long': -48.48,
            'skills': ['React', 'Node.js', 'SQL'],
            'seniority': 'Pleno'
        },
        {
            'nome': 'Carlos Eduardo Ribeiro Filho',
            'idade': 35,
            'raca': 'Pardo',
            'genero': 'Masculino',
            'is_pcd': True,
            'cluster_origem': 'SAO_JOSE_KOBRASOL',
            'municipio': 'São José',
            'lat': -27.595,
            'long': -48.63,
            'skills': ['Python', 'Django', 'PostgreSQL'],
            'seniority': 'Senior'
        },
        {
            'nome': 'Jade Cavalcanti Prado',
            'idade': 24,
            'raca': 'Branca',
            'genero': 'Não-Binário',
            'is_pcd': False,
            'cluster_origem': 'PALHOCA_PEDRA_BRANCA',
            'municipio': 'Palhoça',
            'lat': -27.625,
            'long': -48.69,
            'skills': ['React', 'TypeScript', 'Figma'],
            'seniority': 'Junior'
        },
        {
            'nome': 'Mayara Tembé Tukano',
            'idade': 31,
            'raca': 'Indígena',
            'genero': 'Feminino',
            'is_pcd': False,
            'cluster_origem': 'BIGUACU_BR101_NORTE',
            'municipio': 'Biguaçu',
            'lat': -27.495,
            'long': -48.655,
            'skills': ['Java', 'Spring Boot', 'SQL'],
            'seniority': 'Pleno'
        },
        {
            'nome': 'Roberto Albuquerque Schmidt',
            'idade': 42,
            'raca': 'Branco',
            'genero': 'Masculino',
            'is_pcd': False,
            'cluster_origem': 'UFSC',
            'municipio': 'Florianópolis',
            'lat': -27.5969,
            'long': -48.55,
            'skills': ['Node.js', 'AWS', 'Docker'],
            'seniority': 'Senior'
        },
        {
            'nome': 'Aline Maria da Silva Quadros',
            'idade': 23,
            'raca': 'Parda',
            'genero': 'Feminino',
            'is_pcd': False,
            'cluster_origem': 'SAO_JOSE_CENTRO',
            'municipio': 'São José',
            'lat': -27.61,
            'long': -48.618,
            'skills': ['React', 'Next.js', 'GraphQL'],
            'seniority': 'Junior'
        },
        {
            'nome': 'Kenji Takahashi',
            'idade': 29,
            'raca': 'Amarelo',
            'genero': 'Masculino',
            'is_pcd': False,
            'cluster_origem': 'PALHOCA_CENTRO',
            'municipio': 'Palhoça',
            'lat': -27.645,
            'long': -48.67,
            'skills': ['Python', 'Flask', 'MongoDB'],
            'seniority': 'Pleno'
        },
        {
            'nome': 'Beatriz Rezende Barbosa',
            'idade': 38,
            'raca': 'Branca',
            'genero': 'Feminino',
            'is_pcd': True,
            'cluster_origem': 'CBD_BEIRAMAR',
            'municipio': 'Florianópolis',
            'lat': -27.5954,
            'long': -48.548,
            'skills': ['Java', 'Microserviços', 'Oracle'],
            'seniority': 'Senior'
        },
        {
            'nome': 'Alex Souza de Moura',
            'idade': 26,
            'raca': 'Preto',
            'genero': 'Masculino',
            'is_pcd': False,
            'cluster_origem': 'TRINDADE',
            'municipio': 'Florianópolis',
            'lat': -27.6011,
            'long': -48.532,
            'skills': ['React', 'Tailwind', 'Git'],
            'seniority': 'Junior'
        },
        {
            'nome': 'Marcelo Oliveira de Souza',
            'idade': 45,
            'raca': 'Pardo',
            'genero': 'Masculino',
            'is_pcd': False,
            'cluster_origem': 'SAO_JOSE_BARREIROS',
            'municipio': 'São José',
            'lat': -27.645,
            'long': -48.65,
            'skills': ['Python', 'FastAPI', 'Kubernetes'],
            'seniority': 'Senior'
        }
    ]

try:
    payload = json.loads(sys.stdin.read())

    candidatos = payload.get("candidatos") or gerar_candidatos_amostra()
    vaga = payload.get("vaga", {})

    shortlist = []

    for c in candidatos:
        shortlist.append(processar_math(c, vaga))

    shortlist_ordenada = sorted(
        shortlist,
        key=lambda x: x['score_match'],
        reverse=True
    )

    shortlist_10 = shortlist_ordenada[:10]

    result = {
        "success": True,
        "shortlist": shortlist_10
    }

    sys.stdout.write(json.dumps(result))

except Exception as e:
    sys.stdout.write(json.dumps({
        "success": False,
        "error": str(e)
    }))
    sys.exit(1)
