import pandas as pd

def mascarar_dados(dados):
    df = pd.DataFrame([dados])

    colunas_remover = ['nome','idade','genero', 'cidade']
    df_limpo = df.drop(columns=colunas_remover, errors='ignore')

    resultado =  df_limpo.to_dict(orient='records')

    if len(resultado) > 0:
        return resultado[0]
    else:
        return {"erro": "Nenhum dado restou após a máscara"}