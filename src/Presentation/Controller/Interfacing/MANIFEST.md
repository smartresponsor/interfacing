# Presentation controller branch

This branch owns routed Symfony controller entrypoints for Interfacing.
Controllers stay thin and delegate to services, layouts, and view builders.

## Wave 9 route ownership

Controllers own their public Interfacing routes through attributes. Broad workspace routes must remain later than specific controllers in `config/routes/interfacing_attributes.yaml`.

## Wave13 generic CRUD controller boundary

`GenericCrudWorkbenchController` remains the route owner for the broad CRUD bridge routes. The default response is shell-first and lightweight; the heavy CRUD workbench payload is only assembled when the request explicitly opts into `?interactive=1`.
