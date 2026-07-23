# SkillFocus — S06-26-AB-Equipe-27

Laravel 13 + Python/Flask microservice hackathon project. Inclusive hiring platform with AI matching (Gemini 2.5 Flash), ESG metrics, and geographic talent maps.

## Stack

| Layer | Tech | Key details |
|---|---|---|
| Backend | Laravel 13 / PHP 8.3 | MySQL, SQLite for tests |
| Frontend | Blade + Tailwind CSS v4 + Vite + Bootstrap | PWA with service worker |
| IA microservice | Python / Flask (in `meu-projeto-bit/`) | Gemini 2.5 Flash, pandas |
| Deploy | Docker multi-stage | php:8.3-cli image, serves on `PORT` (default 10000) |

## Repo structure (key dirs)

```
app/
  Http/Controllers/    — 12 controllers (Auth, Setup, Job, Match, Dashboard, etc.)
  Http/Middleware/      — SetupComplete middleware
  Models/               — 8 models (User, Company, Candidate, JobPosting, Matching, etc.)
  Services/             — 5 services (Auth, Job, Match, Python, DiversityScore)
  scripts/              — Python scripts match.py, geo_insights.py (called via `python3` subprocess)
config/                 — Laravel config + PWA manifest
resources/views/        — Blade templates
routes/web.php          — All routes (single file)
meu-projeto-bit/        — Standalone Flask AI microservice (disconnected from Laravel)
docker/nginx/           — Nginx config (for alternate deploy)
conf/ngnix/             — Alternative Nginx site config
```

## Developer commands

```bash
# Full setup
composer run setup

# Dev mode — runs server + queue + logs + Vite concurrently
composer run dev

# Tests (Pest)
composer run test

# Deploy cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Docker — serves on port $PORT (default 10000)
docker build -t skillfocus .
docker run -e PORT=10000 -p 10000:10000 skillfocus
```

## Routes & auth flow

Three middleware groups, applied sequentially:
1. `guest` — register, login, password reset
2. `auth` — logout, email verification
3. `auth` + `verified` — setup wizards (company + candidate)
4. `auth` + `verified` + `setup.complete` — dashboard, jobs, ESG, matches, reports, talent map

Key endpoints:
- `POST /match` — calls `PythonService::execute()` → runs `app/scripts/match.py` with JSON input via stdin
- `POST /match/{jobId}/generate` — triggers match generation (one-shot per job, guarded by `matches_generated` flag)
- Seed route: `/seed-matchings` (hardcoded, creates 15 sample matchings for testing)

## Middleware

- **SetupComplete** (`app/Http/Middleware/SetupComplete.php`): Redirects to `/setup/step1` if `company.setup_completed` is false
- Registered in `bootstrap/app.php` — check there for alias if adding routes

## Matching system (critical)

### Laravel → Python bridge
- `PythonService::execute($data)` sends JSON via stdin to `python3 app/scripts/match.py`
- Python script reads stdin, processes, writes JSON to stdout
- Uses `candidatos` or falls back to hardcoded sample candidates
- Returns top-10 sorted shortlist

### `app/scripts/match.py` vs `meu-projeto-bit/`
- `app/scripts/match.py` = active script called from Laravel at runtime
- `meu-projeto-bit/` = standalone Flask microservice, **not currently connected** to Laravel
- Changes to matching logic should go in `app/scripts/match.py`
- There's a typo: function is named `processar_math` (should be `match`)

### Matching model
- `Matching` (matchings table): stores job_posting_id, company_id, candidate_id, skills (JSON array), seniority, score_match, badge_diversidade, recomendacao, status
- Status can be `selecionado` — set via `match.select` route
- `candidate_id` column was added later (migration `2026_07_21_020850`)

### Duplicated Python code
- Matching logic exists in **3 places**: `app/scripts/match.py`, `meu-projeto-bit/processador.py`, `meu-projeto-bit/api.py`
- `meu-projeto-bit/processador.py` uses `Badge: Diversidade` / `Badge: Padrão` prefix; `app/scripts/match.py` uses bare `Diversidade` / `Padrão`
- `meu-projeto-bit/processador.py` has field `skills_em_comum`; `app/scripts/match.py` returns `skills` instead
- `app/scripts/geo_insights.py` is **broken** — misspelled variable names (`insigths_geo` vs `insights_geo`), missing imports (`import os`, `import pandas as pd`)

## Testing

- **Pest PHP** (v4) with `pestphp/pest-plugin-laravel`
- Tests use SQLite in-memory (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`)
- Only 2 example tests exist (`tests/Feature/ExampleTest.php`, `tests/Unit/ExampleTest.php`)
- `RefreshDatabase` is **commented out** in `tests/Pest.php` — add `->use(RefreshDatabase::class)` for DB-reliant tests

## Important constraints & gotchas

- `.npmrc` sets `ignore-scripts=true` — `npm run build` (via Vite) still works but lifecycle hooks won't
- `.env` shipped with real credentials in MAIL config (relay.dnsexit.com) — do NOT commit to public repos
- Tailwind CSS v4 uses `@import 'tailwindcss'` (no `tailwind.config.js`), theme via `@theme` directive in `resources/css/app.css`
- Blade views use Bootstrap classes AND Tailwind — mixed styling approach
- `geo_insights.py` in `app/scripts/` needs `tensor_od.csv` in `app/scripts/data/` (doesn't exist yet)
- `app/scripts/requirements.txt` does not exist — Dockerfile references it but it won't fail the build (guarded by `if [ -f ... ]`)

## PWA

- Service worker registered via `/register-sw.js`, manifest in `/manifest.json`
- Configuration in `config/pwa.php`

## Branches

Default branch is `dev`. Feature branches merged into `dev`. Recent work focused on UI redesigns and ESG progress tracking.
