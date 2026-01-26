#!/usr/bin/env bash
set -euo pipefail

REPO_ROOT="${1:-$(pwd)}"
QUALITY="${QUALITY:-0}"

MODE="consumer"
if [[ "${GITHUB_REPOSITORY:-}" == */canonization ]]; then
  MODE="canon"
fi

echo "[gate] repo=${GITHUB_REPOSITORY:-local} mode=$MODE root=$REPO_ROOT"

# Contract
# root-contract => ONLY for canonization repo
if [[ "$MODE" == "canon" ]]; then
  bash "$REPO_ROOT/.gate/contract/sh/root-contract-check.sh" "$REPO_ROOT"
else
  echo "[gate] skip root-contract-check (consumer repo)"
fi

# gitignore template check => OK for everyone
bash "$REPO_ROOT/.gate/contract/sh/gitignore-template-check.sh" "$REPO_ROOT"

# Linting (fast checks) - JS checks require node
if command -v node >/dev/null 2>&1; then
  node "$REPO_ROOT/.gate/linting/js/no-plural-check.js" "$REPO_ROOT"
  node "$REPO_ROOT/.gate/linting/js/layer-mirror-check.js" "$REPO_ROOT"
  node "$REPO_ROOT/.gate/linting/js/doc-name-check.js" "$REPO_ROOT"
  node "$REPO_ROOT/.gate/linting/js/archive-name-check.js" "$REPO_ROOT"
else
  echo "node not found, skipping JS linting checks"
fi

bash "$REPO_ROOT/.gate/linting/sh/copyright-header-check.sh" "$REPO_ROOT"
bash "$REPO_ROOT/.gate/linting/sh/layer-mirror-check.sh" "$REPO_ROOT"
bash "$REPO_ROOT/.gate/linting/sh/doc-name-check.sh" "$REPO_ROOT"
bash "$REPO_ROOT/.gate/linting/sh/archive-flat-root-check.sh" "$REPO_ROOT"

if [[ "$QUALITY" == "1" ]]; then
  bash "$REPO_ROOT/.gate/quality/sh/quality-run.sh" "$REPO_ROOT"
fi

echo "Gate OK"
