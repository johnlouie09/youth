<template>

    <v-container
      fluid
      class="home-main bg-gradient-to-r from-slate-50 to-slate-200"
      :class="{ 'dark-gradient': theme.global.name.value === 'dark' }"
    >
      <Preloader />
      <Hero/>
      <BarangaysNavigation />
      <Faqs />
    </v-container>
  </template>

  <script setup>
  import Preloader from "@/components/Preloader.vue";
  import Hero from "../landingpage/Hero.vue";
  import Faqs from "@/landingpage/faqs.vue";
  import BarangaysNavigation from "../landingpage/BarangaysNavigation.vue";
  import { useTheme } from 'vuetify';
  
  const theme = useTheme();
  </script>

  <style scoped>
  .home-main {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 7rem;
    padding: 0;
    padding-top: 2rem;
    padding-bottom: 4rem;
    margin: 0;
    background-position: center;
    background-attachment: fixed;
    /* background-image: linear-gradient(45deg, rgb(255, 255, 255), #fdcb4081, rgb(255, 255, 255), #3773ff7e, rgb(255, 255, 255), #df293598); */
  }
  
  /* Only add the gradient if dark mode is active */
  .dark-gradient {
    background-image: linear-gradient(45deg, #363636, #0e0e0e, #363636, #0e0e0e);
  }
  </style>
