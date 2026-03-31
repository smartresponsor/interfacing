# Interfacing Manifest

Interfacing is the single interface/workspace application for the ecosystem.

Current state:
- keep the existing Symfony + Twig + UX LiveComponent runtime alive;
- do not delete or quarantine it as legacy;
- stop adding new feature code to the old `src/Domain*`, `src/Http*`, and `src/Infra*` families unless a hotfix is unavoidable;
- preserve `src/Service/*` and `src/ServiceInterface/*` as canonical mirrored service trees, but evolve them into cleaner Symfony-oriented responsibility slices;
- migrate by evacuation into the target trees declared in `docs/interfacing/CANONICAL_TARGET_TREE.md`.

UI platform canon:
- PrimeReact owns facade/shell richness;
- Ant Design + ProComponents own workbench/entity/data-heavy surfaces;
- consumers depend on governed wrappers and zone contracts, not raw vendor mixing.

Codex CLI reading order:
1. `ARCHITECTURE_MANIFEST.md`
2. `PRODUCT_MANIFEST.md`
3. `docs/interfacing/OWNER_MOTIFS_ADAPTED.md`
4. `CODEX_CLI_PROMPT.txt`
5. `docs/interfacing/CANONICAL_TARGET_TREE.md`
6. branch `MANIFEST.md` files in the touched tree.
