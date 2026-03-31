Param()

$ErrorActionPreference = "Stop"

$name = "interfacing-rc1"
$out = "dist"
New-Item -ItemType Directory -Force -Path $out | Out-Null

$zip = Get-Command Compress-Archive -ErrorAction SilentlyContinue
if (-not $zip) {
  Write-Host "Compress-Archive not available."
  exit 2
}

Compress-Archive -Force -Path src,config,template,docs,tools,test,MANIFEST.md,composer.json,phpunit.xml.dist -DestinationPath "$out\$name-src.zip"
Compress-Archive -Force -Path src,config,template,docs,tools,MANIFEST.md,composer.json -DestinationPath "$out\$name-release.zip"
Compress-Archive -Force -Path template,docs,MANIFEST.md -DestinationPath "$out\$name-public.zip"
Compress-Archive -Force -Path src,config,template,tools,MANIFEST.md,composer.json -DestinationPath "$out\$name-host-minimal.zip"
Compress-Archive -Force -Path src,template,docs,tools,MANIFEST.md,composer.json -DestinationPath "$out\$name-standalone.zip"

Write-Host "Built family zips in $out\"
