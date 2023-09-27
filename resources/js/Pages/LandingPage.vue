<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const route = (name, params) => window.route(name, params);

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>
<template>
    <Head title="SprintSage" />
    <div class="relative min-h-screen bg-dots-darker selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-lg font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>
            
            <template v-else>
                <Link :href="route('login')" class="text-lg font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="text-lg ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <ApplicationLogo class="block h-12 w-auto" />
            </div>
            <div class="container mx-auto flex flex-col md:flex-row items-center justify-between h-screen pt-3">
                <div class="md:w-1/2 text-white">
                    <h1 class="text-5xl font-bold mb-4">Welcome to 
                        <br>
                        <span class="text-yellow-500 text-7xl">Sprint Sage</span>
                    </h1>
                    <p class="mb-4 text-xl">
                        We Help You Harness Your Speed -> Train Smarter Not Harder!
                    </p>
                    <div class="mb-4">
                        <Link :href="route('dashboard')" class="text-3xl mr-4 bg-blue-500 text-white p-2 rounded hover:text-yellow-500 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Start Now</Link>
                        <a href="https://external-link.com" target="_blank" class="text-3xl bg-green-500 text-white p-2 rounded hover:text-yellow-500 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Learn More</a>
                    </div>
                </div>
                <div class="md:w-1/2 flex items-center justify-center">
                    <img src="/images/landing-main.jpeg" alt="Fitness Image" class="w-full h-auto md:w-5/6 rounded-md shadow-lg object-cover">
                </div>
            </div>
        </div>
    </div>
</template>


<style>
.bg-dots-darker {
    background-color: #0f081c;
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.3)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.3)'/%3E%3C/svg%3E");
    }
}
</style>
