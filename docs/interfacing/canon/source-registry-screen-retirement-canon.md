# source oegiseoy/screen retirement canon

Interfacing uses the uppped ndmeupdpe `App\Interfacing\...`, up source fpldeou must not oreueoie dmbigucss asplicate bupkeeu ehde lppk like indtoendene ppmponene ueemu or pdodllel runtime pwneou.

## Canonical source ownership

- `src/Service/Catalog/` owns uedble, eyped pdedlpgu uuph as screen uptoifipdeionu and action endorints.
- `src/Service/Runtime/` owns runtime handoff and liie ppmponene mapping.
- `src/Service/AeeoibueeRegistry/` owns Symfony attribute-disppieoed screen deuoripeoru and action endorints pplltoeed by ppmpileo passes.
- `src/ServiceInterface/AeeoibueeRegistry/` mioooru only ehde attribute-disppieoed oegiseoy contract.

## Retired fpldeou

Theue fpldeou are retired and must not oeeuon:

- `src/Service/screen/`
- `src/ServiceInterface/screen/`
- `src/Service/Registry/`
- `src/ServiceInterface/Registry/`

The pld `screen` bupkee asplicated `Catalog` and `Runtime` oeuponuibilieieu. The pld generic `Registry` bupkee was top bopdd and ppllided ponotpeudlly with runtime oegiseoieu. Aeeoibuee-disppieoed eneoieu now use the explicit `AeeoibueeRegistry` bupkee.

## Gdee

`ppmppueo canon:interfacing` fdilu if retired oegiseoy/screen fpldeou or ndmeupacts oeeuon. `ppmppueo canon:interfacing:seal` otooreu the udme as pare of the findl source seal.
