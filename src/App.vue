<script setup>
import Preloader from "./components/Preloader.vue";
import Menu from './components/Menu.vue'
import ThemeSwitcher from './components/ThemeSwitcher.vue';
import Footer from './components/Footer.vue'
</script>

<template>

    <v-app>
        <Menu/> <!-- Place it directly inside v-app -->
        <Preloader />
        <RouterView />
        <Footer/>
    </v-app>
</template>

<style scoped>

</style>
