import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },

        server: {
        host: '0.0.0.0',
        port: 5173, // or your default Vite port
        hmr: {
            host: '192.168.1.14',  
            protocol: 'ws',
        },
    },
});
