<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <h1 class="mt-1 text-2xl font-medium text-gray-900">
                Record your workouts here!
            </h1>
            <br><hr><br>
            <div class="grid grid-cols-4 gap-4">
                <!--To be change to displaying user name and custom time selection with now as defeault-->
                <label for="training_session" class="block mb-2 text-xl font-medium text-gray-900">Session:</label>
                <div>
                <VueDatepicker v-model="training_session" />
                </div>
                <label for="athlete" class="block mb-2 text-xl font-medium text-gray-900">Athlete:</label>
                <p>{{athlete}}</p>
            </div>
            <div>
                <label for="notes" class="block mb-2 text-xl font-medium text-gray-900">Notes:</label>
                <textarea v-model="notes" id="notes" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
            </div>
        </div>
        <!--bg-gray-200 bg-opacity-25-->
        <RecordForm v-if="training_session && athlete" :training_session="training_session" :athlete="athlete" :notes="notes"/>
    </div>
</template>

<script setup>
import { ref, onMounted} from 'vue';
import axios from 'axios';
import RecordForm from '@/Components/RecordForm.vue';
import VueDatepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

// Define refs
const training_session = ref(new Date());
const athlete = ref('');
const notes = ref('');

// Fetch the user ID and date-time when the component is mounted
const fetchData = async () => {
    try {
        const response = await axios.get('/api/athlete');
        athlete.value = response.data.id;
    } catch (error) {
        console.error('An error occurred while fetching athlete ID and date-time:', error);
    }
};

// Call fetchData on mounted
onMounted(() => {
    fetchData();
});

</script>

