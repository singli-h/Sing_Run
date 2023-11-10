<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DataPage from '@/Components/DataPage.vue';
</script>

<template>
    <AppLayout title="Data">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <DataPage />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
