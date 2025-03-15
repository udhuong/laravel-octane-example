import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        cors: true, // Bật CORS
        // origin: 'http://localhost:5173', // Chỉ định origin
        headers: { // Cần cấu hình như này để laravel có thể lấy file css js từ vite
            'Access-Control-Allow-Origin': '*', // Cho phép tất cả truy cập
            'Access-Control-Allow-Methods': 'GET,POST,PUT,DELETE,OPTIONS',
            'Access-Control-Allow-Headers': 'Content-Type, Authorization',
        },
        hmr: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
});
