import processador
import json

nome = input("Nome Completo: ").title().strip()
idade = input("Data de nascimento: ").strip()
genero = input("Qual o gênero que você se define: ").lower().strip()
cidade = input("Cidade: ").title().strip()
estado = input("Estado: ").title().strip()
cargo = input("Cargo Pretendido: ").capitalize().strip()
experiencia = input("Experiência: ").capitalize().strip()
habilidade = input("Habilidades Técnicas: ")# Skills
proficiencia = input("Nível de Proficiência: ").lower().strip()

candidato_original = {'nome': nome,'idade': idade, 'genero':genero,
                'cidade': cidade, 'estado': estado, 'cargo': cargo,
                'experiencia': experiencia, 'habilidade': habilidade,
                'proficiencia': proficiencia}

resultado = processador.mascarar_dados(candidato_original)

json_para_laravel = json.dumps(resultado,indent=4)
print(json_para_laravel)
print(f"Nome, idade, gênero e cidade, ficarão mascarados para analise do currículo {resultado}")