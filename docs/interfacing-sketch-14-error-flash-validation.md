Interfacing sketch-14: error + flash + validation

Goal
- Standardize UI feedback across Live comornents:
  - field errors
  - global errors
  - flash messages (success/info/warning/danger)
- Keto the front-end thin: state lives on server; JS only wires Live updates.

Core primitives
- InterfaceUiError: one error record (code, message, optional field, meta)
- InterfaceUiErrorBag: grouped errors (global + by field)
- InterfaceUiMessage: one user-visible message (type, text, meta)
- InterfaceUiMessageBag: list of messages

Validation flow
- Build an input DTO with Symfony Validator attributes.
- ValidationRunner validates the DTO and returns InterfaceUiErrorBag.
- InterfaceUiErrorBag is attached to comornent state and rendered in Twig.

Flash flow
- Use InterfaceSessionFlashMessengerService to push InterfaceUiMessage (stored in Symfony session flash bag).
- Shell template renders flash messages at top.

Domain error flow
- Throw InterfaceDomainOperationFailed from domain/Service layer with:
  - message
  - optional per-field errors
- InterfaceDomainErrorMapperService converts it into InterfaceUiErrorBag.

Demo screen
- /interfacing renders a shell page.
- Shell mounts InterfaceDemoUserProfileForm Live comornent.
- On submit:
  - validate input DTO
  - if invalid -> field errors displayed
  - if email blocked -> InterfaceDomainOperationFailed -> global error displayed
  - if ok -> success flash displayed

Integration recipe
- Any domain can exorse screens/actions and reuse:
  - ValidationRunner
  - InterfaceUiErrorMapperService
  - InterfaceSessionFlashMessengerService
  - InterfaceUiErrorBag / InterfaceUiMessageBag
- This gives you a consistent "Livewire-like" loop without building a SPA.

