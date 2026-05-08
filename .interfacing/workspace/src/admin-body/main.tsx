import { createAntDesignProAdminBodyProvider } from './AntDesignProAdminBodyProvider';
import { createPrimeReactAdminBodyProvider } from './PrimeReactAdminBodyProvider';

declare global {
  interface Window {
    InterfacingAntDesignProAdminBodyProvider?: ReturnType<typeof createAntDesignProAdminBodyProvider>;
    InterfacingPrimeReactAdminBodyProvider?: ReturnType<typeof createPrimeReactAdminBodyProvider>;
  }
}

window.InterfacingAntDesignProAdminBodyProvider = createAntDesignProAdminBodyProvider();
window.InterfacingPrimeReactAdminBodyProvider = createPrimeReactAdminBodyProvider();

window.dispatchEvent(new CustomEvent('interfacing:admin-body:canonical-providers-ready', {
  detail: {
    primary: 'antd-pro',
    secondary: 'primereact',
    bundle: 'interfacing/admin-body/canonical-providers.js',
  },
}));
