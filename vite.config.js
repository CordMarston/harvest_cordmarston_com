import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5175,
        strictPort: true,
        hmr: {
            protocol: 'wss',
            host: 'harvest.cordmarston.com',
            clientPort: 443,
            path: '/@vite', // important!
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/filament/dashboard/theme.css'],
            refresh: [
                'app/Livewire/**',
            ],
        }),
    ],
});
