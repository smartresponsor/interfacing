#!/usr/bin/env bash
set -euo pipefail

if ! command -v php >/dev/null 2>&1; then
  echo "php is not found in PATH" >&2
  exit 1
fi

ROOT="${1:-.}"
FILES=$(find "$ROOT" -type f -name '*.php' -not -path '*/vendor/*')
if [ -z "$FILES" ]; then
  echo "No PHP files found under $ROOT" >&2
  exit 1
fi

BAD=0
while IFS= read -r f; do
  if ! php -l "$f" >/dev/null 2>&1; then
    php -l "$f" || true
    BAD=$((BAD+1))
  fi
done <<< "$FILES"

if [ "$BAD" -gt 0 ]; then
  echo "Smoke failed: $BAD file(s) have syntax errors" >&2
  exit 1
fi

COUNT=$(echo "$FILES" | wc -l | tr -d ' ')
echo "Smoke OK: $COUNT file(s) checked"
