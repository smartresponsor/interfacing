# Interfacing Localization Boundary

Interfacing can render locale-aware shell and selector screens, but it must not require a sibling `../Localizing` checkout.

## Canonical dependency direction

Interfacing owns narrow UI-facing localization contracts:

- `App\Interfacing\ServiceInterface\Interfacing\Localization\LocaleTemplateContextProviderInterface`
- `App\Interfacing\ServiceInterface\Interfacing\Localization\LocaleTemplateSelectorProviderInterface`
- `App\Interfacing\Contract\Localization\LocaleTemplateContext`
- `App\Interfacing\Contract\Localization\LocaleTemplateSelectorOption`

A host application may bind those interfaces to Localizing-backed adapters. The standalone bundle ships default providers so the Interfacing shell remains usable without external component autoloading.

## Forbidden in the component package

- `composer.json` autoload entries pointing to `../Localizing/src/`.
- `config/services/*.yaml` imports pointing to `../../../Localizing/...`.
- Direct `use App\Localizing\...` imports in Interfacing runtime code.
