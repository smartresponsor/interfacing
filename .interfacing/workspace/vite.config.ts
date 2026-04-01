import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'node:path';

export default defineConfig({
  root: resolve(__dirname),
  plugins: [react()],
  resolve: {
    alias: {
      '@zones': resolve(__dirname, 'src/zones'),
      '@wrappers': resolve(__dirname, 'src/wrappers'),
      '@contracts': resolve(__dirname, 'src/contracts')
    }
  }
});
