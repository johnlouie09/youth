<template>
    <v-container class="home-main pa-0 ma-0" :theme="$vuetify.theme.name" dark fluid>
        <Carousel />
        <Navigation />
        <Faqs />
    </v-container>
</template>

<script>
import Carousel from "../landingpage/Carousel.vue";
import Navigation from "../landingpage/Navigation.vue";
import Faqs from "../landingpage/faqs.vue";

export default {
    components: {
        Carousel,
        Navigation,
        Faqs
    }
};
</script>

<style scoped>
    .home-main {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 5rem;
    margin: 0;
    }
</style>
