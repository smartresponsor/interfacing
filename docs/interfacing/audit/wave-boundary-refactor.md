# Boundary Refactor Wave Notes

## Completed in this wave

- Removed the direct Composer PSR-4 autoload dependency on `../Localizing/src/`.
- Removed the direct Symfony service import of `../../../Localizing/config/services.yaml`.
- Introduced Interfacing-owned localization contracts and standalone default providers.
- Updated locale selector shell/screen consumers to depend on Interfacing contracts instead of Localizing contracts.
- Added active source boundary documentation for `src/`, `template/`, `.interfacing/workspace`, and retired/prototype roots.

## Still pending

- Retire `pack/src/` after verifying that no host tooling consumes it as a package prototype.
- Remove root donor files once touched-file apply workflow has explicitly reviewed them.
- Deduplicate `ScreenProviderInterface`, `ScreenRegistryInterface`, `ActionCatalogInterface`, `AccessResolverInterface`, and base context contracts.
- Collapse the duplicate Bundle/Extension entrypoint to one canonical Symfony bundle path.
- Normalize route ownership between YAML bridge routes and attribute-owned screen routes.
