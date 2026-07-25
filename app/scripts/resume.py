import json
import sys
import os
import base64
import time
import traceback
import warnings
import io
import unicodedata
from io import BytesIO
import PyPDF2

PY3 = sys.version_info[0] >= 3

if PY3:
    warnings.filterwarnings("ignore")
    try:
        sys.stdout.reconfigure(encoding='utf-8', errors='backslashreplace')
        sys.stderr.reconfigure(encoding='utf-8', errors='backslashreplace')
    except Exception:
        try:
            sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8', errors='backslashreplace', line_buffering=True)
            sys.stderr = io.TextIOWrapper(sys.stderr.buffer, encoding='utf-8', errors='backslashreplace', line_buffering=True)
        except Exception:
            pass
    os.environ.setdefault('PYTHONIOENCODING', 'utf-8')
    os.environ.setdefault('PYTHONUTF8', '1')

try:
    from google import genai as _genai_new
    _NEW_SDK = True
except ImportError:
    _NEW_SDK = False
    with warnings.catch_warnings():
        warnings.simplefilter("ignore")
        import google.generativeai as genai_legacy


def _fix_encoding(s):
    """Tenta consertar strings com encoding quebrado (CP1252/latin1 -> UTF-8 mojibake)."""
    if not isinstance(s, str):
        return s
    if not s:
        return s
    bad_markers = [
        '\ufffd', 'Ã§', 'Ã£', 'Ã¡', 'Ã©', 'Ã­', 'Ã³', 'Ãº',
        'Ã¢', 'Ãª', 'Ã´', 'Ã±', 'Ã¼', 'Ã‘', 'â‚¬', 'ï¿½'
    ]
    has_bad = any(b in s for b in bad_markers) or '\ufffd' in s
    attempt = s
    if has_bad:
        for enc in ['latin-1', 'cp1252', 'cp850', 'iso-8859-1']:
            try:
                raw = attempt.encode(enc, errors='ignore')
                decoded = raw.decode('utf-8', errors='replace')
                if decoded and '\ufffd' not in decoded[:min(len(decoded), 200)]:
                    attempt = decoded
                    break
            except Exception:
                continue
    try:
        normalized = unicodedata.normalize('NFKC', attempt)
    except Exception:
        normalized = attempt
    return normalized


def _recursive_fix(obj):
    """Aplica _fix_encoding recursivamente em strings de estruturas JSON."""
    if isinstance(obj, str):
        return _fix_encoding(obj)
    if isinstance(obj, list):
        return [_recursive_fix(x) for x in obj]
    if isinstance(obj, dict):
        return {_recursive_fix(k): _recursive_fix(v) for k, v in obj.items()}
    return obj


def eprint(*args, **kwargs):
    """Escreve no stderr — capturado pelo PythonService e logado no Laravel."""
    print(*args, file=sys.stderr, **kwargs)


def log(tag, payload=None):
    """Log estruturado para stderr (JSON-lines)."""
    line = {"ts": time.strftime("%Y-%m-%dT%H:%M:%S%z"), "tag": tag}
    if payload is not None:
        line["payload"] = payload
    try:
        eprint(json.dumps(line, ensure_ascii=False, default=str))
    except Exception:
        eprint(f"[{tag}] {str(payload)}")


def _gemini_generate(prompt, api_key, model_name=None):
    """Wrapper compatível com google-genai (novo) e google-generativeai (antigo).
    Usa uma cadeia de modelos como fallback caso o primeiro esteja indisponível."""
    model_candidates = []
    if model_name:
        model_candidates.append(model_name)
    model_candidates += [
        'gemini-3.5-flash-lite',
        'gemini-3.1-flash-lite',
    ]
    model_candidates = list(dict.fromkeys(model_candidates))
    last_err = None
    for m in model_candidates:
        try:
            log("gemini:modelo:tentativa", {"model": m})
            if _NEW_SDK:
                client = _genai_new.Client(api_key=api_key)
                response = client.models.generate_content(model=m, contents=prompt)
                texto = response.text or ""
            else:
                genai_legacy.configure(api_key=api_key)
                model = genai_legacy.GenerativeModel(m)
                response = model.generate_content(prompt)
                texto = response.text or ""
            log("gemini:modelo:sucesso", {"model": m, "chars": len(texto)})
            return _fix_encoding(texto)
        except Exception as e:
            last_err = e
            log("gemini:modelo:falhou", {"model": m, "error": type(e).__name__ + ": " + str(e)[:200]})
            continue
    raise last_err if last_err else RuntimeError("Nenhum modelo Gemini disponível")


def extrair_texto_pdf(arquivo_pdf):
    log("pdf:extrair:inicio")
    texto = ""
    leitor = PyPDF2.PdfReader(arquivo_pdf)
    for i, pagina in enumerate(leitor.pages):
        texto_pagina = pagina.extract_text() or ""
        texto_pagina = _fix_encoding(texto_pagina)
        log("pdf:pagina", {"pagina": i + 1, "chars": len(texto_pagina)})
        texto += texto_pagina
    texto = _fix_encoding(texto)
    log("pdf:extrair:fim", {"total_chars": len(texto), "total_paginas": len(leitor.pages)})
    return texto


def extrair_dados_candidato(texto_curriculo, api_key):
    log("gemini:extrair:inicio", {
        "api_key_set": bool(api_key and str(api_key).strip()),
        "api_key_length": len(str(api_key or "")),
        "texto_curriculo_chars": len(texto_curriculo),
    })

    prompt = f"""
    Você é um sistema especializado em extração de informações de currículos.

    Analise o currículo abaixo e extraia as seguintes informações, de forma estruturada:

    DADOS PESSOAIS
    - nome completo (nome)
    - email
    - telefone (telefone)
    - cidade
    - estado
    - linkedin (URL do LinkedIn, se existir)
    - portfolio (URL do portfólio / GitHub, se existir)

    PERFIL PROFISSIONAL
    - cargo_atual: título do cargo atual ou último cargo
    - empresa_atual: empresa atual ou última empresa
    - anos_experiencia: número total aproximado de anos de experiência profissional (inteiro)
    - resumo_profissional: resumo profissional / objetivo do currículo (1-3 frases)
    - skills: lista de habilidades / competências técnicas
    - idiomas: lista de objetos com {{"nome": "Inglês", "nivel": "Fluente"}}. Níveis aceitos: Básico, Intermediário, Avançado, Fluente, Nativo.

    EXPERIÊNCIA PROFISSIONAL (ordenada da mais recente para mais antiga)
    - experiencia: lista de objetos, cada um com:
        {{"empresa": "nome da empresa",
          "cargo": "cargo exercido",
          "ano_inicio": "ano de início (ex: 2022) ou mês/ano (ex: jan/2022)",
          "ano_fim": "ano de término ou string 'Presente' se for o emprego atual"}}

    FORMAÇÃO ACADÊMICA
    - educacao: lista de objetos, cada um com:
        {{"grau": "nome do curso / grau (ex: Bacharelado em Ciência da Computação)",
          "instituicao": "nome da faculdade / escola",
          "ano_inicio": "ano de início ou vazio se desconhecido",
          "ano_fim": "ano de conclusão ou vazio se em andamento"}}

    PREFERÊNCIAS DE VAGA (se houver menção no objetivo / resumo, senão vazios)
    - cargo_desejado: cargo pretendido
    - tipo_contrato: lista com um ou mais de: Full-time, Part-time, Contract, Internship
    - modelo_trabalho: lista com um ou mais de: Remote, Hybrid, On-site
    - expectativa_salarial: valor numérico (se mencionado), senão ""
    - moeda_salarial: BRL / USD / EUR (se mencionado), senão ""
    - disponibilidade: um dos valores: Immediately, 2 weeks, 1 month, Custom (se mencionado) ou ""

    Se alguma informação não estiver presente no currículo, retorne uma string vazia, 0 (para número) ou lista vazia para esse campo.
    NÃO invente informações. NÃO retorne dados que não existam no texto.

    CURRÍCULO:
    {texto_curriculo}

    Responda APENAS com um JSON válido, usando exatamente a estrutura abaixo.
    Use a codificação UTF-8.
    {{
    "nome": "",
    "email": "",
    "telefone": "",
    "cidade": "",
    "estado": "",
    "linkedin": "",
    "portfolio": "",
    "cargo_atual": "",
    "empresa_atual": "",
    "anos_experiencia": 0,
    "resumo_profissional": "",
    "skills": [],
    "idiomas": [{{"nome": "", "nivel": ""}}],
    "experiencia": [{{"empresa": "", "cargo": "", "ano_inicio": "", "ano_fim": ""}}],
    "educacao": [{{"grau": "", "instituicao": "", "ano_inicio": "", "ano_fim": ""}}],
    "cargo_desejado": "",
    "tipo_contrato": [],
    "modelo_trabalho": [],
    "expectativa_salarial": "",
    "moeda_salarial": "",
    "disponibilidade": ""
    }}
    Não escreva nenhum texto antes ou depois do JSON.
    """

    started = time.time()
    try:
        texto_resposta = _gemini_generate(prompt, api_key).strip()
    except Exception as e:
        log("gemini:chamada:erro", {
            "error": str(e),
            "trace": traceback.format_exc(limit=5),
            "elapsed_sec": round(time.time() - started, 3),
        })
        raise

    elapsed = round(time.time() - started, 3)
    log("gemini:chamada:fim", {
        "elapsed_sec": elapsed,
        "prompt_chars": len(prompt),
        "response_chars": len(texto_resposta),
        "has_text": bool(texto_resposta),
        "raw_response_preview": texto_resposta[:400],
    })

    texto_limpo = texto_resposta.replace("```json", "").replace("```", "").strip()
    log("gemini:resposta:limpa", {"limpo_chars": len(texto_limpo), "limpo_preview": texto_limpo[:400]})

    _default = {
        "nome": "", "email": "", "telefone": "", "cidade": "", "estado": "",
        "linkedin": "", "portfolio": "",
        "cargo_atual": "", "empresa_atual": "", "anos_experiencia": 0,
        "resumo_profissional": "", "skills": [], "idiomas": [],
        "experiencia": [], "educacao": [],
        "cargo_desejado": "", "tipo_contrato": [], "modelo_trabalho": [],
        "expectativa_salarial": "", "moeda_salarial": "", "disponibilidade": ""
    }

    try:
        dados_candidato = json.loads(texto_limpo)
        dados_candidato = _recursive_fix(dados_candidato)
        for k, v in _default.items():
            if k not in dados_candidato:
                dados_candidato[k] = v
        log("extracao:sucesso", {
            "keys": sorted(list(dados_candidato.keys())),
            "skills_count": len(dados_candidato.get("skills", [])),
            "experiencia_count": len(dados_candidato.get("experiencia", [])),
            "educacao_count": len(dados_candidato.get("educacao", [])),
            "idiomas_count": len(dados_candidato.get("idiomas", [])),
        })
        return dados_candidato
    except json.JSONDecodeError as e:
        log("extracao:json_decode_error", {
            "error": str(e),
            "lineno": e.lineno,
            "colno": e.colno,
            "texto_completo": texto_limpo,
        })
        return {**_default, "erro": "Erro ao processar os dados do currículo."}


def criar_perfil_protegido(dados_candidato):
    perfil_protegido = {"estado": dados_candidato.get("estado", ""),
                        "formacao": dados_candidato.get("formacao", dados_candidato.get("educacao", [])),
                        "skills": dados_candidato.get("skills", [])}
    return perfil_protegido


def calcular_match_ia(candidato, vaga, api_key):
    prompt = f"""
você é um especialista em recrutamento e inclusão. Avalie a compatibilidade
entre o candidato e a vaga abaixo.

DADOS DA VAGA:
Título: {vaga.get('titulo')}
Senioridade exigida: {vaga.get('seniority')}
Skills obrigatórias: {', '.join(vaga.get('skills_obrigatorias',[]))}
Skills desejáveis: {', '.join(vaga.get('skills_desejaveis', []))}

DADOS DO CANDIDATO:
Senioridade: {candidato.get('seniority')}
Skills: {', '.join(candidato.get('skills', []))}

Responda APENAS com um JSON válido, no formato exato abaixo,
sem nenhum texto antes ou depois:
{{"score": (número de 0 a 100, representando o percentual de compatibilidade),
"justificativa": "(explicação curta, em português, do porquê dessa pontuação)"}}
"""
    texto_resposta = _gemini_generate(prompt, api_key).strip()
    texto_limpo = texto_resposta.replace("```json", "").replace("```", "").strip()

    try:
        resultado = json.loads(texto_limpo)
        return resultado
    except json.JSONDecodeError:
        return {"score": 0, "justificativa": "Erro ao processar resposta da IA."}


try:
    started_all = time.time()
    raw_stdin = sys.stdin.read()
    log("stdin:recebido", {"length": len(raw_stdin)})

    payload = json.loads(raw_stdin)
    api_key = os.getenv("GEMINI_API_KEY")
    action = payload.get("action")
    log("acao:inicio", {"action": action, "api_key_set": bool(api_key and str(api_key).strip())})

    result = {"success": True}

    if action == "extract":
        pdf_base64 = payload.get("pdf_base64", "")
        log("extract:pdf:decodificar", {"base64_length": len(pdf_base64)})
        pdf_bytes = base64.b64decode(pdf_base64)
        pdf_file = BytesIO(pdf_bytes)

        texto_curriculo = extrair_texto_pdf(pdf_file)
        dados_candidato = extrair_dados_candidato(texto_curriculo, api_key)
        perfil_protegido = criar_perfil_protegido(dados_candidato)

        result["dados_candidato"] = dados_candidato
        result["perfil_protegido"] = perfil_protegido
        result["meta"] = {
            "elapsed_sec_total": round(time.time() - started_all, 3),
            "pdf_bytes": len(pdf_bytes),
            "texto_curriculo_chars": len(texto_curriculo),
        }
    elif action == "match":
        candidato = payload.get("candidato")
        vaga = payload.get("vaga")
        resultado_match = calcular_match_ia(candidato, vaga, api_key)
        result["match"] = resultado_match
    else:
        result = {"success": False, "error": "Ação inválida"}
        log("acao:invalida", {"action": action})

    result = _recursive_fix(result)

    log("acao:fim", {
        "action": action,
        "elapsed_sec_total": round(time.time() - started_all, 3),
        "success": result.get("success"),
        "result_keys": list(result.keys()),
    })

    stdout = json.dumps(result, ensure_ascii=False)
    log("stdout:escrever", {"length": len(stdout)})
    if hasattr(sys.stdout, 'buffer'):
        sys.stdout.buffer.write((stdout + "\n").encode('utf-8', errors='backslashreplace'))
        try:
            sys.stdout.buffer.flush()
        except Exception:
            pass
    else:
        sys.stdout.write(stdout)
        sys.stdout.flush()

except Exception as e:
    log("fatal:exception", {
        "error": str(e),
        "trace": traceback.format_exc(limit=10),
    })
    err_result = _recursive_fix({
        "success": False,
        "error": str(e),
        "trace": traceback.format_exc(limit=8),
    })
    stdout_err = json.dumps(err_result, ensure_ascii=False)
    if hasattr(sys.stdout, 'buffer'):
        sys.stdout.buffer.write((stdout_err + "\n").encode('utf-8', errors='backslashreplace'))
    else:
        sys.stdout.write(stdout_err)
    sys.exit(1)
