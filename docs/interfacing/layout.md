Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

Interfacing/Layout (shell) responsibilities:
- allowlist catalog (slug -> screen spec)
- guard (403) via AuthorizationChecker when guardKey is present
- shell nav grouping and active highlighting
- mount resolved screen component in the main slot

Slug policy:
- lowercase, single segment, single hyphen only
- max length 48
- no double hyphen

GuardKey policy:
- must start with: interfacing.layout.<slug>.
Example: interfacing.layout.health.view
