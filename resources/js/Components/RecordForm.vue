<template>
  <div class="container mx-auto p-4">
        <table v-if="exercises.length > 0" class="min-w-full bg-white border">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Exercise</th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Amount</th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Unit</th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Type</th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Delete</th>
            </tr>
          </thead>
          <transition-group name="fade" tag="tbody">
            <tr v-for="(element, index) in exerciseRows" :key="element.id" class="bg-white border">
              <!--Exercise option-->
              <td class="py-2 px-4 border-b border-gray-200">
                <select v-model="element.selectedExercise" class="form-select">
                  <option v-for="exercise in exercises" :key="exercise.id" :value="exercise.id">
                    {{ exercise ? exercise.name : '' }}
                  </option>
                </select>
              </td>
              <!--Amount input-->
              <td class="py-2 px-4 border-b border-gray-200">
                <input type="number" id="amount" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" :placeholder="getExerciseUnit(element.selectedExercise)" required>
              </td>
              <!--Exercise Unit-->
              <td class="py-2 px-4 border-b border-gray-200">{{ getExerciseUnit(element.selectedExercise) }}</td>
              <!--Exercise Type-->
              <td class="py-2 px-4 border-b border-gray-200">{{ getExerciseType(element.selectedExercise) }}</td>
              <!--delete button-->
              <td class="py-2 px-4 border-b border-gray-200">
                <button @click="deleteRow(index)" class="bg-red-400 hover:bg-red-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
              </td>
            </tr>
          </transition-group>
        </table>

        <!-- Add/Delete and Submit Buttons -->
        <div class="my-4">
          <button @click="addRow" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">Add Row</button>
          <button @click="submitForm" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
        </div>
  </div>
</template>

<script>
export default {
  props: {
    session: String,
    athlete: String,
    notes: String,
  },
};
</script>

<script setup>
  import { ref, onMounted, defineProps } from 'vue';
  import axios from 'axios';

  const { session, athlete, notes } = defineProps();
  const exercises = ref([]);
  const exerciseRows = ref([]);
  const isLoading = ref(false);
  const message = ref('');

  onMounted(async () => {
    try {
      const response = await axios.get('/api/exercises');
      exercises.value = response.data;

      const savedRows = JSON.parse(localStorage.getItem('exerciseRows'));
      if (savedRows && Array.isArray(savedRows)) {
        exerciseRows.value = savedRows.filter(row => row !== null);
      } else {
        exerciseRows.value = exercises.value.map((_, index) => ({ selectedExercise: exercises.value[index]?.id }));
      }
    } catch (error) {
      console.error('An error occurred while fetching exercises:', error);
    }
  });

  const getExerciseUnit = (exerciseId) => {
    const exercise = exercises.value.find(ex => ex.id === exerciseId);
    return exercise ? exercise.unit.unit : '';
  };

  const getExerciseType = (exerciseId) => {
    const exercise = exercises.value.find(ex => ex.id === exerciseId);
    return exercise ? exercise.exercise_type.type : '';
  };

  const saveToLocalStorage = () => {
  localStorage.setItem('exerciseRows', JSON.stringify(exerciseRows.value));
  };

  const addRow = () => {
    exerciseRows.value.push({
      id: Date.now(),
      selectedExercise: exercises.value[0]?.id,
    });
    saveToLocalStorage();
  };

  const deleteRow = (index) => {
    exerciseRows.value.splice(index, 1);
    saveToLocalStorage();
  };

  const submitForm = async () => {
    // Validate the required data
    console.log(props);
    console.log(session, athlete, notes);
    if (session || athlete || !exerciseRows.value.length) {
        message.value = 'Please ensure all fields are filled out.';
        return;
    }

    // Prepare form data
    const formData = {
        session,
        athlete,
        notes,
        exercises: exerciseRows.value.map(row => ({ exercise_id: row.selectedExercise })),
    };

    isLoading.value = true; // Set loading state

    try {
        await axios.post('/api/training-sessions', formData);
        
        // Feedback to user
        message.value = 'Form submitted successfully!';
        
        // Clean-up after successful submission
        localStorage.removeItem('exerciseRows');
        exerciseRows.value = [];
    } catch (error) {
        console.error('An error occurred while submitting the form:', error);
        message.value = 'An error occurred. Please try again later.';
    } finally {
        isLoading.value = false; // Reset loading state
    }
  };
</script>

<style scoped>
.transition-group > tr {
  transition: all 0.2s ease;
}

.transition-group > tr.move {
  background-color: #fffbf2; /* Highlight color when moving */
  transform: translateY(var(--translateY));
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}
</style>
