import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'node:path';

export default defineConfig({
  plugins: [react()],
  publicDir: false,
  build: {
    outDir: resolve(__dirname, '../../public/interfacing/admin-body'),
    emptyOutDir: true,
    sourcemap: true,
    lib: {
      entry: resolve(__dirname, 'src/admin-body/main.tsx'),
      name: 'InterfacingAdminBodyCanonicalProviders',
      formats: ['es'],
      fileName: () => 'canonical-providers.js'
    },
    rollupOptions: {
      output: {
        assetFileNames: 'canonical-providers.[name][extname]'
      }
    }
  }
});
