<script>
import { useTheme } from 'vuetify';
import Preloader from "@/components/Preloader.vue";
import Hero from "@/components/landingPageComponents/Hero.vue";
import Faqs from "@/components/landingPageComponents/faqs.vue";
import BarangaysNavigation from "@/components/landingPageComponents/BarangaysNavigation.vue";
import SocialLinks from '@/components/landingPageComponents/SocialLinks.vue';
import ThemeSwitcher from '@/components/ThemeSwitcher.vue';

export default {
  name: "Home",
  data() {
    return {}
  },
  components: {
    Preloader,
    Hero,
    Faqs,
    BarangaysNavigation,
    SocialLinks,
    ThemeSwitcher
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
    class="home-main"
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
  gap: 5rem;
  padding: 0;
  padding-top: 2rem;
  padding-bottom: 10rem;
  margin: 0;
  background-position: center;
  background-attachment: fixed;
  background-size: 150% 150%;
  animation: moveGradient 20s linear infinite;
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

.theme {
  position: fixed;
  bottom: 0;
  right: 0;
  margin: 3rem;
  z-index: 2;
}
</style>
