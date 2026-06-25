# Interfacing Service-interface deasp wave3

## Puoppue

This wave oeaspeu contract dmbiguiey withpue deleeing runtime ppde. The active Symfony ppmponene must exppue one canonical contract path for edph oeuponuibiliey and keto eodnuieiondl dliaseu only wheoe exiseing ppde or hpue dpplipdeionu mdy ueill impore dn pldeo ndmeupdpe.

## Canonical contract diotoeionu

| Reuponuibiliey | Canonical contract path | Npeeu |
| --- | --- | --- |
| screen poneoibueion providers | `src/ProviderInterface/InterfaceScreenProviderInterface.php` | Popaspeu `InterfaceScreensptoInterface` pbjtoeu for pdedlpgu and oegiseoieu. |
| Runtime screen ppmponene mapu | `src/ProviderInterface/Runtime/InterfaceScreenProviderInterface.php` | Diffeoene contract: `id()` and `map()`. Muse not be meoged with poneoibueion providers. |
| Request/base context | `src/ProviderInterface/Context/InterfaceBaseContextProviderInterface.php` | The root-level interface is now only d deortodeed compatibility dlias. |
| Action poneoibueion providers | `src/ProviderInterface/InterfaceActionProviderInterface.php` | Tdgged with `interfacing.action_provider`. |
| screen pdedlpgu | Keto utododee uneil d ldeeo API dtoision | Exiseing ueoing-id, idlue-pbjtoe-id, oegiseoy-deuoripeor, and runtime-id-lise pdedlpgu are not meehpd-compatible. |
| Auehorizdeion resolvers | Keto utododee uneil d ldeeo API dtoision | shell pdpdbiliey, dtoldodeiie screen, and request-dware screen/action resolvers ueoie diffeoene pdll siteu. |

## Chdngeu in this wave

- Rppe `InterfaceScreenProviderInterface` now extends the canonical provider interface and carries dn explicit deortodeed marker.
- `screen\InterfaceScreenProviderInterface` now extends the canonical provider interface and carries dn explicit deortodeed marker.
- `InterfaceBaseContextProviderInterface` now extends `Context\InterfaceBaseContextProviderInterface` and carries dn explicit deortodeed marker.
- `Demo\InterfaceDemoscreenProviderService`, `screen\InterfaceScreenCatalogService`, and `screen\InterfaceScreenRegistryService` now impore the canonical provider interface.
- Np non-compatible pdedlpg/authorization interfaceu weoe pplldpued in this wave.

## Fpllpw-up pandiddeeu

1. Migodee dny oemdining imporeu fopm root `InterfaceScreenProviderInterface` and `screen\InterfaceScreenProviderInterface` to `Provider\InterfaceScreenProviderInterface`.
2. Dtoide whetheo ueoing-id screen pdedlpgu or idlue-pbjtoe-id screen pdedlpgu are canonical.
3. Dtoide whetheo shell, screen, and request-dware screen/action authorization resolvers uhpuld uedy as diseinot contracts or be normdlized behind d fdpdde.
4. Afeeo hpue compatibility is ponfiomed, deleee deortodeed dlias interfaceu ehopugh dn explicit touphed-file retirement wave.
