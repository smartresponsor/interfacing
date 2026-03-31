Interfacing sketch-14: error + flash + validation

Goal
- Standardize UI feedback across Live components:
  - field errors
  - global errors
  - flash messages (success/info/warning/danger)
- Keep the front-end thin: state lives on server; JS only wires Live updates.

Core primitives
- UiError: one error record (code, message, optional field, meta)
- UiErrorBag: grouped errors (global + by field)
- UiMessage: one user-visible message (type, text, meta)
- UiMessageBag: list of messages

Validation flow
- Build an input DTO with Symfony Validator attributes.
- ValidationRunner validates the DTO and returns UiErrorBag.
- UiErrorBag is attached to component state and rendered in Twig.

Flash flow
- Use SessionFlashMessenger to push UiMessage (stored in Symfony session flash bag).
- Shell template renders flash messages at top.

Domain error flow
- Throw DomainOperationFailed from domain/service layer with:
  - message
  - optional per-field errors
- DomainErrorMapper converts it into UiErrorBag.

Demo screen
- /interfacing renders a shell page.
- Shell mounts InterfacingDemoUserProfileForm Live component.
- On submit:
  - validate input DTO
  - if invalid -> field errors displayed
  - if email blocked -> DomainOperationFailed -> global error displayed
  - if ok -> success flash displayed

Integration recipe
- Any domain can expose screens/actions and reuse:
  - ValidationRunner
  - UiErrorMapper
  - SessionFlashMessenger
  - UiErrorBag / UiMessageBag
- This gives you a consistent "Livewire-like" loop without building a SPA.

