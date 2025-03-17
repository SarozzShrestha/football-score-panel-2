import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
      laravel({
        input: ['resources/scss/app.scss', 'resources/js/app.js'],
        refresh: true,
      }),
    ],
    css: {
      preprocessorOptions: {
        scss: {
          additionalData: `@import "bootstrap/scss/functions"; @import "bootstrap/scss/variables";`,
        },
      },
    },
  });