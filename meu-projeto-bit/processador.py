'''
Buscar dados dinâmicos do DATASET VÍSENT para o Python
Autora: Aylin
Empresa: SkillFocus
'''
import pandas as pd
import os

def processar_dados_geograficos(lista_candidatos):
    
    pasta_atual = os.path.dirname(os.path.abspath(__file__))
    caminho_arquivo = os.path.join(pasta_atual, "data", "tensor_od.csv")

    df_visent = pd.read_csv(caminho_arquivo, skipinitialspace=True)

    print('----------- COLUNAS DO CV -----------')
    print(df_visent.columns.to_list())
    print('----------------------------------')

    df_candidatos = pd.DataFrame(lista_candidatos)

    df_cruzado = pd.merge(
        df_candidatos,
        df_visent,
        on= 'cluster_origem',
        how= 'left'
    )
    
    insights = df_cruzado.groupby('cluster_origem').agg({
        'nome': 'count',
        'n_usuarios':'mean' 
    }).reset_index()

    return insights.to_dict(orient='records')

# Removi os dados daqui, e passei para o arquivo dados.

def mascarar_dados(candidato_completo):

    colunas_para_esconder = ['nome', 'idade', 'raca', 'genero', 'is_pcd', 
                            'municipio', 'lat', 'long']
    candidato_mascarado = {k: v for k, v in candidato_completo.items() if k not in colunas_para_esconder}
    return candidato_mascarado

def processar_match(candidato, vaga):
    
    badge = 'Badge: Diversidade' if (candidato['genero'] == 'Feminino'
                                    or candidato['is_pcd'])else 'Badge: Padrão'
    
    #Correção retirando o score = 0

    skill_match = processador_nlp(candidato['skills'], vaga['skills_obrigatorias'])
    recomendacao = gerar_recomendacao(candidato['skills'], vaga['skills_obrigatorias'])

    # Também retirei um for e um if que tinha nessa parte
    
    total_skills_exigidas = len(vaga['skills_obrigatorias'])

    if total_skills_exigidas > 0:
        score = (100 / total_skills_exigidas) * len(skill_match)
    else:
        score = 0
    
    dados_para_recrutador = mascarar_dados(candidato)

    dados_para_recrutador ['score_match'] = score
    dados_para_recrutador ['skills_em_comum'] = skill_match
    dados_para_recrutador ['badge_diversidade'] = badge
    dados_para_recrutador ['recomendacao'] = recomendacao
    
    return dados_para_recrutador

def processador_nlp(skills_candidatos,skills_vaga):
    
    #Fiz uma alteração nessa parte para evitar erros.

    candito_set = {skill.lower() for skill in skills_candidatos}
    vaga_set = {skill.lower() for skill in skills_vaga}

    habilidades_encontradas = candito_set.intersection(vaga_set)
    return list(habilidades_encontradas)

def gerar_recomendacao(skills_candidato, skills_vaga):

    skills_faltantes = set(skills_vaga) - set(skills_candidato)
    if not skills_faltantes:
        return "Candidato ideal para a skills desta vaga!"
    return f"Recomendação: O candidato pode se aperfeiçoar em:{', '.join(skills_faltantes)}"