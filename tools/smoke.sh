#!/usr/bin/env bash
set -euo pipefail

echo "Interfacing smoke: doctor"
php bin/console interfacing:doctor

echo "Open: http://localhost/interfacing?screen=demo.form"
