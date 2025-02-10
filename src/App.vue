<script setup>
import Preloader from "./components/Preloader.vue";
import NavigationBar from "./components/NavigationBar.vue";
</script>

<template>
    <Preloader />
    <NavigationBar></NavigationBar>
    <RouterView/>
</template>

<style scoped>

</style>
