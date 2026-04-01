Scope
- Close Gate A (security + tenant context) at the Interfacing layer without coupling to Role domain.

Tenant resolution
- Header: X-SR-Tenant
- Request attribute: tenantId
- Default: SR_TENANT_DEFAULT

Permission naming
- Screen: interfacing.screen.<screenId>
- Action: interfacing.action.<screenId>.<actionId>

Voter mapping (optional)
- Attribute -> role:
  - interfacing.screen.category-admin -> ROLE_INTERFACING_SCREEN_CATEGORY_ADMIN
  - interfacing.action.category-admin.save -> ROLE_INTERFACING_ACTION_CATEGORY_ADMIN_SAVE

Audit sink
- Monolog channel: interfacing
- Log file: var/log/interfacing.log
