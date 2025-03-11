<script>
import Preloader from "./components/Preloader.vue";
import Footer from "./components/landingPage/Footer.vue";
import NavigationBar from "./components/landingPage/NavigationBar.vue";
export default {
  components: {
    NavigationBar,
    Preloader,
    Footer
  }
};
</script>

<template>
  <v-app>
    <NavigationBar></NavigationBar>
    <v-main>
      <v-container class="pa-0" fluid >
        <Preloader />
        <RouterView />
      </v-container>
    </v-main>
    <Footer/>
  </v-app>
</template>

<style scoped>
</style>
  