<template>
  <div class="container mx-auto p-4">
        <table v-if="exercises.length > 0" class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 "></th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Exercise</th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Amount</th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Unit</th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Type</th>
              <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 ">Delete</th>
            </tr>
          </thead>
          <Draggable :list="exerciseRows" class="transition-group" tag="transition-group" @start="dragging = true" @end="onEnd" name="fade">
            <template #item="{ element, index }">
              <tr :key="element.id" class="bg-white">
                <!--Draggable icon-->
                <td class="py-2 px-1 border-b border-gray-200 cursor-move">
                  <img src="/svgs/line-three.svg" alt="draggable">
                  <i class="fa fa-bars"></i>
                </td>
                <!--Exercise option-->
                <td class="py-2 px-4 border-b border-gray-200">
                  <select v-model="element.selectedExercise" class="form-select">
                    <option v-for="exercise in exercises" :key="exercise.id" :value="exercise.id">
                      {{ exercise.name }}
                    </option>
                  </select>
                </td>
                <!--Amount input-->
                <td class="py-2 px-4 border-b border-gray-200">
                  <input type="text" id="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" :placeholder="getExerciseUnit(element.selectedExercise)" required>
                </td>
                <!--Exercise Unit-->
                <td class="py-2 px-4 border-b border-gray-200">{{ getExerciseUnit(element.selectedExercise) }}</td>
                <!--Exercise Type-->
                <td class="py-2 px-4 border-b border-gray-200">{{ getExerciseType(element.selectedExercise) }}</td>
                <!--delete button-->
                <td class="py-2 px-4 border-b border-gray-200">
                  <button @click="deleteRow(index)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                </td>
              </tr>
            </template>
          </Draggable>
        </table>

        <!-- Add/Delete and Submit Buttons -->
        <div class="my-4">
          <button @click="addRow" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">Add Row</button>
          <button @click="submitForm" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
        </div>
  </div>
</template>

<script>
import { ref, onMounted, computed,nextTick } from 'vue';
import Draggable from 'vuedraggable';
import axios from 'axios';

export default {
  components: {
    Draggable,
  },
  setup() {
    const exercises = ref([]);
    const exerciseRows = ref([]);
    //State to track whether dragging is happening
    const dragging = ref(false); 

    onMounted(async () => {
      try {
        const response = await axios.get('/api/exercises');
        exercises.value = response.data;

        const savedRows = JSON.parse(localStorage.getItem('exerciseRows'));
        if (savedRows && Array.isArray(savedRows)) {
          exerciseRows.value = savedRows;
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

    const onEnd = (event) => {
      const movedItem = exerciseRows.value.splice(event.oldIndex, 1)[0];
      exerciseRows.value.splice(event.newIndex, 0, movedItem);
      saveToLocalStorage();
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
      // Convert the exerciseRows to the desired format for submission
      const formData = exerciseRows.value.map(row => ({ exercise_id: row.selectedExercise }));
      
      try {
        await axios.post('/api/training-exercises', formData);
        // Handle successful submission
        console.log('Form submitted successfully');
        //to do redirct to other pages
        localStorage.removeItem('exerciseRows');
      } catch (error) {
        console.error('An error occurred while submitting the form:', error);
      }
    };

    return {
      exercises,
      exerciseRows,
      onEnd,
      getExerciseUnit,
      getExerciseType,
      addRow,
      deleteRow,
      submitForm,
    };
  },
};
</script>

<style scoped>
.transition-group > tr {
  transition: all 0.5s ease;
}
.transition-group > tr.move {
  background-color: #fffbf2; /* Highlight color when moving */
  transform: translateY(var(--translateY));
}
.cursor-move {
  cursor: move;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}

</style>