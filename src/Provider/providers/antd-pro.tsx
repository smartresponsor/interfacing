import React from 'react';
import { createRoot } from 'react-dom/client';
import { App, Button, ConfigProvider, Empty, Menu, Space, Tag } from 'antd';
import type { MenuProps } from 'antd';
import { ProCard, ProDescriptions, ProTable } from '@ant-design/pro-components';
import { InterfacingProviderDefinition, InterfacingProviderMountContext, asString, normalizeComponentName } from '../contract';
import { registry } from '../registry';
import { activeNavigationKeys, resolveNavigationItems } from '../component/navigation';
import { resolveWorkbenchData } from '../component/workbench';
import '../styles/canonical-providers.interfacing-interface-ui.css';

function toMenuItems(items: ReturnType<typeof resolveNavigationItems>): MenuProps['items'] {
  return items.map((item) => ({
    key: item.key ?? item.href ?? item.label ?? 'item',
    label: React.createElement('a', { href: item.href ?? item.url ?? '#' }, item.label ?? item.title ?? item.key),
    children: item.children && item.children.length > 0 ? toMenuItems(item.children) : undefined
  }));
}

function NavigationMenu({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
  const items = resolveNavigationItems(context.schema ?? {}, context.payload);
  const selectedKeys = activeNavigationKeys(items);

  return React.createElement(Menu, {
    mode: context.element.dataset.interfacingNavigationLocation?.startsWith('shell.footer.') ? 'horizontal' : 'inline',
    selectedKeys,
    items: toMenuItems(items),
    className: 'interfacing-react-provider-navigation interfacing-react-provider-navigation--antd'
  });
}

function Workbench({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
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
        surface: asString(workbench.routeContext.surface, 'admin')
      },
      columns: [
        { title: 'Component', dataIndex: 'component' },
        { title: 'Resource', dataIndex: 'resource' },
        { title: 'Operation', dataIndex: 'operation' },
        { title: 'Surface', dataIndex: 'surface' }
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

function ProviderFallback({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
  return React.createElement(ProCard, {
    title: `AntD provider: ${context.component}`,
    className: 'interfacing-react-provider-card interfacing-react-provider-card--antd'
  },
    React.createElement(Tag, { color: 'blue' }, context.provider),
    React.createElement('pre', { className: 'interfacing-react-provider-pre' }, JSON.stringify(context.payload, null, 2))
  );
}

function renderComponent(context: InterfacingProviderMountContext): React.ReactElement {
  const component = normalizeComponentName(context.component);

  if (component === 'navigation-menu') {
    return React.createElement(NavigationMenu, { context });
  }

  if (['domain-workbench', 'domain-surface', 'workbench', 'provider-handoff'].includes(component)) {
    return React.createElement(Workbench, { context });
  }

  return React.createElement(ProviderFallback, { context });
}

export const antdProProvider: InterfacingProviderDefinition = {
  provider: 'antd-pro',
  components: ['navigation-menu', 'domain-workbench', 'domain-surface', 'workbench', 'provider-handoff'],
  mount(context: InterfacingProviderMountContext): void {
    const root = createRoot(context.element);

    root.render(
      React.createElement(ConfigProvider, {
        theme: {
          token: {
            borderRadius: 4,
            colorPrimary: '#2563eb',
            fontFamily: 'var(--interfacing-provider-font-family)'
          }
        }
      }, React.createElement(App, {}, renderComponent(context)))
    );
  }
};

registry.register(antdProProvider);
