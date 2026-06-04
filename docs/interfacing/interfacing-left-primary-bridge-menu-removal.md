# Left primary menu: Bridge removal

The primary left panel is a user-facing component rail. The `Bridge` entry is removed because it represents a low-level/internal bridge surface rather than a business or ecosystem brick that users should open directly.

`Bridging` remains available as the component-level integration brick.

Applied contract:

- keep `Bridging`;
- remove `Bridge`;
- prevent fallback shell markup from reintroducing `/bridge/`;
- bump shell cache keys so stale navigation is not reused.
