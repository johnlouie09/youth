<script setup>
import Dialogs from '../components/dialogs/Dialogs.vue';
import Sidebar from '../components/adminComponents/Sidebar.vue';

</script>

<template>
    <Dialogs/>
    <main>
        <Sidebar></Sidebar>

        <RouterView class="adminMain">
        </RouterView>

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
        background: linear-gradient(
        to bottom,
        #101010 0%,  /* Dark Gray */
        #101010 47%, /* Same Dark Gray */
        #272727 100% /* Slightly lighter Gray */
        );
    }
</style>