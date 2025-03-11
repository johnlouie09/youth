<template>
    <v-container
      fluid
      class="home-main"
      :class="{ 'dark-gradient': theme.global.name.value === 'dark' }"
    >
      <Carousel />
      <BarangaysNavigation />
      <Faqs />
    </v-container>
  </template>
  
  <script setup>
  import Carousel from "../landingpage/Hero.vue";
  import Faqs from "@/landingpage/Faqs.vue";
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
    gap: 5rem;
    padding: 0;
    padding-top: 2rem;
    padding-bottom: 4rem;
    margin: 0;
    /* No gradient by default */
    background-position: center;
    background-attachment: fixed;
    background: linear-gradient(45deg, rgba(253,202,64,0.76234243697479) 14%, rgba(255,255,255,1) 32%, rgba(55,114,255,0.5970763305322129) 53%, rgba(255,255,255,1) 72%, rgba(223,41,53,0.5830707282913166) 90%);
  }
  
  /* Only add the gradient if dark mode is active */
  .dark-gradient {
    background-image: linear-gradient(45deg, #0e0e0e, #363636);
  }
  </style>
  