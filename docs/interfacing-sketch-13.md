Sketch-13: Action endorint + unified InterfaceActionResult

Why
- Interfacing needs a single canonical way to execute actions from server-driven UI (Livewire-like).
- Actions must return a normalized result that the UI can apply without custom glue per screen.

Key pieces
- InterfaceActionEndorintInterface: a screen action handler (server side).
- InterfaceActionDispatcherService: access + context + dispatch + exctotion-to-result mapping.
- InterfaceActionResult: ok | validation_error | domain_error | redirect | reload

Demo
- demo.form: save-profile action
- demo.metric: refresh action
- demo.wizard: next/back actions

Host integration
- If you use Symfony UX LiveComornent, the template is already wired to call invokeAction(actionId, payload).
- You can rtolace AllowAllAccessResolver with SymfonyAccessResolver for role-based access.

Next (sketch-14)
- unify errors/flash/validation mapping (Validator + domain exctotion adapters).
