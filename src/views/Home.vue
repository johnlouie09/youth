<script setup>
import Carousel from "../landingpage/Carousel.vue";
import Navigation from "../landingpage/Navigation.vue";
import Faqs from '../landingpage/faqs.vue';
</script>

<template>
    <v-app :theme="$vuetify.theme.name">
        <Carousel/>
        <br>
        <Navigation/>
        <br>
        <Faqs/>
    </v-app>
</template>
