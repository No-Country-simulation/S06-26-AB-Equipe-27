"""
- Métrica de Diversidade (Badge)
- Pontuação do Currículo (Score)
- Processamento de Linguagem Natural (NLP)
- Mascarar dados do usuário
- Geolocalização
- Recomendações do currículo
Autora: Aylin Bochi
Empresa: SkillFocus
"""
import processador
import json
from dados import lista_candidatos, vagas

# Removi os dados daqui, e passei para o arquivo dados.

vagas_final = vagas['vaga_3']
def main ():
    
    insigths_geo = processador.processar_dados_geograficos(lista_candidatos)

    print('---------------INSIGHTS DE CONCENTRAÇÃO GEOGRÁFICA ---------------')
    print(json.dumps(insigths_geo, indent=4))
    print('\n')
    
    shortlist = []
    for c in lista_candidatos:
        resultado = processador.processar_match(c,vagas_final)
        shortlist.append(resultado)
    
    shortlist_ordenada = sorted(shortlist, key=lambda x: x['score_match'], reverse=True)
    print('--------------SHORTLIST PARA RECRUTADOR----------------')
    print(json.dumps(shortlist_ordenada, indent=4))

if __name__=='__main__':
    main()