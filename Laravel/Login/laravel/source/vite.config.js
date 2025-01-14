import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Lắng nghe từ tất cả địa chỉ IP
        port: 5173, // Port của Vite
        hmr: {
            host: 'localhost', // Đổi thành IP hoặc tên miền của host Docker
        },
    },
});
