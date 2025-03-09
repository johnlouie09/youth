<template>
    <v-app>
        <Menu /> <!-- Place it directly inside v-app -->
        <Preloader />
        <RouterView />
        <Footer />
    </v-app>
</template>

<script>
import Preloader from "./components/Preloader.vue";
import Menu from "./components/Menu.vue";
import Footer from "./components/Footer.vue";

export default {
    components: {
        Menu,
        Preloader,
        Menu,
        Footer
    }
};
</script>

<style scoped>
</style>
