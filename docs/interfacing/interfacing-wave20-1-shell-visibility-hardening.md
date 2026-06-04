= Interfacing Wave 20.1: Shell Visibility Hardening

Wave 20 added footer and quick-menu chrome to `templates/base.html.twig`, but host applications may resolve `base.html.twig` to their own base template. In that case Interfacing pages can render successfully while bypassing the Interfacing shell chrome.

This wave makes Interfacing-owned pages deterministic:

* `templates/shell/base.html.twig` is the component-owned shell base.
* `templates/base.html.twig` extends `shell/base.html.twig` instead of ambiguous `base.html.twig`.
* The rendered HTML contains markers:
** `data-interfacing-shell-base="interfacing-owned"`
** `data-interfacing-shell-contract="wave20.1"`
** `data-interfacing-shell-slot="quick-menu"`

The standalone `templates/base.html.twig` is retained for host applications that explicitly choose it, but Interfacing-local templates no longer depend on host template name resolution.

For true system-wide footer coverage across all components, the host application must include the Interfacing shell base/partials or adopt a shared host shell layout. This wave guarantees visibility for Interfacing-owned routes first.

