<script>
import Footer from "./components/landingPageComponents/Footer.vue";
import NavigationBar from "./components/landingPageComponents/NavigationBar.vue";
import ThemeSwitcher from "./components/ThemeSwitcher.vue";
export default {
  components: {
    NavigationBar,
    Footer,
    ThemeSwitcher
  }
};
</script>

<template>
  <v-app>
    <NavigationBar></NavigationBar>
    <v-main class="relative">
      <v-container class="pa-0" fluid >
        <RouterView />
      </v-container>
    </v-main>
  </v-app>
</template>

<style scoped>


</style>
  