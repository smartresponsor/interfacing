import { InterfacingNavigationItem, asRecord, asRecordArray, asString } from '../contract';

function normalizeItem(item: Record<string, unknown>, fallbackKey: string): InterfacingNavigationItem {
  const children = asRecordArray(item.children ?? item.items).map((child, index) => normalizeItem(child, `${fallbackKey}-${index}`));

  return {
    key: asString(item.key, asString(item.id, fallbackKey)),
    id: asString(item.id, fallbackKey),
    label: asString(item.label, asString(item.title, asString(item.key, fallbackKey))),
    title: asString(item.title, asString(item.label, fallbackKey)),
    url: asString(item.url, asString(item.href, '#')),
    href: asString(item.href, asString(item.url, '#')),
    active: item.active === true,
    children,
    items: children,
    metadata: asRecord(item.metadata)
  };
}

export function resolveNavigationItems(schema: Record<string, unknown>, payload: Record<string, unknown>): InterfacingNavigationItem[] {
  const payloadItems = asRecordArray(payload.items ?? payload.navigationItems ?? payload.navigation_items);

  if (payloadItems.length > 0) {
    return payloadItems.map((item, index) => normalizeItem(item, `payload-${index}`));
  }

  const navigation = asRecord(schema.navigation);
  const locations = asRecord(navigation.locations);
  const locationName = asString(navigation.locationName, Object.keys(locations)[0] ?? 'navigation');
  const locationItems = asRecordArray(locations[locationName]);

  return locationItems.map((item, index) => normalizeItem(item, `${locationName}-${index}`));
}

export function activeNavigationKeys(items: InterfacingNavigationItem[]): string[] {
  const keys: string[] = [];

  for (const item of items) {
    if (item.active && item.key) {
      keys.push(item.key);
    }

    keys.push(...activeNavigationKeys(item.children ?? []));
  }

  return keys;
}
