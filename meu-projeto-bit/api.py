'''
Esse espaço foi criado para deixar mais fácil
a integração do código Python Laravel.
'''
from flask import Flask, request, jsonify
import processador
from dados import lista_candidatos

app = Flask(__name__)

@app.route('/match', methods=['POST'])

def match():
    dados_recebidos = request.get_json()
    vaga = dados_recebidos['vaga']

    shortlist = []
    for candidato in lista_candidatos:
        resultado = processador.processar_match(candidato, vaga)
        shortlist.append(resultado)

    shortlist_ordenada = sorted(shortlist, key=lambda x: x['score_match'], reverse=True)

    return jsonify({'candidatos': shortlist_ordenada})

if __name__ == '__main__':
    app.run(debug=True, port=5000)