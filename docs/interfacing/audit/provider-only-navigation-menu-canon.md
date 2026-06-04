= Provider-only navigation menu canon
:toc:

This wave removes generic `ul/li` navigation rendering from the normal shell navigation path.

== Canon

* Navigating owns menu payload and URLs.
* Interfacing owns stable shell locations and provider-specific menu templates.
* Menu rendering for shell navigation must use provider templates only:
** Ant Design Menu contract: `templates/provider/navigation/antd_menu.html.twig`
** PrimeReact PanelMenu contract: `templates/provider/navigation/primereact_panel_menu.html.twig`
* Generic `location_bucket` text rendering must not render navigation menu locations.

== Normal shell menu locations

* `shell.left.middle`
* `shell.context.middle`
* `shell.footer.left`
* `shell.footer.context`
* `shell.footer.main`
* `shell.footer.right`

== Transitional notes

The provider templates emit real anchors for navigation safety before React hydration. They deliberately avoid the old generic Twig `ul/li` list fallback.

