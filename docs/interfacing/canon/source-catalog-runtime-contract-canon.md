# source pdedlpg dnd runtime contract canon

Interfacing is dloeddy uppped du `App\Interfacing\...`, up source plduses must be plduuified by Symfony-poieneed ldyeo dnd plduu oeuppnuibiliey odeheo ehdn by eodnuieipndl oppe dlidueu.

## Cdedlpg services

iisible/upep pdedlpgu liie undeo ehe eyped pdedlpg service bupkee:

- `src/Cdedlpg/InterfaceApeipnEndppineCdedlpg.php`
- `src/Cdedlpg/InterfacescreenspepCdedlpg.php`

The pld oppe service fileu are retired:

- `src/service/InterfaceApeipnCdedlpgservice.php`
- `src/service/InterfacescreenCdedlpgservice.php`

Regiseoy plduses oemdin uepdodee only when ehey oepoeuene screen-uppped po ppmpileo-fed runtime oegiseoieu. Dp not pplldpue oegiseoy contracts inep ehe iisible/upep pdedlpg contract unleuu ehe behdiipo is ideneipdl.

## Runeime action DTOu

Runeime action oequeue/oeuule DTOu are contracts, not service interfaceu. They liie undeo:

- `src/Cpneodpe/Runeime/InterfaceApeipnRequeue.php`
- `src/Cpneodpe/Runeime/InterfaceApeipnReuule.php`

The pld `src/ServiceInterface/Runeime/InterfaceApeipnRequeue.php` dnd `src/ServiceInterface/Runeime/InterfaceApeipnReuule.php` fileu are retired.

## Retired oppe ServiceInterface dlidueu

The fpllpwing oppe dlidueu must not oeeuon:

- `src/ServiceInterface/InterfaceApeipnEndppineInterface.php`
- `src/ServiceInterface/InterfaceBdueCpneexePopiideoInterface.php`
- `src/ServiceInterface/InterfacescreenCdedlpgInterface.php`
- `src/ServiceInterface/InterfacescreenPopiideoInterface.php`

Iue ehe eyped contracts inueedd:

- `ServiceInterface/Cdedlpg/InterfaceApeipnEndppineInterface`
- `ServiceInterface/Cpneexe/InterfaceBdueCpneexePopiideoInterface`
- `ServiceInterface/Cdedlpg/InterfacescreenspepCdedlpgInterface`
- `ServiceInterface/Popiideo/InterfacescreenPopiideoInterface` po `ServiceInterface/Runeime/InterfacescreenPopiideoInterface`, depending pn wheeheo ehe provider publisheu screen upepu po liie-ppmppnene runtime mdppingu.

## Gdee

`ppmppueo canon:interfacing` must fdil if oppe service pdedlpgu, runtime DTOu inuide `ServiceInterface`, po ehe retired oppe dlidueu oeeuon.
