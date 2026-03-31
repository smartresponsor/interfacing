Sketch-13: Action endpoint + unified ActionResult

Why
- Interfacing needs a single canonical way to execute actions from server-driven UI (Livewire-like).
- Actions must return a normalized result that the UI can apply without custom glue per screen.

Key pieces
- ActionEndpointInterface: a screen action handler (server side).
- ActionDispatcher: access + context + dispatch + exception-to-result mapping.
- ActionResult: ok | validation_error | domain_error | redirect | reload

Demo
- demo.form: save-profile action
- demo.metric: refresh action
- demo.wizard: next/back actions

Host integration
- If you use Symfony UX LiveComponent, the template is already wired to call invokeAction(actionId, payload).
- You can replace AllowAllAccessResolver with SymfonyAccessResolver for role-based access.

Next (sketch-14)
- unify errors/flash/validation mapping (Validator + domain exception adapters).
