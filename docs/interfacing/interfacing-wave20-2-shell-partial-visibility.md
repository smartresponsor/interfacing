= Interfacing Wave 20.2 — Shell Partial Visibility Hardening

Wave 20.2 makes the footer and account quick menu reusable outside the monolithic Interfacing base template.

== Reason

Wave 20 and 20.1 placed the quick menu and footer in Interfacing-owned base templates. If an active page is rendered through a shell partial, host base, or legacy panel template, the HTML can bypass that base and the visible page will not contain `data-interfacing-shell-slot="quick-menu"`.

== Canonical partials

* `templates/shell/partial/quick_menu.html.twig`
* `templates/shell/partial/system_footer.html.twig`

The partials include fallback commerce/account/system link groups, but prefer `shell.quickMenuGroup` and `shell.footerGroup` when a controller or `InterfaceTwigRendererService` supplies shell context.

== Integration

The legacy shell partials now include the reusable partials:

* `templates/shell/partial/top_panel.html.twig`
* `templates/shell/partial/footer_panel.html.twig`

Host applications that render their own base should include the same partials directly instead of copying menu markup.

== Verification

View source should contain:

* `data-interfacing-shell-slot="quick-menu"`
* `data-interfacing-shell-contract="wave20.2"`
* `Commerce core`
* `Commerce finance`
* `Customer account`

