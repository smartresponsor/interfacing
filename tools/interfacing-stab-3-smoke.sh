#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -euo pipefail

ROOT="${1:-.}"

required=(
  "src/Infra/Interfacing/Http/BillingMeterScreenController.php"
  "src/Infra/Interfacing/Http/OrderSummaryScreenController.php"
  "templates/interfacing/billing/meter.html.twig"
  "templates/interfacing/order/summary.html.twig"
)

for rel in "${required[@]}"; do
  if [[ ! -f "$ROOT/$rel" ]]; then
    echo "Missing file: $rel" >&2
    exit 1
  fi
done

echo "Interfacing Stab-3 smoke: required files present."
