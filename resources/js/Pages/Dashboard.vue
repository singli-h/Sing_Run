<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import MainPage from '@/Components/MainPage.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <MainPage />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
