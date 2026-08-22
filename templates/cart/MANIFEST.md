# cart UI surface

This directory contains Interfacing-owned UI templates for the `cart` surface. It is not an ecosystem component ownership boundary.

Canonical entry point:
- `templates/cart/base.html.twig`

Runtime rule:
- if the canonical template exists, Interfacing renders it with the cart surface payload;
- if it does not exist, Interfacing returns the normalized cart payload as JSON without throwing.

