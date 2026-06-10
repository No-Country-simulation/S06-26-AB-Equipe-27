Problema
Empresas com metas ESG não conseguem encontrar e contratar talentos de grupos sub-representados de forma eficiente e sem viés.

Descrição
## Plataforma de Matching Inclusivo — App BiT (B2B)

O desafio B2B propõe o desenvolvimento de uma web app responsiva com agente de IA que conecta empresas com profissionais de grupos sub-representados, usando dados de geolocalização para identificar concentração de talentos por região e gerar relatórios de diversidade para metas ESG.

Não é apenas uma plataforma de recrutamento.
Não é apenas um painel de métricas.

É uma ferramenta que coloca a diversidade no centro da estratégia de negócio — com dados reais, matching inteligente e impacto mensurável.

---

PERFIL DO USUÁRIO

Recrutadores, gestores de RH e líderes de diversidade em empresas que precisam cumprir metas ESG, contratar talentos de grupos sub-representados e demonstrar impacto real para stakeholders e investidores.

Dores reais que a solução precisa endereçar:
. Dificuldade em encontrar candidatos de grupos sub-representados qualificados
. Processos seletivos com viés inconsciente que perpetuam a exclusão
. Falta de dados confiáveis para embasar decisões de diversidade
. Pressão crescente de investidores e reguladores por metas ESG mensuráveis
. Desconhecimento de onde estão geograficamente os talentos disponíveis

---

OS 5 SERVIÇOS — MVP

1. FORMAÇÕES
Trilhas de capacitação em diversidade e inclusão para equipes de RH e lideranças corporativas. Conteúdos que ajudam a empresa a criar uma cultura inclusiva de dentro para fora.

2. EMPREGABILIDADE
Publicação de vagas com matching inteligente com candidatos do módulo B2C. Score de compatibilidade entre perfil e vaga + badge de diversidade. Filtro anti-viés para reduzir discriminação inconsciente no processo seletivo. A empresa paga um percentual quando efetua a contratação via plataforma.

3. EXPERIÊNCIAS ESTRUTURANTES
Eventos corporativos de diversidade — painéis e palestras com líderes de grupos sub-representados para inspirar a cultura interna da empresa e mostrar o impacto real de times diversos.

4. MENTORIAS
Conexão com líderes de diversidade em outras empresas para troca de boas práticas de inclusão. Networking corporativo orientado por impacto, não apenas por interesse comercial.

5. SAÚDE DO TIME
Dashboard de bem-estar dos colaboradores por perfil e região, alimentado por dados anonimizados do módulo B2C. Permite à empresa identificar onde há riscos de burnout ou exclusão antes que virem problema.

---

FLUXO DO USUÁRIO (RECRUTADOR)

1. Empresa se cadastra e configura perfil de diversidade e metas ESG
2. Publica vaga com requisitos técnicos e filtros de diversidade
3. Agente retorna shortlist com score de compatibilidade e badge de diversidade
4. Visualiza mapa de concentração de talentos por região (Vísent CDRView)
5. Seleciona candidatos e inicia processo de contato
6. Dashboard atualiza métricas de diversidade em tempo real

---

DATASET VÍSENT CDRVIEW

Dados de concentração de pessoas por zona + cobertura de rede ERB (5G/4G/3G) com coordenadas reais de antenas Anatel. Dados emulados com coordenadas reais. Disponível em: github.com/wongola-bit/appbit-hackathon (inclui README e dicionário de colunas).

Uso neste desafio: mapa de concentração de talentos por região — onde há pessoas qualificadas de grupos sub-representados e qual é a qualidade de conectividade nessa zona. Permite à empresa entender geograficamente onde estão os candidatos antes de publicar a vaga.

---

ENDPOINTS PRINCIPAIS

POST /match
Request: { empresa_id, vaga: { titulo, skills, nivel, regiao }, filtros: { anti_vies, diversidade_minima } }
Response: { candidatos: [{ candidato_id, nome, score_match, badge_diversidade, skills, lat, lng }], total_analisados, diversidade_resultado }

GET /insights
Response: { mapa_talentos: [{ regiao, concentracao, cobertura_rede, perfis_disponiveis }] }

---

FUNCIONALIDADES EXIGIDAS — MVP

. Publicação de vaga com skills, nível e região
. Endpoint /match com shortlist + score de compatibilidade + badge de diversidade
. Interface responsiva com tela de shortlist
. Métricas básicas de diversidade
. README com instruções de execução local e exemplos de request/response

---

FUNCIONALIDADES OPCIONAIS

. Mapa interativo via Vísent CDRView — concentração de talentos por zona
. Filtro anti-viés com explicabilidade (por que o candidato foi ou não selecionado)
. Relatório de diversidade exportável em PDF para stakeholders
. Dashboard de saúde do time por perfil e região
. Notificações para recrutadores com novos candidatos compatíveis
. Integração com o módulo B2C para matching em tempo real
. Seção de eventos corporativos de diversidade

---

ORIENTAÇÕES TÉCNICAS

. Plataforma: Web App Responsiva (PWA) — funciona no celular e no desktop. Use a tecnologia que sua equipe já domina: React, Vue, Node.js, Spring Boot, Python, Java ou qualquer outra.
. O stack não é obrigatório — cada equipe escolhe o que melhor conhece.
. Badge de diversidade pode ser campo declarativo simples para o MVP — não precisa ser modelo preditivo.
. O score anti-viés pode ser implementado como funcionalidade opcional se o tempo permitir.
. Comece pelo contrato de integração entre os membros da equipe no Dia 1.
. Nunca suba credenciais ou chaves de API no repositório.
. Deploy: Railway ou Render para o MVP. 

---

POR ONDE COMEÇAR — DIA 1

1. Reunião de equipe: apresentação, divisão de responsabilidades e alinhamento do contrato de integração
2. Configurar ambiente local: repositório GitHub, arquivo .env, banco de dados com perfis de candidatos mockados
3. Dividir as frentes: interface com tela de publicar vaga / API com /match retornando dados mockados / agente com lógica básica de scoring

---

NOTA DE OPORTUNIDADE

Este desafio é parte de um produto maior com alcance em Brasil, Angola e LATAM. Os melhores projetos poderão ser apresentados a investidores reais no Shark Tank BiT para seed funding e contratos piloto. O mercado ESG cresce aceleradamente — uma solução como essa tem potencial de escala global.

---

REFERÊNCIAS CULTURAIS

Os filmes a seguir foram selecionados para ampliar a compreensão sobre a dimensão de impacto que buscamos alcançar — uma abordagem que vá além do assistencialismo e promova autonomia, pertencimento, protagonismo e transformação real.

Filmes:
. The Boy Who Harnessed the Wind — jovem africano que resolve a seca com engenharia e determinação
. Gênio Indomável (Good Will Hunting) — potencial reprimido por falta de oportunidade
. Infinito — superação pessoal e propósito
. À Procura da Felicidade (The Pursuit of Happyness) — resiliência e empreendedorismo desde a adversidade
. Mãos Talentosas (Gifted Hands) — talento que supera barreiras socioeconômicas
. Rainha de Katwe — protagonismo feminino negro em tecnologia

Livros:
. Apaixone-se pelo Problema, Não Pela Solução — Uri Levine (cofundador do Waze)
. De Onde Vêm as Boas Ideias — Steven Johnson
