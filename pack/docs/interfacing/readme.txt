Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

interfacing-sketch-01-runtime-kernel

Purpose
- Enable stable wiring: /interfacing -> layout shell -> screenId -> screen template.
- Provide allowlist catalogs (screen registry + layout catalog).
- Provide health endpoint: /interfacing/health (JSON).

Endpoints
- /interfacing
- /interfacing/home
- /interfacing/health
- /interfacing/empty

Install notes
- Ensure your project loads config/routes/*.yaml. If not, import config/routes/interfacing.yaml.
- Ensure your project loads config/services/*.yaml. If not, import config/services/interfacing.yaml.

Smoke (requires a running server)
- tools/interfacing/smoke.ps1 -BaseUrl http://127.0.0.1:8000
- tools/interfacing/smoke.sh  http://127.0.0.1:8000
