<script setup>
import { onMounted, ref, computed } from "vue";
import Swiper from "swiper";
import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/autoplay";
import { EffectCoverflow, Autoplay } from "swiper/modules";

// Reference to the Swiper container
const swiperContainer = ref(null);

// Dynamically generate movie items
const movies = computed(() =>
    Array.from({ length: 15 }, (_, i) => ({
        id: i + 1,
        src: `/${i + 1}.jpg`,
        title: `Movie ${i + 1}`,
    }))
);

onMounted(() => {
    new Swiper(swiperContainer.value, {
        modules: [EffectCoverflow, Autoplay],
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 15,
            stretch: 0,
            depth: 300,
            modifier: 1,
            slideShadows: false,
        },
        loop: true,
        autoplay: {
            delay: 5000,
        },
    });
});
</script>

<template>
    <div class="carousel-container">
        <div ref="swiperContainer" class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="n in 7" :key="n">
                    <img :src="`/${n}.jpg`" :alt="`Movie ${n}`" />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.carousel-container {
    height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.swiper {
    width: 80%;
    height: 100%;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: 250px;
    text-align: center;
    position: relative;
}

.swiper-slide img {
    display: block;
    width: 100%;
}

</style>

