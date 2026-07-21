'''
Esse espaço foi criado para deixar mais fácil
a integração do código Python Laravel.
'''
from flask import Flask, request, jsonify
import processador
from dados import lista_candidatos
from ai_service import(extrair_texto_pdf, extrair_dados_candidato, 
                criar_perfil_protegido)

app = Flask(__name__)

@app.route('/processar-curriculo', methods=['POST'])
def processar_curriculo():

    if 'arquivo' not in request.files:
        return jsonify({
            'erro': 'Nenhum arquivo foi enviado.'
        }), 400

    arquivo = request.files['arquivo']

    texto_curriculo = extrair_texto_pdf(arquivo)

    dados_candidato = extrair_dados_candidato(texto_curriculo)

    perfil_protegido = criar_perfil_protegido(dados_candidato)

    return jsonify({'dados_candidato': dados_candidato, 
                'perfil_protegido': perfil_protegido})

@app.route('/match', methods=['POST'])

def match():
    dados_recebidos = request.get_json()
    vaga = dados_recebidos['vaga']

    shortlist = []
    for candidato in lista_candidatos:
        resultado = processador.processar_match(candidato, vaga)
        shortlist.append(resultado)

    shortlist_ordenada = sorted(shortlist, key=lambda x: x['score_match'], reverse=True)

    #Verificado que está faltando algumas coisas que é solicitada no projeto.

    total_analisados = len(shortlist_ordenada)
    total_diversidade = sum(1 for c in shortlist_ordenada if c['badge_diversidade'] == 'Badge: Diversidade')
    diversidade_resultado = round((total_diversidade / total_analisados) * 100, 2) if total_analisados > 0 else 0

    return jsonify({'candidatos': shortlist_ordenada,
                    'total_analisados': total_analisados,
                    'diversidade_resultado': diversidade_resultado})
'''
GET /insights
Response: { mapa_talentos: 
[{ regiao, concentracao, cobertura_rede, perfis_disponiveis }] }
'''
@app.route('/insights', methods=['GET'])

def insights():
    dados_geo = processador.processar_dados_geograficos(lista_candidatos)
    return jsonify({'mapa_talentos': dados_geo})

if __name__ == '__main__':
    app.run(debug=True, port=5000)