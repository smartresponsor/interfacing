import { asRecord, asRecordArray, asString } from '../contract';

export interface InterfacingWorkbenchColumn {
  title: string;
  dataIndex: string;
  key: string;
}

export interface InterfacingWorkbenchData {
  title: string;
  description: string;
  columns: InterfacingWorkbenchColumn[];
  rows: Record<string, unknown>[];
  headerActions: Record<string, unknown>[];
  routeContext: Record<string, unknown>;
}

export function resolveWorkbenchData(payload: Record<string, unknown>, schema: Record<string, unknown> = {}): InterfacingWorkbenchData {
  const workbench = asRecord(payload.workbench ?? schema);
  const routeContext = asRecord(workbench.routeContext ?? payload.routeContext ?? payload.route_context);
  const rawRows = asRecordArray(workbench.rows ?? payload.rows ?? payload.bindings);
  const rawColumns = asRecordArray(workbench.columns ?? payload.columns);
  const fallbackColumns = rawRows.length > 0
    ? Object.keys(rawRows[0]).slice(0, 6).map((key) => ({ title: key, dataIndex: key, key }))
    : [
      { title: 'Key', dataIndex: 'key', key: 'key' },
      { title: 'Label', dataIndex: 'label', key: 'label' },
      { title: 'Status', dataIndex: 'status', key: 'status' }
    ];

  const columns = rawColumns.length > 0
    ? rawColumns.map((column, index) => {
      const key = asString(column.key, asString(column.dataIndex, asString(column.data_index, `column_${index}`)));

      return {
        title: asString(column.title, asString(column.label, key)),
        dataIndex: asString(column.dataIndex, asString(column.data_index, key)),
        key
      };
    })
    : fallbackColumns;

  return {
    title: asString(workbench.title, asString(routeContext.resourceLabel, 'Provider workbench')),
    description: asString(workbench.description, 'React provider-mounted Interfacing surface.'),
    columns,
    rows: rawRows.map((row, index) => ({ key: asString(row.key, asString(row.id, String(index + 1))), ...row })),
    headerActions: asRecordArray(workbench.headerActions ?? payload.headerActions ?? payload.header_actions),
    routeContext
  };
}
