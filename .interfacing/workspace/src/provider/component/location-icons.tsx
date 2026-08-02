import React from 'react';
import { createRoot } from 'react-dom/client';
import {
  ApartmentOutlined,
  AppstoreOutlined,
  CreditCardOutlined,
  InboxOutlined,
  KeyOutlined,
  LockOutlined,
  LogoutOutlined,
  PaperClipOutlined,
  ShopOutlined,
  ShoppingOutlined,
  StarOutlined,
  SwapOutlined,
  TagsOutlined,
  TeamOutlined,
  TruckOutlined,
  UserOutlined
} from '@ant-design/icons';
import type { AntdIconProps } from '@ant-design/icons/lib/components/AntdIcon';
import type { ComponentType } from 'react';
import 'primeicons/primeicons.css';

const antDesignIcons: Record<string, ComponentType<AntdIconProps>> = {
  ApartmentOutlined,
  AppstoreOutlined,
  CreditCardOutlined,
  InboxOutlined,
  KeyOutlined,
  LockOutlined,
  LogoutOutlined,
  PaperClipOutlined,
  ShopOutlined,
  ShoppingOutlined,
  StarOutlined,
  SwapOutlined,
  TagsOutlined,
  TeamOutlined,
  TruckOutlined,
  UserOutlined
};

const primeIcons: Record<string, string> = {
  ApartmentOutlined: 'pi-building',
  AppstoreOutlined: 'pi-th-large',
  CreditCardOutlined: 'pi-credit-card',
  InboxOutlined: 'pi-inbox',
  KeyOutlined: 'pi-key',
  LockOutlined: 'pi-lock',
  LogoutOutlined: 'pi-sign-out',
  PaperClipOutlined: 'pi-paperclip',
  ShopOutlined: 'pi-shopping-bag',
  ShoppingOutlined: 'pi-shopping-cart',
  StarOutlined: 'pi-star',
  SwapOutlined: 'pi-arrow-right-arrow-left',
  TagsOutlined: 'pi-tags',
  TeamOutlined: 'pi-users',
  TruckOutlined: 'pi-truck',
  UserOutlined: 'pi-user'
};

function resolveStyleProvider(element: HTMLElement): string {
  return element.closest<HTMLElement>('[data-interfacing-style-provider]')?.dataset.interfacingStyleProvider
    ?? document.body.dataset.interfacingUiProvider
    ?? 'ant_design';
}

function materializeAntDesignIcon(element: HTMLElement, iconName: string): boolean {
  const Icon = antDesignIcons[iconName] ?? UserOutlined;

  element.replaceChildren();
  createRoot(element).render(React.createElement(Icon, {
    className: 'interfacing-provider-native-icon interfacing-provider-native-icon--ant-design'
  }));
  element.dataset.interfacingIconMaterialized = 'ant-design';

  return true;
}

function materializePrimeIcon(element: HTMLElement, iconName: string): boolean {
  const iconClass = primeIcons[iconName] ?? 'pi-user';
  const icon = document.createElement('i');

  icon.className = `pi ${iconClass} interfacing-provider-native-icon interfacing-provider-native-icon--primereact`;
  icon.setAttribute('aria-hidden', 'true');
  element.replaceChildren(icon);
  element.dataset.interfacingIconMaterialized = 'primereact';

  return true;
}

export function materializeLocationIcons(root: ParentNode = document): number {
  const elements = Array.from(root.querySelectorAll<HTMLElement>('.interfacing-location-icon[data-interfacing-location-icon]'));

  return elements.reduce((count, element) => {
    if (element.dataset.interfacingIconMaterialized) {
      return count;
    }

    const iconName = element.dataset.interfacingLocationIcon;

    if (!iconName) {
      return count;
    }

    const provider = resolveStyleProvider(element).replace(/-/g, '_').toLowerCase();
    const materialized = provider.includes('prime')
      ? materializePrimeIcon(element, iconName)
      : materializeAntDesignIcon(element, iconName);

    return count + (materialized ? 1 : 0);
  }, 0);
}
