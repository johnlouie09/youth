<script setup>
import { ref, watch } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const tab = ref(0);

const views = ref({
  daily: 349,
  monthly: 1520,
  yearly: 18450
});

const createChart = (canvasId, type, data, options) => {
  setTimeout(() => {
    const ctx = document.getElementById(canvasId)?.getContext('2d');
    if (ctx) {
      new Chart(ctx, { type, data, options });
    }
  }, 100);
};

watch(tab, (newTab) => {
  if (newTab === 0) {
    createChart('dailyChart', 'line', {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [{
        label: 'Daily Activity',
        data: [12, 19, 3, 5, 2, 3, 9],
        borderColor: 'rgba(55, 114, 255, 1)',
        backgroundColor: 'rgba(55, 114, 255, 0.2)',
        fill: true
      }]
    }, {});
  } else if (newTab === 1) {
    createChart('monthlyChart', 'bar', {
      labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
      datasets: [{
        label: 'Monthly Activity',
        data: [30, 50, 40, 60],
        backgroundColor: 'rgba(255, 99, 132, 0.5)'
      }]
    }, {});
  } else if (newTab === 2) {
    createChart('yearlyChart', 'bar', {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Yearly Activity',
        data: [300, 450, 500, 600, 750, 800, 700, 650, 600, 550, 500, 450],
        backgroundColor: 'rgba(75, 192, 192, 0.5)'
      }]
    }, {});
  }
}, { immediate: true });
</script>

<template>
  <v-container class="analytics-box">
    <v-tabs v-model="tab" color="primary" grow>
      <v-tab>DAILY</v-tab>
      <v-tab>MONTHLY</v-tab>
      <v-tab>YEARLY</v-tab>
    </v-tabs>

    <v-window v-model="tab" class="analytics-content">
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <canvas id="dailyChart"></canvas>
          </v-card-text>
          <v-card-text class="views">
            <h1>{{ views.daily }}</h1>
            <p>VIEWS</p>
          </v-card-text>
        </v-card>
      </v-window-item>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <canvas id="monthlyChart"></canvas>
          </v-card-text>
          <v-card-text class="views">
            <h1>{{ views.monthly }}</h1>
            <p>VIEWS</p>
          </v-card-text>
        </v-card>
      </v-window-item>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <canvas id="yearlyChart"></canvas>
          </v-card-text>
          <v-card-text class="views">
            <h1>{{ views.yearly }}</h1>
            <p>VIEWS</p>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
  </v-container>
</template>

<style scoped>
.analytics-box {
  height: 75%;
  width: 100%;
  border-radius: 0.5rem;
  box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);
  padding: 1.5rem 3rem;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.analytics-content {
  width: 100%;
  height: 100%;
  padding: 1rem;
}
.views {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 1rem;
  border-radius: 0.5rem;
  text-align: center;
}
.views h1 {
  font-size: 3rem;
  font-weight: bold;
}
.views p {
  font-size: 1.2rem;
}
</style>
