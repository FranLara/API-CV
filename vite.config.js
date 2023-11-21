import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/api.css', 'resources/js/api.js'],
            refresh: true,
        }),
    ],
});
