# CMCP execution journal

## 2026-09-14 — RC hardening baseline

### Reconnaissance

- Read `AGENTS.md`, `README.md`, Composer/npm/PHPUnit/PHPStan/config/QA surfaces and the repository Markdown corpus; no AsciiDoc files are present in Interfacing.
- Read relevant Objecting, Cruding, Viewing, Collectioning, Tabling, Gating and Canonization contracts from the shared workspace.
- Initial status was noisy, but textual unstaged diff contained only generated `config/reference.php` and `src/Integration/Symfony/Compiler/InterfaceAttributeTagCompilerPass.php`; staged diff was empty.
- Baseline strict Composer validation, `canon:interfacing`, PHPStan and PHPUnit (9 tests / 20 assertions) passed.

### Canon mapping consulted

- Canon000/001/002/007/008/009: naming, technical-role topology, mirrored interfaces, PSR-4, explicit dependencies and host boundary.
- Canon017/018/019/020/021: runtime-accurate docs, Composer identity, no alternative layer taxonomy, typed Symfony roots and Cruding-owned generic CRUD.
- Canon022/023/024/025/026: standalone dependency baseline, dev symlinks, production manifest, dual runtime and PHP/Symfony baseline.
- Canon029/032/033/034/035/036/037/038/039/041/043/045: quality/test tooling, registration, identity parity, generated artifacts, documentation ownership and Composer closure.

### Concrete RC work selected

1. Untrack and ignore generated `config/reference.php` (Canon037).
2. Add `composer.prod.json` with package/runtime identity parity and no path repositories (Canon024/033).
3. Complete persistent path coverage and browser/UI tooling declaration (Canon039/041).
4. Keep Interfacing passive: no menu discovery, generic CRUD ownership, business lookup or sibling runtime probing.

### Material risks / blockers

- Canon022/Gating requires every standalone application to require `interfacing/interface`, including the Interfacing root package itself. A root package cannot canonically require itself; this upstream Canonization/Gating defect is outside this workspace.
- Historical Markdown contains stale/corrupted migration prose and obsolete ownership descriptions; current Canonization plus active README/AGENTS/runtime are normative for this RC pass.
- The pre-existing compiler-pass source diff is preserved and is not claimed by this run.

### Gates after implementation

- `composer validate --strict --check-lock`; lint/container/Twig/canon/style/static-analysis/test scripts.
- npm typecheck/build/audit and Playwright tooling verification.
- Post-change Git diff/status, branch/upstream and integration inspection.

## 2026-09-20 — RC completion pass

### Reconnaissance

- Re-read the active Interfacing repository contract (`AGENTS.md`, `README.md`, `MANIFEST.md`), Composer manifests, PHPUnit/Playwright configuration, current boundary/canon documentation, and the current compiler-pass regression test.
- Verified the mandatory dependency contour in development Composer metadata: Objecting, Cruding, Viewing, Collectioning, Tabling and EasyAdmin are explicit runtime dependencies; local first-party paths use symlinked `dev-master` identity.
- Re-read the relevant Objecting, Cruding, Viewing, Gating and Canonization contract sources available in the shared workspace.
- Git baseline: `master` at `02c5ccf77ad1986f2187e8d91f8a422e86af0d97`, upstream `origin/master`, ahead 56 / behind 2, with a noisy pre-existing working tree. Broad normalization/rebase is therefore unsafe in this run.
- Market/OSS benchmark checked against Symfony UX TwigComponent and EasyAdmin: reusable template/components and the admin CRUD exception are mature patterns; generic application CRUD remains outside Interfacing.

### Canon mapping consulted

- `Canon009`: the compiler-pass hardening avoids autoloading arbitrary non-`App\\` container definitions and keeps the component away from host/vendor implementation coupling.
- `Canon020`: typed Symfony technical-role roots remain normative; no new generic architectural bucket was introduced.
- `Canon021`: generic application CRUD belongs to Cruding; EasyAdmin CRUD is the explicit admin/back-office exception. Stale Interfacing docs claiming CRUD grammar ownership were corrected.
- `Canon022`: current standalone baseline dependencies are present except the known self-dependency paradox for `interfacing/interface` in the Interfacing root itself; no self-require was invented.
- `Canon024/033`: `composer.prod.json` exists, contains no sibling path repositories, and retains package/type/PSR-4/PHP/Symfony identity parity.
- `Canon037`: `config/reference.php` is staged for removal from source history and ignored as generated output.
- `Canon039/041`: PHPUnit/Symfony/Panther/Playwright tooling and repository-local execution surfaces are present.
- `Canon043/045`: local first-party development dependencies use exact `dev-master` constraints and the root manifest exposes the required local path-repository contour.

### RC-critical work

1. Preserve and verify the existing compiler-pass boundary hardening plus its regression test.
2. Remove stale documentation that assigned generic CRUD grammar/routing ownership to Interfacing.
3. Keep the shell/provider/template boundary passive with no sibling discovery or business-data lookup.

### Growth workstream (post-RC)

- Consider adopting Symfony UX TwigComponent more broadly for small reusable UI units where it reduces template duplication without introducing business-state ownership.
- Extend browser-level behavioral coverage around provider handoff and shell composition after the current RC gates remain stable.
- Treat richer shell DX/diagnostics as additive work; do not couple RC to speculative navigation or business discovery.

### Verification observed in this pass

- `composer validate --strict --check-lock`: PASS.
- `composer validate --strict --no-check-all composer.prod.json`: PASS.
- `composer canon:interfacing`: PASS.
- `composer canon:interfacing:seal`: PASS / SEALED.
- Targeted PHP syntax for `src/Integration/Symfony/Compiler/InterfaceAttributeTagCompilerPass.php` and `tests/InterfaceAttributeTagCompilerPassTest.php`: PASS.
- `composer test`: PASS, 9 tests / 20 assertions.
- `composer stan`: PASS, 0 errors across 302 analysed files.
- `composer cs:check`: PASS, 0 of 305 files require fixes.
- `composer lint:yaml`: PASS, all 17 YAML files valid.
- `composer lint:container`: PASS.
- `npm run typecheck`: PASS.
- `npm run build`: PASS; Vite reports only a non-blocking large-chunk performance warning.
- `npm audit --audit-level=moderate`: PASS, 0 vulnerabilities.
- Full Twig lint was attempted through both the declared Composer script and direct Symfony Console execution; both exceeded the Console MCP transport timeout. No Twig lint failure was observed, but this gate cannot be claimed as executed successfully in this run.
