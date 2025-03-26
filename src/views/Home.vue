<script>
import { useTheme } from 'vuetify';
import Preloader from "@/components/Preloader.vue";
import Hero from "@/components/landingPageComponents/Hero.vue";
import Faqs from "@/components/landingPageComponents/faqs.vue";
import BarangaysNavigation from "@/components/landingPageComponents/BarangaysNavigation.vue";

export default {
  name: "Home",
  components: {
    Preloader,
    Hero,
    Faqs,
    BarangaysNavigation
  },
  computed: {
    // Call useTheme() directly so that it's available as a computed property.
    theme() {
      return useTheme();
    },
    themeName() {
      return this.theme.global.name.value;
    },
    isDark() {
      // Use a safe check to avoid errors if any level is undefined.
      return this.theme && this.theme.current && this.theme.current.value
        ? this.theme.current.value.dark
        : false;
    }
  }
};
</script>

<template>
  <Preloader />
  <v-container
    fluid
    class="home-main bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200"
    :class="{ 'dark-gradient': isDark }"
  >
    <Hero />
    <BarangaysNavigation/>
    <faqs />
  </v-container>
</template>

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
  animation: moveGradient 10s linear infinite;
}

.dark-gradient {
  background-image: linear-gradient(45deg, #363636, #0e0e0e, #363636, #0e0e0e);
  background-size: 200% 200%;
  animation: moveGradient 15s linear infinite;
}

@keyframes moveGradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
</style>
