import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                // ADMIN 
                'resources/js/Panels/Admin/PageLayout/layout.js',
                'resources/js/Panels/Admin/PageLayout/notifications.js',

                'resources/js/Panels/Admin/Pages/Crew/crew.js',
                'resources/js/Panels/Admin/Pages/Crew/add_crew_modal.js',

                'resources/js/Panels/Admin/Pages/Manager/manager.js',
                'resources/js/Panels/Admin/Pages/Manager/add_manager_modal.js',

                'resources/js/Panels/Admin/Pages/Requests/requests.js',

                'resources/js/Panels/Admin/Pages/Manager_Schedule/responsive_table.js',
                'resources/js/Panels/Admin/Pages/Manager_Schedule/modal.js',
                'resources/js/Panels/Admin/Pages/Manager_Schedule/dates.js',


                // SCHEDULER 
                'resources/js/Panels/Scheduler/PageLayout/notifications.js',

                'resources/js/Panels/Scheduler/Pages/Requests/requests.js',
                'resources/js/Panels/Scheduler/Pages/Crew_Schedule/responsive_table.js',
                'resources/js/Panels/Scheduler/Pages/Crew_Schedule/modal.js',
                'resources/js/Panels/Scheduler/Pages/Crew_Schedule/dates.js',

                'resources/js/Panels/Scheduler/Pages/Crew_Availability/crew_availability.js',
                'resources/js/Panels/Scheduler/Pages/Crew_Availability/add_availability_modal.js',


                // AGENCY 
                'resources/js/Panels/Agency/PageLayout/notifications.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],

    server: {
        host: '0.0.0.0',
        port: 5173,

        watch: {
            ignored: ['**/storage/framework/views/**'],
        },

        hmr: {
            host: '192.168.1.14',
            protocol: 'ws',
        },
    },
});
