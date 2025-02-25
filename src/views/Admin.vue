<script setup>
import Dialogs from '../components/dialogs/Dialogs.vue';
import Sidebar from '../components/adminComponents/Sidebar.vue';
</script>

<template>
    <v-app class="mainApp">
        <div class="adminContainer">
            <Sidebar class="sidebar" />

            <v-main class="adminMain">
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
</style>
