import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            tailwindcss(),
        ],
        server: {
            host: '0.0.0.0',
            port: 5173,
            strictPort: true,
            cors: true,
            hmr: {
                host: env.VITE_SERVER_HOST || 'localhost',
                clientPort: 5173,
            },
            watch: {
                ignored: ['**/storage/framework/views/**', '**/vendor/**', '**/node_modules/**'],
                usePolling: true,
            },
        },
    };
});
