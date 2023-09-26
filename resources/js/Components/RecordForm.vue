<template>
    <div class="container mx-auto p-4">
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="exercise">
            Exercise
          </label>
          <select v-model="form.exercise_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option v-for="exercise in exercises" :key="exercise.id" :value="exercise.id">
              {{ exercise.name }}
            </option>
          </select>
        </div>
  
        <!-- Add similar select fields for training_session_id, unit_id, etc. -->
  
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="sets">
            Sets
          </label>
          <input v-model="form.sets" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" placeholder="Sets">
        </div>
  
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="reps">
            Reps
          </label>
          <input v-model="form.reps" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" placeholder="Reps">
        </div>
  
        <!-- Add other form fields for remaining attributes -->
  
        <div class="flex items-center justify-between">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Save
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
    import { ref, onMounted } from 'vue';
    import { router } from '@inertiajs/vue3';
    export default {
    setup() {
        const exercises = ref([]);

        onMounted(async () => {
        try {
            const response = await router.get('/api/exercises');
            exercises.value = response.data;
        } catch (error) {
            console.error('An error occurred while fetching exercises:', error);
        }
        });

        return {
        exercises,
        };
    },
    };
  </script>
  