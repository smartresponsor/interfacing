import React from 'react';
import { createRoot } from 'react-dom/client';
import { Card } from 'primereact/card';
import { PanelMenu } from 'primereact/panelmenu';
import { Tag } from 'primereact/tag';
import { Timeline } from 'primereact/timeline';
import { InterfacingProviderDefinition, InterfacingProviderMountContext, asRecordArray, asString, normalizeComponentName } from '../contract';
import { registry } from '../registry';
import { resolveNavigationItems } from '../component/navigation';
import { resolveWorkbenchData } from '../component/workbench';
import '../styles/canonical-providers.interfacing-interface-ui.css';

function NavigationMenu({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
  const items = resolveNavigationItems(context.schema ?? {}, context.payload);
  const model = items.map((item) => ({
    key: item.key,
    label: item.label ?? item.title ?? item.key,
    url: item.href ?? item.url ?? '#',
    items: item.children?.map((child) => ({
      key: child.key,
      label: child.label ?? child.title ?? child.key,
      url: child.href ?? child.url ?? '#'
    }))
  }));

  return React.createElement(PanelMenu, {
    model,
    className: 'interfacing-react-provider-navigation interfacing-react-provider-navigation--primereact'
  });
}

function DiagnosticCard({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
  const diagnostic = context.payload.diagnostic && typeof context.payload.diagnostic === 'object'
    ? context.payload.diagnostic as Record<string, unknown>
    : context.payload;
  const issues = asRecordArray(diagnostic.issues);
  const warnings = asRecordArray(diagnostic.warnings);
  const timelineItems = issues.length > 0 ? issues : [{ code: 'ok', message: 'No blocking diagnostic issues.' }];

  return React.createElement(Card, {
    title: 'Operational posture',
    subTitle: asString(diagnostic.generatedAt, asString(diagnostic.generated_at, 'No diagnostic timestamp received.')),
    className: 'interfacing-react-provider-card interfacing-react-provider-card--primereact'
  },
    React.createElement('div', { className: 'interfacing-react-provider-tag-row' },
      React.createElement(Tag, { value: `Issues: ${issues.length}`, severity: issues.length > 0 ? 'danger' : 'success' }),
      React.createElement(Tag, { value: `Warnings: ${warnings.length}`, severity: warnings.length > 0 ? 'warning' : 'info' })
    ),
    React.createElement(Timeline, {
      value: timelineItems,
      content: (item: unknown) => {
        const record = item && typeof item === 'object' && !Array.isArray(item) ? item as Record<string, unknown> : {};

        return React.createElement('span', {}, `${asString(record.code, 'event')} — ${asString(record.message, asString(record.description, 'Review required.'))}`);
      }
    })
  );
}

function WorkbenchCard({ context }: { context: InterfacingProviderMountContext }): React.ReactElement {
  const workbench = resolveWorkbenchData(context.payload, context.schema ?? {});

  return React.createElement(Card, {
    title: workbench.title,
    subTitle: workbench.description,
    className: 'interfacing-react-provider-card interfacing-react-provider-card--primereact'
  },
    React.createElement('dl', { className: 'interfacing-react-provider-definition-list' },
      Object.entries(workbench.routeContext).slice(0, 6).map(([key, value]) => React.createElement('div', { key },
        React.createElement('dt', {}, key),
        React.createElement('dd', {}, String(value ?? ''))
      ))
    ),
    React.createElement('div', { className: 'interfacing-react-provider-record-count' }, `${workbench.rows.length} rows ready for provider rendering`)
  );
}

function renderComponent(context: InterfacingProviderMountContext): React.ReactElement {
  const component = normalizeComponentName(context.component);

  if (component === 'navigation-menu') {
    return React.createElement(NavigationMenu, { context });
  }

  if (['domain-diagnostic-card', 'diagnostic-card', 'operational-posture'].includes(component)) {
    return React.createElement(DiagnosticCard, { context });
  }

  return React.createElement(WorkbenchCard, { context });
}

export const primeReactProvider: InterfacingProviderDefinition = {
  provider: 'primereact',
  components: ['navigation-menu', 'domain-diagnostic-card', 'diagnostic-card', 'domain-surface', 'workbench'],
  mount(context: InterfacingProviderMountContext): void {
    const root = createRoot(context.element);

    root.render(renderComponent(context));
  }
};

registry.register(primeReactProvider);
