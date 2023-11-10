<template>
    <div>
      <h1>Data Visualization</h1>
      
      <div>
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" v-model="startDate" required>
      </div>
  
      <div>
        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" v-model="endDate" required>
      </div>
  
      <div>
        <label for="exercise">Exercise:</label>
        <select id="exercise" v-model="selectedExercise" required>
          <option disabled value="">Please select one</option>
          <option v-for="exercise in exercises" :key="exercise.id" :value="exercise.id">
            {{ exercise.name }}
          </option>
        </select>
      </div>
      
      <div>
        <label><input type="checkbox" v-model="variablesToShow.output" /> Output</label>
        <label><input type="checkbox" v-model="variablesToShow.totalReps" /> Total Reps</label>
        <label><input type="checkbox" v-model="variablesToShow.totalEffort" /> Total Effort</label>
        </div>
        
        <ProgressionChart
            :start-date="startDate"
            :end-date="endDate"
            :exercise-id="selectedExercise"
            :variables-to-show="variablesToShow"
        />
    </div>
  </template>
  
  <script setup>
  import ProgressionChart from '@/Components/ProgressionChart.vue'; // Replace with your actual path
  import axios from 'axios';
  import { ref, onMounted } from 'vue';
  
  const startDate = ref('');
  const endDate = ref('');
  const selectedExercise = ref('');
  const exercises = ref([]);
  
  const fetchExercises = async () => {
    try {
      const response = await axios.get('/api/exercises');
      exercises.value = response.data;
    } catch (error) {
      console.error("Error fetching exercises:", error);
    }
  };

  const variablesToShow = ref({
    output: true, // Default checked
    totalReps: false,
    totalEffort: false
  }); 
    
  onMounted(fetchExercises);
  </script>
  