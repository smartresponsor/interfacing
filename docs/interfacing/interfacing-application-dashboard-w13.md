# Interfacing application dashboard W13

W13 introduces a first-class application dashboard for the shared Interfacing shell.

## Purpose

The dashboard makes connected, canonical, and planned Smart Responsor component resources visible from the main Interfacing entrypoint. This closes the recurring drift where component/entity links existed in diagnostics or exports, but were not obvious on the primary workspace screen.

## Routes

- `/interfacing/applications` renders the application dashboard.
- `/interfacing/applications.json` exports the same dashboard contract for smoke checks and host wiring.

## Contract

The dashboard is generated from the existing CRUD resource explorer contributions. Each resource keeps the CRUD bridge URL grammar used by the generic CRUD bridge:

- index
- new
- show sample
- edit sample
- delete sample

Planned resources remain visible intentionally. They may not be backed by host persistence yet, but the shell can still validate their address-bar routes and navigation placement.

## Shell placement

The application dashboard is linked from:

- top panel
- primary left panel
- secondary workspace panel
- right context panel
- footer
- main workspace preview

Top panel and footer remain mandatory. The shell continues to support the standard four-column mode and the three-column mode with the right panel disabled.
