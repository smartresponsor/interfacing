import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'node:path';

const workspaceRoot = __dirname;
const repositoryRoot = resolve(workspaceRoot, '../..');
const publicProviderOutDir = resolve(repositoryRoot, 'public/provider');

export default defineConfig({
  root: workspaceRoot,
  publicDir: false,
  plugins: [react()],
  build: {
    outDir: publicProviderOutDir,
    emptyOutDir: false,
    sourcemap: true,
    target: 'es2022',
    cssCodeSplit: true,
    manifest: 'manifest.json',
    rollupOptions: {
      input: {
        'provider-registry': resolve(workspaceRoot, 'src/provider/provider-registry.ts'),
        'canonical-providers': resolve(workspaceRoot, 'src/provider/canonical-providers.ts'),
        runtime: resolve(workspaceRoot, 'src/provider/runtime.ts'),
        'providers/antd-pro': resolve(workspaceRoot, 'src/provider/providers/antd-pro.tsx'),
        'providers/primereact': resolve(workspaceRoot, 'src/provider/providers/primereact.tsx'),
        'canonical-providers.interfacing-interface-ui': resolve(workspaceRoot, 'src/provider/styles/canonical-providers.interfacing-interface-ui.css')
      },
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: 'chunks/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name === 'canonical-providers.interfacing-interface-ui.css') {
            return 'canonical-providers.interfacing-interface-ui.css';
          }

          if (assetInfo.name?.endsWith('.css')) {
            return 'assets/[name][extname]';
          }

          return 'assets/[name]-[hash][extname]';
        }
      }
    }
  }
});
