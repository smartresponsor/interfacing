# Interfacing access route ownership cleanup

Interfacing no longer registers or owns account/access routes.

Removed from Interfacing:

- `interfacing_access_index`
- `interfacing_welcome_sign_in`
- `interfacing_welcome_sign_up`
- `interfacing_welcome_sign_out`
- `App\Interfacing\Presentation\Controller\InterfaceWelcomeAccessController`
- direct `App\Accessing\*` controller dependencies
- `/interfacing/access/*` fallback links

Boundary rule:

- Accessing owns `/access/*`, sign-in POST, sign-up, sign-out, session, credential, and security flows.
- Interfacing may provide reusable visual primitives only when the owning component explicitly renders them.
