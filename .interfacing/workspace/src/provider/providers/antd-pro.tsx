import React from 'react';
import { createRoot } from 'react-dom/client';
import { App, Card, ConfigProvider, Menu, Spin, Tag } from 'antd';
import type { MenuProps } from 'antd';
import { InterfacingProviderDefinition, InterfacingProviderMountContext, normalizeComponentName } from '../contract';
import { registry } from '../registry';
import { activeNavigationKeys, resolveNavigationItems } from '../component/navigation';
import '../styles/canonical-providers.interfacing-interface-ui.css';

const LazyWorkbench = React.lazy(() => import('../component/antd-pro-workbench'));

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

function ProviderLoading(): React.ReactElement {
  return React.createElement('div', { className: 'interfacing-react-provider-loading' },
    React.createElement(Spin, { size: 'small' }),
    React.createElement('span', {}, 'Loading provider view...')
  );
}

function WorkbenchView({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
  return React.createElement(React.Suspense, { fallback: React.createElement(ProviderLoading) },
    React.createElement(LazyWorkbench, { context })
  );
}

function ProviderFallback({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
  return React.createElement(Card, {
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

  if (['domain-workbench', 'domain-view', 'workbench', 'provider-handoff'].includes(component)) {
    return React.createElement(WorkbenchView, { context });
  }

  return React.createElement(ProviderFallback, { context });
}

export const antdProProvider: InterfacingProviderDefinition = {
  provider: 'antd-pro',
  components: ['navigation-menu', 'domain-workbench', 'domain-view', 'workbench', 'provider-handoff'],
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
