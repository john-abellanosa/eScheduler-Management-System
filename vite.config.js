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
                'resources/js/Panels/Admin/Auth/login.js',

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

                'resources/js/Panels/Admin/Pages/Units&Position_Setup/units&position_setup.js',
                'resources/js/Panels/Admin/Pages/Schedule_Overview/responsive_table.js',
                'resources/js/Panels/Admin/Pages/Schedule_Overview/dates.js',

                'resources/js/Panels/Admin/Pages/Dashboard/announcement.js',

                'resources/js/Panels/Admin/Pages/Shift_Records/manager.js',
                'resources/js/Panels/Admin/Pages/Shift_Records/crew.js',


                // SCHEDULER 
                'resources/js/Panels/Scheduler/Auth/login.js',
                'resources/js/Panels/Scheduler/Auth/email_verification.js',
                'resources/js/Panels/Scheduler/Auth/forgot_password.js',
                'resources/js/Panels/Scheduler/Auth/change_password.js',

                'resources/js/Panels/Scheduler/PageLayout/notifications.js',
                'resources/js/Panels/Scheduler/PageLayout/dropdown.js',

                'resources/js/Panels/Scheduler/Pages/Requests/requests.js',
                'resources/js/Panels/Scheduler/Pages/Crew_Schedule/responsive_table.js',
                'resources/js/Panels/Scheduler/Pages/Crew_Schedule/modal.js',
                'resources/js/Panels/Scheduler/Pages/Crew_Schedule/dates.js',

                'resources/js/Panels/Scheduler/Pages/Crew_Availability/crew_availability.js',
                'resources/js/Panels/Scheduler/Pages/Crew_Availability/add_availability_modal.js',

                'resources/js/Panels/Scheduler/Pages/Settings/settings.js',

                'resources/js/Panels/Scheduler/Pages/Shift_Records/shift_records.js',

 
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],

    // server: {
    //     host: '0.0.0.0',
    //     port: 5173,

    //     watch: {
    //         ignored: ['**/storage/framework/views/**'],
    //     },

    //     hmr: {
    //         host: '10.226.161.49',
    //         protocol: 'ws',
    //     },
    // },
});
