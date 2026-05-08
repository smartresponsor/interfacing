# Interfacing Admin Body Resource Schema Contract

Wave 13 fixes the next boundary after provider selection: the admin body schema must describe the CRUD resource payload in a provider-neutral, machine-readable shape.

The shell still owns the frame. Twig still owns a provider-less rendering path. The hydrated Ant Design ProComponents provider owns the interactive admin body. To make that possible, the schema now publishes a `resourceContract` section with stable keys for:

- `dataSource` / row key / total count;
- `columns` for ProTable-compatible table rendering;
- `filters` for toolbar/search controls;
- `formFields` for ProForm-compatible create/edit rendering;
- `headerActions` for page-level commands;
- `rowActions` for the action column, including destructive action marking.

This is not a Cruding-specific adapter. It is the common admin body payload contract for any business component that renders collection, show, create, edit, or delete screens inside the ecosystem shell.

Canonical flow:

```text
single ecosystem shell
  -> central admin body mount
      -> provider policy
      -> resourceContract payload
          -> Ant Design ProComponents renderer
          -> Twig provider-less UI if renderer is unavailable
```

PrimeReact remains a secondary rich-facade provider and must not replace the primary Ant Design Pro admin workbench renderer for CRUD/body surfaces.
