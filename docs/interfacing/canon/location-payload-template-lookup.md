# Location payload and component-side template lookup

This document supersedes the earlier live-resolver interpretation.

The current canon is:

- producer components own template lookup decisions;
- producer components own business data and fallback decisions;
- Interfacing owns inert template trees, base inheritance, provider assets, Twig partials, and stable slot/location names;
- Interfacing must not expose a live resolver/dispatcher as the general integration mechanism.

See `docs/interfacing/canon/static-slot-location-contract.md` for the authoritative static slot list.
