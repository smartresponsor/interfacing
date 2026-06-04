= Interfacing Semantic Shell Location Canon

This wave replaces geometry-driven names such as `top-primary`, `left-secondary`, `body`, and `right-context` with stable semantic shell locations.

== Canonical structure

[source,html]
----
<body>
  <section>shell.body.top</section>

  <header>
    <aside>
      shell.header.left.logo
      shell.header.left.name
      shell.header.left.title
    </aside>
    <aside>shell.header.context</aside>
    <main>shell.header.main</main>
    <aside>
      shell.header.right.user
      shell.header.right.cart
      shell.header.right.notification
      shell.header.right.toggle
    </aside>
    <section>shell.header.bottom</section>
  </header>

  <aside>shell.left.top / shell.left.middle / shell.left.bottom</aside>
  <aside>shell.context.top / shell.context.middle / shell.context.bottom</aside>
  <main>shell.main.top / shell.main.content / shell.main.bottom</main>
  <aside>shell.right.top / shell.right.middle / shell.right.bottom</aside>

  <footer>
    <section>shell.footer.top</section>
    <aside>shell.footer.left</aside>
    <aside>shell.footer.context</aside>
    <main>shell.footer.main</main>
    <aside>shell.footer.right</aside>
  </footer>
</body>
----

== Canonical rules

* `templates/base.html.twig` remains the only HTML document owner. `templates/shell/base.html.twig` is retired.
* All new payload locations must use `shell.*` semantic names.
* Header locations use `shell.header.*`, not `shell.head.*`.
* Footer top row is `shell.footer.top`, not `shell.footer.banner`.
* `shell.left.middle` is primary navigation.
* `shell.context.middle` is section/context navigation.
* Legacy names remain readable for one transition period only.

== Transition aliases

[cols="1,1",options="header"]
|===
| Legacy | Canonical
| `shell.top.primary` | `shell.header.left`
| `shell.top.secondary` | `shell.header.context`
| `shell.top.main` | `shell.header.main`
| `shell.top.right` | `shell.header.right`
| `shell.left.primary` | `shell.left.middle`
| `shell.left.section` | `shell.context.middle`
| `body.header` | `shell.main.top`
| `body.content` | `shell.main.content`
| `body.footer` | `shell.main.bottom`
| `right.context` | `shell.right.middle`
| `footer.primary` | `shell.footer.left`
| `footer.secondary` | `shell.footer.context`
| `footer.main` | `shell.footer.main`
| `footer.right` | `shell.footer.right`
|===

