<script>
import Footer from "./components/landingPageComponents/Footer.vue";
import NavigationBar from "./components/landingPageComponents/NavigationBar.vue";
export default {
  components: {
    NavigationBar,
    Footer
  }
};
</script>

<template>
  <v-app>
    <NavigationBar></NavigationBar>
    <v-main>
      <v-container class="pa-0" fluid >
        <RouterView />
      </v-container>
    </v-main>
    <Footer/>
  </v-app>
</template>

<style scoped>

</style>
  