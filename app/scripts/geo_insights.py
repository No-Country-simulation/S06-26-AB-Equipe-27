import json
import sys
import logging

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

try:
    print('---------------INSIGHTS DE CONCENTRAÇÃO GEOGRÁFICA ---------------')
    print(json.dumps(insigths_geo, indent=4))
    print('\n')

    # Entrada de dados
    payload = json.loads(sys.stdin.read())

    # ... mais processamento ...

    candidatos = payload.get("candidatos", [])
    # if not candidatos:
    #     candidatos = gerar_candidatos_amostra()
    
    candidatos = payload['candidatos']

    insigths_geo = processar_dados_geograficos(candidatos)

    result = {
        "success": True,
        "geo_insights": insights_geo
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
