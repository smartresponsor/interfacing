import {
  InterfacingProviderDefinition,
  InterfacingProviderMountContext,
  InterfacingProviderRegistryApi,
  normalizeComponentName,
  readEmbeddedSchema,
  readJsonAttribute
} from './contract';

const providers = new Map<string, InterfacingProviderDefinition>();

function normalizeProvider(value: string): string {
  return value.trim().replace(/_/g, '-').toLowerCase();
}

function resolveMountContext(element: HTMLElement): InterfacingProviderMountContext | null {
  const navigationMount = element.matches('[data-interfacing-navigation-provider-mount="true"]');
  const provider = normalizeProvider(
    element.dataset.interfacingProvider
      || element.dataset.interfacingSecondaryProvider
      || 'antd-pro'
  );
  const component = normalizeComponentName(
    element.dataset.interfacingComponent
      || element.dataset.interfacingProviderComponent
      || (navigationMount ? 'navigation-menu' : 'domain-surface')
  );
  const payload = readJsonAttribute(element, 'data-interfacing-payload');
  const schema = navigationMount
    ? readEmbeddedSchema(element, 'script[data-interfacing-navigation-provider-schema="true"]')
    : undefined;

  return { element, provider, component, payload, schema };
}

function mountElement(element: HTMLElement): boolean {
  if (element.dataset.interfacingProviderMounted === 'true') {
    return false;
  }

  const context = resolveMountContext(element);

  if (!context) {
    return false;
  }

  const provider = providers.get(context.provider);

  if (!provider) {
    element.dataset.interfacingProviderMounted = 'missing-provider';
    return false;
  }

  const normalizedComponents = provider.components.map(normalizeComponentName);

  if (!normalizedComponents.includes(context.component)) {
    element.dataset.interfacingProviderMounted = 'unsupported-component';
    return false;
  }

  provider.mount(context);
  element.dataset.interfacingProviderMounted = 'true';

  return true;
}

function mountAll(root: ParentNode = document): number {
  const mountSelector = [
    '[data-interfacing-provider][data-interfacing-component][data-interfacing-payload]',
    '[data-interfacing-navigation-provider-mount="true"]'
  ].join(',');
  const elements = Array.from(root.querySelectorAll<HTMLElement>(mountSelector));

  return elements.reduce((mountedCount, element) => mountedCount + (mountElement(element) ? 1 : 0), 0);
}

export const registry: InterfacingProviderRegistryApi = {
  register(definition: InterfacingProviderDefinition): void {
    providers.set(normalizeProvider(definition.provider), definition);
  },
  has(provider: string): boolean {
    return providers.has(normalizeProvider(provider));
  },
  get(provider: string): InterfacingProviderDefinition | undefined {
    return providers.get(normalizeProvider(provider));
  },
  mountAll,
  mountElement,
  list(): string[] {
    return Array.from(providers.keys()).sort();
  }
};

export function exposeRegistry(): InterfacingProviderRegistryApi {
  window.InterfacingProviderRegistry = registry;

  return registry;
}
