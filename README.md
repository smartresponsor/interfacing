# Interfacing padding fix kit

Current slice source: `Interfacing(13).zip`.

## Change

Removes the slot-level `padding: var(--interfacing-provider-panel-padding) 10px !important;` rule from the provider baseline selector group.

The broad selector was affecting shell/access slots such as:

- `[data-interfacing-shell-slot="top"]`
- `[data-interfacing-shell-slot="footer"]`
- `[data-interfacing-access-footer-mode]`
- `[data-interfacing-access-slot="body"] > section`

The fix keeps border color ownership in the grouped data-attribute selector and keeps surface background only on side/context shell slots.

## Files

- `templates/shell/partial/provider_baseline_style.html.twig`
- `public/interfacing/design/provider-baseline.css`

## Notes

Panel spacing remains available through `.interfacing-shell-panel` without the duplicated data-attribute `!important` override.
