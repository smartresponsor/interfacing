#!/usr/bin/env bash
set -euo pipefail

# ------------------------------------------------------------
# gate fix proposal (NDJSON) -> .report/gate-fix-proposal.ndjson
# ------------------------------------------------------------

GATE_PROPOSAL_FILE="${GATE_PROPOSAL_FILE:-.report/gate-fix-proposal.ndjson}"

gate_proposal_init() {
  mkdir -p ".report"
  : > "$GATE_PROPOSAL_FILE"
}

gate_proposal_add_append_lines() {
  local target_path="$1"
  shift

  python3 - "$GATE_PROPOSAL_FILE" "$target_path" "$@" <<'PY'
import json, sys
out = sys.argv[1]
path = sys.argv[2]
lines = sys.argv[3:]
obj = {
  "op": "file.append_lines",
  "level": "error",
  "path": path,
  "lines": lines,
  "note": "gate suggestion"
}
with open(out, "a", encoding="utf-8") as f:
  f.write(json.dumps(obj, ensure_ascii=False) + "\n")
PY
}

gate_proposal_add_print() {
  local text="$1"

  python3 - "$GATE_PROPOSAL_FILE" "$text" <<'PY'
import json, sys
out = sys.argv[1]
text = sys.argv[2]
obj = {
  "op": "report.print",
  "level": "warn",
  "text": text,
  "note": "gate hint"
}
with open(out, "a", encoding="utf-8") as f:
  f.write(json.dumps(obj, ensure_ascii=False) + "\n")
PY
}


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
  if ! bash "$REPO_ROOT/.gate/contract/sh/root-contract-check.sh" "$REPO_ROOT"; then
    mkdir -p "$REPO_ROOT/.report"
    : > "$REPO_ROOT/.report/gate-flag-root-contract.fail"

    gate_proposal_load_yml "$REPO_ROOT/.gate/policy/acceptable/root-contract-fail-proposal.yml"
    gate_proposal_add "$(gate_json_report_print 'Suggested: root-contract failure requires agent-required ops')"
    gate_proposal_print_summary
    exit 2
  fi
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
