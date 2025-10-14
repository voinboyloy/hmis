import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // Import the path module

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Add path resolution alias for the '@' symbol
    resolve: {
        alias: {
            // This aliases the '@' symbol to the 'resources/js' directory
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
