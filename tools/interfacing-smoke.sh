#!/usr/bin/env bash
# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
set -euo pipefail

ROOT="${1:-.}"

required=(
  "src/Service/Interfacing/Tenant/DefaultTenantResolver.php"
  "src/Service/Interfacing/Security/InterfacingPermissionNamer.php"
  "src/Infra/Interfacing/Security/InterfacingPermissionVoter.php"
  "src/Infra/Interfacing/Http/InterfacingDoctorController.php"
  "config/services/interfacing.yaml"
  "templates/interfacing/doctor/index.html.twig"
)

for rel in "${required[@]}"; do
  if [[ ! -f "$ROOT/$rel" ]]; then
    echo "Missing file: $rel" >&2
    exit 1
  fi
done

echo "Interfacing smoke: required files present."
