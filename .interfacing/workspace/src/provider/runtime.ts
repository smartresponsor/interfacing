import './canonical-providers';
import { materializeLocationIcons } from './component/location-icons';

function boot(): void {
  materializeLocationIcons(document);
  window.InterfacingProviderRegistry?.mountAll(document);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
