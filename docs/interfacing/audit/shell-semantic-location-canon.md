# Shell content-output location canon

This audit fixes the public content-output location contract and removes legacy header-anchor drift from Twig markup.

## Public content-output locations

```text
shell.body.top

shell.left.top
shell.left.middle
shell.left.bottom

shell.context.top
shell.context.middle
shell.context.bottom

shell.main.top
shell.main.toolbar
shell.main.content
shell.main.bottom

shell.right.top
shell.right.tool
shell.right.filter
shell.right.middle
shell.right.bottom

shell.footer.top
shell.footer.left
shell.footer.context
shell.footer.main
shell.footer.right

shell.header.bottom
```

## Header markup rule

Header brand/search/menu markup is internal provider structure. It must use neutral provider attributes such as `data-interfacing-provider-region` or `data-interfacing-provider-part`, not legacy `shell.header.*` anchors. The only public header output location is `shell.header.bottom`.

## Canonical rule

Public payload flows through `location_bucket.html.twig` or `navigation/location.html.twig`.
Twig must not expose legacy `shell.header.left.*`, `shell.header.main`, or `shell.header.right.*` names as provider anchors or public output locations.
