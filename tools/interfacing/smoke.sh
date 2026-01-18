#!/usr/bin/env bash
set -euo pipefail

php -v >/dev/null

if [ -f "bin/console" ]; then
  php bin/console cache:warmup >/dev/null
  php bin/console interfacing:doctor >/dev/null
  echo "Smoke: ok"
  exit 0
fi

if [ ! -f "config/routes/interfacing.yaml" ]; then
  echo "Missing config/routes/interfacing.yaml"
  exit 1
fi

echo "Smoke: ok (static)"
