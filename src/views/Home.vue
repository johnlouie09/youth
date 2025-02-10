<script setup>
// import YouthIcon from "@/components/icons/YouthIcon.vue";
import Carousel from '@/components/Carousel.vue';
</script>

<template>
    <main>
        <div class="carousel">
            <Carousel></Carousel>
        </div>
        <div class="barangaySelector"></div>
        <div class="faq"></div>

    </main>
</template>

<style scoped>
main {
    height: 100vh;
    background-color: #1E1E1E;
}

.carousel {
    width: 100%;
    height: 75vh;
    display: flex;
    justify-content: center;
    align-items: center;
}




</style>
