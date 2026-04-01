#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -euo pipefail

ROOT="${1:-.}"

required=(
  "src/Domain/Interfacing/Query/BillingMeterRow.php"
  "src/Domain/Interfacing/Query/BillingMeterPage.php"
  "src/Domain/Interfacing/Query/OrderSummaryRow.php"
  "src/Domain/Interfacing/Query/OrderSummaryPage.php"
  "src/Service/Interfacing/Query/HttpBillingMeterQueryService.php"
  "src/Service/Interfacing/Query/HttpOrderSummaryQueryService.php"
  "config/services/interfacing_billing_order.yaml"
)

for rel in "${required[@]}"; do
  if [[ ! -f "$ROOT/$rel" ]]; then
    echo "Missing file: $rel" >&2
    exit 1
  fi
done

echo "Interfacing Stab-2 smoke: required files present."
