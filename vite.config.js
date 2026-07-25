import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                // USER
                'resources/js/modules/user/userMap.js',

                // ADMIN
                'resources/js/modules/admin/adminDashboard.js',
                'resources/js/modules/admin/adminCustomer.js',
                'resources/js/modules/admin/adminPipe.js',

                // SUPER ADMIN
                'resources/js/modules/super-admin/superAdminUsers.js',
            ],
            refresh: true,
        }),
    ],
});