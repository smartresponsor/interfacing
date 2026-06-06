import './canonical-providers';

function boot(): void {
  window.InterfacingProviderRegistry?.mountAll(document);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
