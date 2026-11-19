import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/bootstrap.min.js',
                'resources/js/react-app.jsx',
                'resources/css/react-custom.css',
            ],
            refresh: true,
        }),
        react(),
    ],
});