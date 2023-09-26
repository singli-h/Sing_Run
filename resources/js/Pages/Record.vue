<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import RecordPage from '@/Components/RecordPage.vue';
</script>

<template>
    <AppLayout title="Record">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <RecordPage />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
