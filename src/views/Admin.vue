<script setup>
import { computed } from 'vue';
import { useTheme } from 'vuetify';
import Dialogs from '../components/dialogs/Dialogs.vue';
import Sidebar from '../components/adminComponents/Sidebar.vue';

const theme = useTheme();

// Computed property to check if the current theme is dark
const isDark = computed(() => theme.current.value.dark);
</script>

<template>
  <v-app class="mainApp">
    <div class="adminContainer">
      <Sidebar class="sidebar" />
      <v-main :class="['adminMain', { 'dark-gradient': isDark }]">
        <RouterView />
      </v-main>
    </div>
  </v-app>
</template>

<style scoped>
/* Scrollbar Styling */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #1e1e1e;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #555;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #888;
}

/* Layout Fix */
.mainApp {
  font-family: 'Kumbh Sans', sans-serif;
  height: 100vh;
  display: flex;
}

.adminContainer {
  display: flex;
  width: 100%;
  height: 100vh;
}

.sidebar {
  width: 15%;
  background: #1e1e1e; /* Adjust as needed */
}

.adminMain {
  width: 85%;
  overflow-y: auto;
  scrollbar-width: thin;
  display: flex;
  flex-direction: column;
}

/* Dark mode gradient */
.dark-gradient {
  background-image: linear-gradient(
    45deg,
    #363636,
    #0e0e0e,
    #363636,
    #0e0e0e
  );
}
</style>
