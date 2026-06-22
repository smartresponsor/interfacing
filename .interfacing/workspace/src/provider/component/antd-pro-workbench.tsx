import React from 'react';
import { Button, Empty, Space } from 'antd';
import { ProCard, ProDescriptions, ProTable } from '@ant-design/pro-components';
import { InterfacingProviderMountContext, asString } from '../contract';
import { resolveWorkbenchData } from './workbench';

export function AntdProWorkbench({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
  const workbench = resolveWorkbenchData(context.payload, context.schema ?? {});

  return React.createElement(ProCard, {
    title: workbench.title,
    extra: React.createElement(Space, {}, workbench.headerActions.map((action, index) => {
      const href = asString(action.href);
      const key = asString(action.key, asString(action.operation, String(index)));
      const type: React.ComponentProps<typeof Button>['type'] = action.variant === 'primary' ? 'primary' : 'default';
      const label = asString(action.label, 'Action');

      if (href) {
        return React.createElement(Button, { key, type, href }, label);
      }

      return React.createElement(Button, { key, type }, label);
    })),
    className: 'interfacing-react-provider-card interfacing-react-provider-card--antd'
  },
    React.createElement(ProDescriptions, {
      column: 2,
      size: 'small',
      dataSource: {
        component: asString(workbench.routeContext.component, 'Interfacing'),
        resource: asString(workbench.routeContext.resourcePath, asString(workbench.routeContext.resourceLabel, 'resource')),
        operation: asString(workbench.routeContext.operation, 'index'),
        view: asString(workbench.routeContext.view, 'admin')
      },
      columns: [
        { title: 'Component', dataIndex: 'component' },
        { title: 'Resource', dataIndex: 'resource' },
        { title: 'Operation', dataIndex: 'operation' },
        { title: 'View', dataIndex: 'view' }
      ]
    }),
    React.createElement(ProTable, {
      rowKey: 'key',
      search: false,
      options: false,
      pagination: workbench.rows.length > 10 ? { pageSize: 10 } : false,
      columns: workbench.columns,
      dataSource: workbench.rows,
      locale: { emptyText: React.createElement(Empty, { description: 'No provider rows.' }) }
    })
  );
}

export default AntdProWorkbench;
