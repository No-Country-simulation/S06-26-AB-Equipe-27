# SkillFocus — Plataforma de Matching Inclusivo (B2B)

> Plataforma web responsiva (PWA) que permite conectar empresas a profissionais de grupos sub-representados, utilizando matching inteligente, métricas de diversidade e análise geográfica baseada em dados de concentração de talentos.

**Hackathon NoCountry** · Setor: HRTech / ESG Tech · Web App Development
**Equipe 27** — `S06-26-AB-Equipe-27` · Em andamento

---
![Size](https://img.shields.io/github/repo-size/No-Country-simulation/S06-26-AB-Equipe-27?style=flat&logo=github&logoColor=white&logoSize=auto)
![Commits](https://img.shields.io/github/commit-activity/m/No-Country-simulation/S06-26-AB-Equipe-27/dev?style=flat&logo=github&logoColor=white&logoSize=auto)
---

## 🎯 O Problema

Empresas que possuem metas ESG enfrentam dificuldades para encontrar, atrair e contratar talentos de grupos sub-representados de forma eficiente e sem vieses.

Além disso, muitas organizações não possuem:

* Dados confiáveis sobre diversidade em seus processos seletivos;
* Ferramentas para medir impacto e evolução das metas ESG;
* Visibilidade sobre onde estão os talentos disponíveis;
* Mecanismos para reduzir vieses inconscientes durante a seleção.

O SkillFocus busca transformar a diversidade em uma estratégia de negócio baseada em dados, impacto mensurável e oportunidades reais.

---

## 💡 A Solução

A plataforma centraliza recrutamento inclusivo em um único ambiente digital, oferecendo:

* Matching inteligente entre vagas e candidatos;
* Filtros de diversidade e mecanismos anti-viés;
* Dashboard de métricas ESG;
* Relatórios de diversidade;
* Insights geográficos utilizando dados do Vísent CDRView.

---

## 🧩 Os 5 Serviços

O SkillFocus foi projetado para oferecer cinco serviços integrados. O escopo desta versão abrange exclusivamente a funcionalidade de Empregabilidade, enquanto os demais módulos permanecem previstos para futuras evoluções da plataforma.

| # | Serviço                        | O que faz                                                             |
| - | ------------------------------ | --------------------------------------------------------------------- |
| 1 | **Formações**                  | Trilhas de capacitação para RH e lideranças em diversidade e inclusão |
| 2 | **Empregabilidade**            | Publicação de vagas e matching inteligente com candidatos             |
| 3 | **Experiências Estruturantes** | Eventos e palestras com líderes de grupos sub-representados           |
| 4 | **Mentorias**                  | Conexão entre empresas e especialistas em diversidade                 |
| 5 | **Saúde do Time**              | Dashboard de bem-estar baseado em dados anonimizados                  |

---

### Fluxo do usuário 

1. Empresa se cadastra e configura perfil de diversidade e metas ESG
2. Publica vaga com requisitos técnicos e filtros de diversidade
3. Agente retorna shortlist com score de compatibilidade e badge de diversidade
4. Visualiza mapa de concentração de talentos por região (Vísent CDRView)
5. Seleciona candidatos e inicia processo de contato
6. Dashboard atualiza métricas de diversidade em tempo real

---

## 🚀 Instruções de Uso

Requisitos:

```bash
- PHP
- Composer
- XAMPP (ou outro ambiente com Apache/MySQL)
- Git
```

1. Clone a branch dev com o comando via terminal: 

```bash
git clone -b dev https://github.com/No-Country-simulation/S06-26-AB-Equipe-27.git
```

2. Entre na pasta
```bash
cd S06-26-AB-Equipe-27
```

3. Instalar Dependências

```bash
composer install
```

4. Crie uma cópia do arquivo “.env.example” e renomeie-o para “.env”

5. Crie a chave da aplicação Laravel:

```bash
 php artisan key:generate
```

6. Execute as migrations para criar as tabelas necessárias no banco de dados.

```bash
php artisan migrate
```

7. Use o comando “php artisan serve” para iniciar servidor local. 

```bash
php artisan serve
```


---

## 🛠 Tecnologias Utilizadas

### Frontend

![HTML5](https://img.shields.io/badge/HTML5-white?style=flat&logo=html5&logoColor=E34F26&logoSize=auto)
![CSS3](https://img.shields.io/badge/CSS3-white?style=flat&logo=css3&logoColor=1572B6&logoSize=auto)
![Bootstrap](https://img.shields.io/badge/Bootstrap-white?style=flat&logo=bootstrap&logoColor=7952B3&logoSize=auto)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-white?style=flat&logo=tailwindcss&logoColor=06B6D4&logoSize=auto)
![JavaScript](https://img.shields.io/badge/JavaScript-white?style=flat&logo=javascript&logoColor=F7DF1E&logoSize=auto)

### Backend

![Laravel](https://img.shields.io/badge/Laravel-white?style=flat&logo=laravel&logoColor=FF2D20&logoSize=auto)
![PHP](https://img.shields.io/badge/PHP-white?style=flat&logo=php&logoColor=777BB4&logoSize=auto)
![Python](https://img.shields.io/badge/Python-white?style=flat&logo=python&logoColor=3776AB&logoSize=auto)

### Banco de Dados

![MySQL](https://img.shields.io/badge/MySQL-white?style=flat&logo=mysql&logoColor=4479A1&logoSize=auto)

### Ferramentas

![Git](https://img.shields.io/badge/Git-white?style=flat&logo=git&logoColor=F05032&logoSize=auto)
![GitHub](https://img.shields.io/badge/GitHub-white?style=flat&logo=github&logoColor=181717&logoSize=auto)
![VS Code](https://img.shields.io/badge/VS_Code-white?style=flat&logo=visualstudiocode&logoColor=007ACC&logoSize=auto)
![Trello](https://img.shields.io/badge/Trello-white?style=flat&logo=trello&logoColor=0052CC&logoSize=auto)
![Notion](https://img.shields.io/badge/Notion-white?style=flat&logo=notion&logoColor=000000&logoSize=auto)
![Inteligência Artificial](https://img.shields.io/badge/IA-white?style=flat&logo=openai&logoColor=412991&logoSize=auto)


---

## 📡 API

| Método | Endpoint | Request | Response |
| :--- | :--- | :--- | :--- |
| **POST** | `/match` | `{ empresa_id, vaga: { titulo, skills, nivel, regiao }, filtros: { anti_vies, diversidade_minima } }` | `{ candidatos: [{ candidato_id, nome, score_match, badge_diversidade, skills, lat, lng }], total_analisados, diversidade_resultado }` |
| **GET** | `/insights` | N/A | ` { mapa_talentos: [{ regiao, concentracao, cobertura_rede, perfis_disponiveis }] }` |


---

## 🗺 Integração com Dataset Vísent CDRView

O projeto utiliza dados do Vísent CDRView para identificar:

* Concentração de talentos por região;
* Cobertura de rede móvel (3G, 4G e 5G);
* Distribuição geográfica de candidatos;
* Insights para estratégias de recrutamento inclusivo.

---

### Estrutura do repositório
```
.
├── app/
├── bootstrap/
├── config/
├── database/
├── meu-projeto-bit/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── composer.json
├── package.json
└── README.md
```
---

## ✅ Escopo do MVP

* [x] Publicação de vaga com skills, nível e região
* [ ] Endpoint/match com shortlist + score de compatibilidade + badge de diversidade
* [ ] Interface responsiva com tela de shortlist
* [x] Métricas básicas de diversidade
* [x] README com instruções de execução local e exemplos de request/response

---

## 📄 Licença

*Este projeto foi desenvolvido para o desafio App BiT da Wongola durante o Hackathon NoCountry. Este projeto faz parte de um desafio com uma empresa real e não implica vínculo empregatício.*

---

<div align="center">

*Inove · Impacte · Transforme* 🖤

*Wongola / Black in Tech — 2026*

</div>
