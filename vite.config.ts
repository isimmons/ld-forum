/// <reference types="vitest" />

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  resolve: {
    alias: {
      'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
    },
  },
  plugins: [
    laravel({
      input: ['resources/js/app.ts'],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  test: {
    include: ['resources/js/tests/{Pages,Components,Layouts}/*.{ts,js}'],
    environment: 'jsdom',
    setupFiles: ['resources/js/tests/setup.ts'],
    globals: true,
    reporters: ['verbose'],
  },
});
