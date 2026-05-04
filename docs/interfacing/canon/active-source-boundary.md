# Interfacing Active Source Boundary

This repository uses the Symfony-oriented `App\Interfacing\...` source tree as the only active PHP runtime boundary.

## Active runtime roots

- `src/` — Symfony component source under `App\Interfacing\...`.
- `config/` — Symfony package/bundle configuration.
- `template/` — canonical Twig template root for Interfacing-owned screens and shell rendering.
- `tests/` and `test/` — verification material.
- `.interfacing/workspace/` — UI workbench mirror/tooling space, not a PHP runtime source root.

## Retired/prototype roots

- `pack/src/` uses the older `SmartResponsor\Interfacing\...` namespace and Domain/Infra/Http style. It is not an active source of truth for Symfony runtime code.
- root-level PHP files are treated as moved donor artifacts when equivalent canonical files exist under `src/`.
- root-level or duplicate Twig files outside `template/` are treated as migration candidates unless explicitly wired.

## Rule

New PHP code must land under `src/` using `App\Interfacing\...`; new service contracts must use mirrored `src/ServiceInterface/...` folders; new Twig templates must land under `template/` unless a host application explicitly maps another path.
