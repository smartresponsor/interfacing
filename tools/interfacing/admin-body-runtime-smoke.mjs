#!/usr/bin/env node
// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
// Browser-side smoke harness for the Interfacing admin body runtime contract.
//
// This script intentionally does not implement an Ant Design ProComponents UI.
// It supplies a tiny DOM/event harness and verifies only the contract-level
// outcomes: schema validation, provider registry lookup, strict provider-required failure when the primary provider is absent, and ready hydration when a provider is registered.

import fs from 'node:fs';
import path from 'node:path';
import vm from 'node:vm';
import { fileURLToPath } from 'node:url';

const __filename = fileURLToPath(import.meta.url);
const projectRoot = path.resolve(path.dirname(__filename), '../..');
const providerRegistryPath = path.join(projectRoot, 'assets/interfacing/admin-body/provider-registry.js');
const runtimePath = path.join(projectRoot, 'assets/interfacing/admin-body/runtime.js');
const MOUNT_SELECTOR = '[data-interfacing-admin-body-mount="true"]';
const SCHEMA_SELECTOR = '[data-interfacing-admin-body-schema="true"]';

class SmokeEventTarget {
  constructor(name) {
    this.name = name;
    this.listeners = new Map();
    this.events = [];
  }

  addEventListener(type, listener, options = {}) {
    const listeners = this.listeners.get(type) || [];
    listeners.push({ listener, once: Boolean(options.once) });
    this.listeners.set(type, listeners);
  }

  removeEventListener(type, listener) {
    const listeners = this.listeners.get(type) || [];
    this.listeners.set(type, listeners.filter((entry) => entry.listener !== listener));
  }

  dispatchEvent(event) {
    this.events.push(event);
    const listeners = [...(this.listeners.get(event.type) || [])];

    for (const entry of listeners) {
      entry.listener.call(this, event);
    }

    this.listeners.set(event.type, (this.listeners.get(event.type) || []).filter((entry) => !entry.once));

    return true;
  }
}

class SmokeCustomEvent {
  constructor(type, options = {}) {
    this.type = type;
    this.detail = options.detail || null;
    this.bubbles = Boolean(options.bubbles);
  }
}

class SmokeSchemaNode {
  constructor(schema) {
    this.textContent = JSON.stringify(schema);
  }
}

class SmokeMount extends SmokeEventTarget {
  constructor(schema) {
    super('mount');
    this.dataset = { adminBodyHydration: 'pending' };
    this.schemaNode = new SmokeSchemaNode(schema);
  }

  querySelector(selector) {
    if (selector === SCHEMA_SELECTOR) {
      return this.schemaNode;
    }

    return null;
  }
}

class SmokeDocument extends SmokeEventTarget {
  constructor(mount) {
    super('document');
    this.readyState = 'complete';
    this.mount = mount;
  }

  querySelectorAll(selector) {
    if (selector === MOUNT_SELECTOR) {
      return [this.mount];
    }

    return [];
  }
}

function loadBrowserModule(filePath) {
  return fs.readFileSync(filePath, 'utf8')
    .replace(/export\s*\{[\s\S]*?\};\s*$/m, '');
}

function createValidSchema() {
  const requiredTopLevelKeys = [
    'schema',
    'version',
    'providers',
    'schemaManifest',
    'providerPolicy',
    'resource',
    'resourceContract',
    'operationPolicy',
    'toolbarPolicy',
    'rowSelectionPolicy',
    'tableInteractionPolicy',
    'emptyStatePolicy',
    'formLifecyclePolicy',
    'detailViewPolicy',
    'navigationPolicy',
    'authorizationPolicy',
    'telemetryPolicy',
    'accessibilityPolicy',
    'responsiveLayoutPolicy',
    'operation',
    'surface',
    'view',
    'locale',
    'toolbar',
    'table',
    'cards',
    'form',
    'actions',
    'runtime',
    'hydration',
  ];
  const requiredPolicyKeys = [
    'providerPolicy',
    'resourceContract',
    'operationPolicy',
    'toolbarPolicy',
    'rowSelectionPolicy',
    'tableInteractionPolicy',
    'emptyStatePolicy',
    'formLifecyclePolicy',
    'detailViewPolicy',
    'navigationPolicy',
    'authorizationPolicy',
    'telemetryPolicy',
    'accessibilityPolicy',
    'responsiveLayoutPolicy',
  ];

  return {
    schema: 'interfacing.admin.body',
    version: '1.0',
    providers: { primary: 'antd-pro', secondary: 'primereact' },
    schemaManifest: {
      name: 'admin-body-schema-manifest',
      version: '1.0',
      owner: 'interfacing-admin-body-contract',
      requiredTopLevelKeys,
      requiredPolicyKeys,
      providerTargets: { primaryAdminWorkbench: 'ant-design-procomponents', secondaryRichFacade: 'primereact' },
      runtimeChecks: { validateManifest: true, validatePolicies: true, requireCanonicalProviders: true },
    },
    providerPolicy: {
      primary: { provider: 'antd-pro', role: 'admin-workbench', required: true, expectedForSurface: 'admin' },
      secondary: { provider: 'primereact', role: 'rich-facade', replacementMode: 'forbidden-for-admin-body', mayReplacePrimary: false },
    },
    resource: { name: 'smoke-resource' },
    resourceContract: {
      dataSource: { mode: 'server-driven' },
      columns: [{ key: 'id', dataIndex: 'id', title: 'ID' }],
      filters: [],
      formFields: [{ name: 'title', valueType: 'text' }],
      headerActions: ['create'],
      rowActions: ['view', 'edit', 'delete'],
    },
    operationPolicy: {
      name: 'admin-body-operation-policy',
      version: '1.0',
      supportedOperations: ['index', 'show', 'new', 'edit', 'delete'],
      currentOperation: 'index',
      headerActions: ['create'],
      rowActions: ['view', 'edit', 'delete'],
      destructiveActions: ['delete'],
      confirmation: { delete: { required: true } },
      providerTargets: { headerActions: 'PageContainer.extra', rowActions: 'ProTable.actionColumn' },
    },
    toolbarPolicy: {
      name: 'admin-body-toolbar-policy',
      version: '1.0',
      controls: ['search', 'filters', 'content-locale', 'view-mode', 'bulk-actions'],
      search: {},
      filters: {},
      contentLocale: {},
      viewMode: {},
      bulkActions: { mode: 'guarded-by-row-selection' },
      providerTargets: {},
    },
    rowSelectionPolicy: {
      name: 'admin-body-row-selection-policy',
      version: '1.0',
      enabled: true,
      rowKey: 'id',
      selectionType: 'checkbox',
      mode: 'guarded-by-row-selection',
      bulkActions: { enabled: true },
      providerTargets: { rowSelection: 'ProTable.rowSelection', tableAlertOption: 'ProTable.tableAlertOption', bulkActions: 'ProTable.tableAlertOption.bulkActions' },
    },
    tableInteractionPolicy: {
      name: 'admin-body-table-interaction-policy',
      version: '1.0',
      pagination: { mode: 'server-driven' },
      sorting: { mode: 'server-driven' },
      density: { allowed: ['small', 'middle', 'large'] },
      providerTargets: { pagination: 'ProTable.pagination', sorting: 'ProTable.columns.sorter', density: 'ProTable.options' },
    },
    emptyStatePolicy: {
      name: 'admin-body-empty-state-policy',
      version: '1.0',
      states: { empty: {}, loading: {}, error: {}, validationError: {}, offline: {} },
      actions: ['retry', 'reset-filters', 'create'],
      providerTargets: { empty: 'ProTable.locale.emptyText', loading: 'ProTable.loading', error: 'Result.error', validationError: 'ProForm.validation', offline: 'Alert.offline' },
    },
    formLifecyclePolicy: {
      name: 'admin-body-form-lifecycle-policy',
      version: '1.0',
      modes: ['create', 'edit'],
      submit: { mode: 'server-driven' },
      actions: { save: {}, saveAndContinue: {}, cancel: {}, reset: {} },
      dirtyState: { guard: 'confirm-on-navigate-away' },
      validation: {},
      feedback: {},
      providerTargets: { form: 'ProForm', submitter: 'ProForm.submitter', validation: 'ProForm.validation', dirtyConfirm: 'Modal.confirm', success: 'message.success', error: 'message.error' },
    },
    detailViewPolicy: {
      name: 'admin-body-detail-view-policy',
      version: '1.0',
      mode: 'show',
      layout: 'read-only',
      sections: { general: {}, metadata: {}, relations: {} },
      actions: { backToList: {}, edit: {}, delete: { confirmation: 'confirmation-required' } },
      destructiveActions: ['delete'],
      providerTargets: { page: 'PageContainer', descriptions: 'Descriptions', metadata: 'ProCard.metadata', relations: 'ProCard.relations', actions: 'PageContainer.extra', deleteConfirm: 'Modal.confirm' },
    },
    navigationPolicy: {
      name: 'admin-body-navigation-policy',
      version: '1.0',
      scope: 'body',
      globalNavigationOwner: 'ecosystem-shell',
      breadcrumbs: [],
      backAction: {},
      resourceContext: {},
      routeContext: {},
      providerTargets: { breadcrumbs: 'PageContainer.breadcrumb', backAction: 'PageContainer.extra.back', resourceContext: 'PageContainer.header.resourceContext', routeContext: 'PageContainer.header.routeContext' },
    },
    authorizationPolicy: {
      name: 'admin-body-authorization-policy',
      version: '1.0',
      mode: 'server-declared-action-state',
      enforcementOwner: 'backend-security-voters',
      uiResponsibility: 'visibility-and-disabled-state-only',
      defaultDecision: 'disabled-until-authorized',
      actionGroups: { headerActions: {}, rowActions: {}, bulkActions: {}, formActions: {}, detailActions: {} },
      deniedActionBehavior: {},
      providerTargets: { headerActions: 'PageContainer.extra', rowActions: 'ProTable.actionColumn', bulkActions: 'ProTable.tableAlertOption.bulkActions', formActions: 'ProForm.submitter', detailActions: 'PageContainer.extra', disabledReason: 'Tooltip.disabledReason' },
    },
    telemetryPolicy: {
      name: 'admin-body-telemetry-policy',
      version: '1.0',
      mode: 'browser-ui-events',
      owner: 'interfacing-admin-body-runtime',
      backendAuditOwner: 'backend-audit-log',
      piiPolicy: 'no-field-values-in-ui-events',
      correlation: {},
      events: { hydrationReady: {}, hydrationFailed: {}, providerRequiredError: {}, actionIntent: {}, actionDenied: {}, viewModeChanged: {}, contentLocaleChanged: {}, selectionChanged: {}, formDirtyStateChanged: {}, formSubmitIntent: {} },
      requiredDetailKeys: ['resource', 'operation', 'surface', 'provider', 'hydration'],
      providerTargets: {},
    },
    accessibilityPolicy: {
      name: 'admin-body-accessibility-policy',
      version: '1.0',
      mode: 'provider-native-required',
      owner: 'interfacing-admin-body-runtime',
      landmarks: { main: {}, toolbar: {}, table: {}, form: {}, detail: {} },
      keyboard: { required: true },
      focus: { restoreAfterAction: true },
      announcements: { enabled: true },
      labels: {},
      providerTargets: { page: 'PageContainer', toolbar: 'ProTable.toolbar', table: 'ProTable', form: 'ProForm', detail: 'Descriptions', liveRegion: 'aria-live-region', focusManagement: 'focus-management' },
    },
    responsiveLayoutPolicy: {
      name: 'admin-body-responsive-layout-policy',
      version: '1.0',
      mode: 'provider-native-responsive-layout',
      shellOwner: 'ecosystem-shell',
      bodyOwner: 'ant-design-procomponents',
      breakpoints: { desktop: {}, tablet: {}, mobile: {} },
      density: { allowed: ['small', 'middle', 'large'] },
      table: {},
      cards: {},
      filters: {},
      forms: {},
      detail: {},
      providerTargets: { page: 'PageContainer', table: 'ProTable', tableScroll: 'ProTable.scroll', tableOptions: 'ProTable.options', filters: 'ProTable.search', form: 'ProForm.layout', cards: 'ProCard.grid', detail: 'Descriptions.column' },
    },
    operation: 'index',
    surface: 'admin',
    view: { default: 'table', modes: ['table', 'cards'] },
    locale: { contentLocale: 'en' },
    toolbar: {},
    table: {},
    cards: {},
    form: {},
    actions: {},
    runtime: {},
    hydration: {},
  };
}

function createContext(schema) {
  const mount = new SmokeMount(schema);
  const windowTarget = new SmokeEventTarget('window');
  const documentTarget = new SmokeDocument(mount);
  const context = {
    window: windowTarget,
    document: documentTarget,
    CustomEvent: SmokeCustomEvent,
    console,
  };

  windowTarget.window = windowTarget;
  windowTarget.document = documentTarget;
  documentTarget.defaultView = windowTarget;

  vm.createContext(context);

  return { context, window: windowTarget, document: documentTarget, mount };
}

function runBrowserModule(context, filePath) {
  vm.runInContext(loadBrowserModule(filePath), context, { filename: filePath });
}

function assert(condition, message) {
  if (!condition) {
    throw new Error(message);
  }
}

function runProviderRequiredErrorScenario() {
  const env = createContext(createValidSchema());

  runBrowserModule(env.context, providerRegistryPath);
  runBrowserModule(env.context, runtimePath);

  assert(env.mount.dataset.adminBodyHydration === 'provider-required-error', `Expected provider-required-error hydration state when AntD provider is absent, got ${env.mount.dataset.adminBodyHydration}. Events: ${env.mount.events.map((event) => event.type).join(',')}`);
  assert(!env.mount.events.some((event) => event.type === 'interfacing:admin-body:ready'), 'Ready event must not fire when the canonical provider is absent.');
  assert(env.mount.events.some((event) => event.type === 'interfacing:admin-body:provider-required-error'), 'Expected provider-required-error event.');
}

function runPrimaryProviderReadyScenario() {
  const env = createContext(createValidSchema());
  let mounted = false;

  runBrowserModule(env.context, providerRegistryPath);
  env.window.InterfacingAdminBodyProviderRegistry.register('antd-pro', {
    mount(mount, schema) {
      mounted = true;
      assert(mount === env.mount, 'Provider received an unexpected mount node.');
      assert(schema.schema === 'interfacing.admin.body', 'Provider received an unexpected schema payload.');
    },
  });
  runBrowserModule(env.context, runtimePath);

  assert(mounted === true, 'Expected registered AntD provider to be mounted.');
  assert(env.mount.dataset.adminBodyHydration === 'ready', 'Expected ready hydration state when AntD provider is registered.');
  assert(env.mount.events.some((event) => event.type === 'interfacing:admin-body:ready'), 'Expected ready event in provider-ready scenario.');
}

const scenarios = [
  ['provider-required-error', runProviderRequiredErrorScenario],
  ['primary-provider-ready', runPrimaryProviderReadyScenario],
];

try {
  for (const [, runScenario] of scenarios) {
    runScenario();
  }

  console.log('Interfacing admin body runtime smoke: OK');
} catch (error) {
  console.error('Interfacing admin body runtime smoke: FAILED');
  console.error(error instanceof Error ? error.message : String(error));
  process.exit(2);
}
