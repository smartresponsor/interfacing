# Interfacing admin body authorization policy contract

Wave 22 adds a UI-level authorization and visibility contract for the central admin body.

This contract does not authorize requests. Symfony security voters, access-control rules, controllers, and backend services remain authoritative. The admin body contract only tells the hydrated provider and Twig provider-less UI how to represent action state in a predictable way.

## Canonical rule

- Backend security owns enforcement.
- Interfacing UI owns action visibility, disabled state, and disabled reason semantics.
- The default UI decision is `disabled-until-authorized`.
- Destructive actions remain tied to confirmation policy.
- Ant Design ProComponents maps these states into `PageContainer.extra`, `ProTable.actionColumn`, `ProTable.tableAlertOption.bulkActions`, and `ProForm.submitter`.

## Required action groups

- `headerActions`
- `rowActions`
- `bulkActions`
- `formActions`
- `detailActions`

Each group must expose provider targets and server-declared visibility/enabled semantics. The frontend renderer may display disabled actions with a reason, but it must not treat the UI contract as authorization proof.
