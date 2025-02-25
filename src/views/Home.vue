<script setup>
import Carousel from "../landingpage/Carousel.vue";
import Navigation from "../landingpage/Navigation.vue";
import ThemeSwitcher from "@/components/ThemeSwitcher.vue";
import faqs from '../landingpage/faqs.vue'
</script>

<template>
<v-app>

    <v-app :theme="$vuetify.theme.global.name.value">

     <Carousel/>
     <br>
     <Navigation/>
        <br>
        <faqs/>
 </v-app>

</v-app>
</template>
