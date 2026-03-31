#!/usr/bin/env bash
set -euo pipefail

name="interfacing-rc1"
out="dist"
mkdir -p "$out"

zip -qr "$out/${name}-src.zip" src config template docs tool test MANIFEST.md composer.json phpunit.xml.dist
zip -qr "$out/${name}-release.zip" src config template docs tool MANIFEST.md composer.json
zip -qr "$out/${name}-public.zip" template docs MANIFEST.md
zip -qr "$out/${name}-host-minimal.zip" src config template tool MANIFEST.md composer.json
zip -qr "$out/${name}-standalone.zip" src template docs tool MANIFEST.md composer.json

echo "Built family zips in $out/"
