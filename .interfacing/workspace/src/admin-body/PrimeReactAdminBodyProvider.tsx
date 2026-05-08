import type { AdminBodyProvider, AdminBodySchema } from './types';
import { PrimeReactProvider } from 'primereact/api';
import 'primeicons/primeicons.css';

void PrimeReactProvider;

export function createPrimeReactAdminBodyProvider(): AdminBodyProvider {
  return {
    mount(mount: HTMLElement, schema: AdminBodySchema): void {
      const event = new CustomEvent('interfacing:admin-body:primereact-rich-facade-ready', {
        bubbles: true,
        detail: {
          provider: 'primereact',
          role: 'secondary-rich-facade',
          resource: schema.resource || null,
        },
      });
      mount.dispatchEvent(event);
    },
  };
}
