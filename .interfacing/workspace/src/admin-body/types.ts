export type AdminBodyProviderName = 'antd-pro' | 'primereact';

export interface AdminBodyProvider {
  mount(mount: HTMLElement, schema: AdminBodySchema): void;
}

export interface AdminBodySchema {
  resource?: string;
  operation?: string;
  surface?: string;
  defaultView?: string;
  contentLocale?: string;
  resourceContract?: {
    columns?: Array<{ key?: string; dataIndex?: string; title?: string; valueType?: string }>;
    filters?: Array<{ key?: string; title?: string; valueType?: string }>;
    formFields?: Array<{ name?: string; label?: string; valueType?: string; required?: boolean }>;
    rowActions?: Array<{ key?: string; label?: string; destructive?: boolean }>;
    headerActions?: Array<{ key?: string; label?: string }>;
    dataSource?: { items?: Array<Record<string, unknown>> };
  };
  operationPolicy?: { currentOperation?: string };
  toolbarPolicy?: { controls?: string[] };
  detailViewPolicy?: { sections?: Array<{ key?: string; title?: string }> };
  providerPolicy?: Record<string, unknown>;
  [key: string]: unknown;
}

export function getResourceLabel(schema: AdminBodySchema): string {
  const label = schema.resourceContract && (schema.resourceContract as Record<string, unknown>).label;
  if (typeof label === 'string' && label.trim() !== '') {
    return label;
  }

  if (typeof schema.resource === 'string' && schema.resource.trim() !== '') {
    return schema.resource.charAt(0).toUpperCase() + schema.resource.slice(1);
  }

  return 'Resource';
}

export function getOperation(schema: AdminBodySchema): string {
  if (typeof schema.operation === 'string' && schema.operation.trim() !== '') {
    return schema.operation;
  }

  if (schema.operationPolicy?.currentOperation) {
    return schema.operationPolicy.currentOperation;
  }

  return 'index';
}

export function getRows(schema: AdminBodySchema): Array<Record<string, unknown>> {
  const items = schema.resourceContract?.dataSource?.items;
  if (Array.isArray(items) && items.length > 0) {
    return items;
  }

  return [
    { id: 'sample-1', title: 'Provider-rendered item', status: 'ready', locale: schema.contentLocale || 'en' },
    { id: 'sample-2', title: 'Canonical admin body', status: 'draft', locale: schema.contentLocale || 'en' }
  ];
}
