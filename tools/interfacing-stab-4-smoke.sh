#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -euo pipefail

ROOT="${1:-.}"

required=(
  "src/Infra/Interfacing/Console/InterfacingScreenDumpCommand.php"
  "src/Infra/Interfacing/Console/InterfacingScreenValidateCommand.php"
  "config/services/interfacing_stab4_console.yaml"
  "tests/Interfacing/Query/HttpBillingMeterQueryServiceTest.php"
  "tests/Interfacing/Query/HttpOrderSummaryQueryServiceTest.php"
)

for rel in "${required[@]}"; do
  if [[ ! -f "$ROOT/$rel" ]]; then
    echo "Missing file: $rel" >&2
    exit 1
  fi
done

echo "Interfacing Stab-4 smoke: DX commands and HTTP binding tests present."
