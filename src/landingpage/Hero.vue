<template>
    <div class="hero-container">
        <div class="content">
            <div><img src="/Group.svg" alt="Group Logo" /></div>
            <h1>YOUTH ORIENTED UNIFIED TRANSPARENCY HUB</h1>
            <h2>IRIGA CITY</h2>
        </div>

        <div class="carousel-container">
            <div ref="swiperContainer" class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="n in 10" :key="n">
                        <img :src="`/ex.jpg`" :alt="`Movie ${n}`" />
                    </div>
                </div>
                <!-- Pagination element -->
                <div class="swiper-pagination"></div>
            </div> 
        </div>
    </div>
</template>

<script>
import { Swiper } from "swiper";
import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/autoplay";
import "swiper/css/pagination";
import { EffectCoverflow, Autoplay, Pagination } from "swiper/modules";

export default {
    name: "HeroComponent",
    data() {
        return {};
    },
    mounted() {
        this.$nextTick(() => {
            this.initSwiper();
        });
    },
    methods: {
        initSwiper() {
            new Swiper(this.$refs.swiperContainer, {
                modules: [EffectCoverflow, Autoplay, Pagination],
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 30,
                    stretch: 0,
                    depth: 300,
                    modifier: 1,
                    slideShadows: true,
                },
                loop: true,
                autoplay: {
                    delay: 1500,
                    disableOnInteraction: true,
                },
                // Add pagination configuration
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        },
    },
};
</script>

<style scoped>
.hero-container {
    position: relative;
    margin-top: 10vh;
    padding: 5rem 2rem;
    width: 100%;
    height: 80vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4rem;
    text-align: center;
    border-radius: 3rem;
}

.content {
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 8;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.content img {
    width: 250px; /* Adjust size as needed */
}

h1, h2 {
    will-change: transform, opacity;
    font-weight: bold;
    background: linear-gradient(to left, #3772FF 20%, #DF2935 50%, #FFFFFF, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animate-gradient 3.5s linear infinite;
}

h1 {
    font-size: 3rem;
    font-weight: 800;
    display: inline-block;
    white-space: nowrap;
}

h2 {
    font-size: 4rem;
    font-weight: 900;
    margin-top: 5px;
}

@keyframes animate-gradient {
    from {
        background-position: 200% 50%;
    }
    to {
        background-position: 0% 50%;
    }
}

@keyframes slider-animation {
    from {
        background-position: 200% 50%;
    }
    to {
        background-position: 0% 50%;
    }
}

.carousel-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.swiper {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: 75%;
    text-align: center;
    position: relative;
}

.swiper-slide img {
    display: block;
    width: 100%;
    border-radius: 2rem;
}

/* Optional: Style pagination bullets */
.swiper-pagination-bullet {
    background-color: #fff;
    opacity: 0.7;
}

.swiper-pagination-bullet-active {
    background-color: #001d61;
    opacity: 1;
}
</style>
