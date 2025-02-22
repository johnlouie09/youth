<script setup>
import Sidebar from '../components/adminComponents/Sidebar.vue';

</script>

<template>
    <main>
        <Sidebar></Sidebar>

        <div class="adminMain">

        </div>
        <!-- <RouterView class="adminMain">

        </RouterView> -->

    </main>

</template>

<style scoped>
     main {
        font-family: 'Kumbh Sans', sans-serif;
        display: grid;
        grid-template-columns: 15% 85%;
        height: 100vh;
        width: 100%;

        color: #F1F1F1;
    }

    .adminMain {
        background-color: #1C1C1C;
    }
</style>