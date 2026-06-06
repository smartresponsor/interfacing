export type InterfacingJson = null | boolean | number | string | InterfacingJson[] | { [key: string]: InterfacingJson };

export interface InterfacingNavigationItem {
  key?: string;
  id?: string;
  label?: string;
  title?: string;
  url?: string;
  href?: string;
  active?: boolean;
  children?: InterfacingNavigationItem[];
  items?: InterfacingNavigationItem[];
  metadata?: Record<string, unknown>;
}

export interface InterfacingProviderMountContext {
  element: HTMLElement;
  provider: string;
  component: string;
  payload: Record<string, unknown>;
  schema?: Record<string, unknown>;
}

export interface InterfacingProviderDefinition {
  provider: string;
  components: string[];
  mount(context: InterfacingProviderMountContext): void;
}

export interface InterfacingProviderRegistryApi {
  register(definition: InterfacingProviderDefinition): void;
  has(provider: string): boolean;
  get(provider: string): InterfacingProviderDefinition | undefined;
  mountAll(root?: ParentNode): number;
  mountElement(element: HTMLElement): boolean;
  list(): string[];
}

declare global {
  interface Window {
    InterfacingProviderRegistry?: InterfacingProviderRegistryApi;
  }
}

export function readJsonAttribute(element: HTMLElement, attributeName: string): Record<string, unknown> {
  const rawValue = element.getAttribute(attributeName);

  if (!rawValue) {
    return {};
  }

  try {
    const parsed = JSON.parse(rawValue);

    if (parsed && typeof parsed === 'object' && !Array.isArray(parsed)) {
      return parsed as Record<string, unknown>;
    }
  } catch (error) {
    console.warn('Interfacing provider payload is not valid JSON.', { attributeName, error });
  }

  return {};
}

export function readEmbeddedSchema(element: HTMLElement, selector: string): Record<string, unknown> {
  const script = element.querySelector<HTMLScriptElement>(selector);

  if (!script?.textContent) {
    return {};
  }

  try {
    const parsed = JSON.parse(script.textContent);

    if (parsed && typeof parsed === 'object' && !Array.isArray(parsed)) {
      return parsed as Record<string, unknown>;
    }
  } catch (error) {
    console.warn('Interfacing provider schema is not valid JSON.', { selector, error });
  }

  return {};
}

export function normalizeComponentName(value: string): string {
  return value.trim().replace(/[_\s]+/g, '-').toLowerCase();
}

export function asRecord(value: unknown): Record<string, unknown> {
  return value && typeof value === 'object' && !Array.isArray(value) ? value as Record<string, unknown> : {};
}

export function asRecordArray(value: unknown): Record<string, unknown>[] {
  return Array.isArray(value) ? value.filter((item): item is Record<string, unknown> => Boolean(item) && typeof item === 'object' && !Array.isArray(item)) : [];
}

export function asString(value: unknown, fallback = ''): string {
  return typeof value === 'string' && value.length > 0 ? value : fallback;
}
