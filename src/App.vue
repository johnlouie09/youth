<script setup>
import Preloader from "./components/Preloader.vue";
import Menu from './components/Menu.vue'
import ThemeSwitcher from './components/ThemeSwitcher.vue';

</script>

<template>

    <v-app>
        <Menu/> <!-- Place it directly inside v-app -->
        <Preloader />
        <RouterView />
    </v-app>
</template>

<style scoped>

</style>
