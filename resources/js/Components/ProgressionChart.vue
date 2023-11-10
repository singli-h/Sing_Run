<template>
    <div>
      <canvas ref="progressChartCanvas"></canvas>
    </div>
  </template>
  
  <script setup>
  import { ref, watch, onMounted } from 'vue';
  import { Chart, registerables } from 'chart.js';
  import axios from 'axios';
  
  Chart.register(...registerables);
  
  const props = defineProps({
    startDate: String,
    endDate: String,
    exerciseId: Number,
    variablesToShow: Object
  });
  
  const progressChartCanvas = ref(null);
  let progressChart = null;
  let fetchedData = null;
  
  const fetchDataAndRenderChart = async () => {
    if (!props.startDate || !props.endDate || !props.exerciseId) {
      //console.log('All parameters (start date, end date, exercise) must be selected.');
      return; // Exit the function if not all conditions are met
    }
  
    const apiUrl = `/api/training-exercise/progress?start_date=${props.startDate}&end_date=${props.endDate}&exercise_id=${props.exerciseId}`;
    const response = await axios.get(apiUrl);
    fetchedData = response.data;
    updateChartDatasets(); // Call updateChartDatasets to handle chart rendering
  };
  
  watch([() => props.startDate, () => props.endDate, () => props.exerciseId, () => props.variablesToShow], fetchDataAndRenderChart, { deep: true });
  
  onMounted(fetchDataAndRenderChart);
  
  const updateChartDatasets = () => {
    if (!fetchedData || !progressChartCanvas.value) return;
  
    const labels = Object.keys(fetchedData);
    const datasets = [];
  
    if (props.variablesToShow.output) {
      datasets.push(createDataset('Output', fetchedData, 'output'));
    }
    if (props.variablesToShow.totalReps) {
      datasets.push(createDataset('Total Reps', fetchedData, 'totalReps'));
    }
    if (props.variablesToShow.totalEffort) {
      datasets.push(createDataset('Total Effort', fetchedData, 'totalEffort'));
    }
  
    if (progressChart) {
      progressChart.destroy();
    }
  
    progressChart = new Chart(progressChartCanvas.value.getContext('2d'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: datasets
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  };
  
  const createDataset = (label, data, variableKey) => {
    const dataset = {
      label: label,
      data: [],
      fill: false,
      borderColor: generateRandomColor(),
      tension: 0.1
    };
  
    for (const [week, records] of Object.entries(data)) {
      let value = 0;
      if (variableKey === 'output') {
        value = records.reduce((sum, record) => sum + record.output, 0);
      } else if (variableKey === 'totalReps') {
        value = records.reduce((sum, record) => sum + (record.sets * record.reps), 0);
      } else if (variableKey === 'totalEffort') {
        value = records.reduce((sum, record) => sum + (record.sets * record.reps * record.output), 0);
      }
      dataset.data.push(value);
    }
  
    return dataset;
  };
  
  const generateRandomColor = () => {
    const r = Math.floor(Math.random() * 255);
    const g = Math.floor(Math.random() * 255);
    const b = Math.floor(Math.random() * 255);
    return `rgb(${r}, ${g}, ${b})`;
  };
  </script>
  