<script setup>
import Carousel from "../landingpage/Carousel.vue";
import Navigation from "../landingpage/Navigation.vue";
import ThemeSwitcher from "@/components/ThemeSwitcher.vue";
</script>

<template>
    <v-app>
        <v-app :theme="$vuetify.theme.global.name.value">
            <v-btn>
            <ThemeSwitcher />
            </v-btn>
            <Carousel/>
            <br>
            <Navigation/>
        </v-app>
    </v-app>
</template>

<style scoped>
    * {
        font-family: 'Inter', sans-serif;
    }
</style>
