<template>
    <div class="carousel-container">
        <h1 class="title">Announcements</h1>
        <div ref="swiperContainer" class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="announcement in announcements" :key="announcement.id">
                    <img :src="`/public/announcements/${announcement.img}`" :alt="announcement.title"/>
                </div>
            </div>
            <!-- Pagination container -->
            <div class="swiper-pagination"></div>
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
    name: "Announcements",
    data() {
        return {
            announcements: [
                { id: 1, img: "bb_tryout.jpg", title: "Announcement 1" },
                { id: 2, img: "interzone_bb.jpg", title: "Announcement 2" },
                { id: 3, img: "kk_ass.jpg", title: "Announcement 3" },
                { id: 4, img: "teentrail.jpg", title: "Announcement 4" },
                { id: 5, img: "youthnight.jpg", title: "Announcement 5" }
            ]
        };
    },
    mounted() {
        this.$nextTick(() => {
            this.initSwiper();
        });
    },
    methods: {
        initSwiper() {
            new Swiper(this.$refs.swiperContainer, {
                initialSlide: 12,  // Start from the middle (index 12 for 25 slides)
                modules: [EffectCoverflow, Autoplay, Pagination],
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 15,
                    stretch: 0,
                    depth: 350,
                    modifier: 1,
                    slideShadows: false,
                },
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        }
    },
};
</script>

<style scoped>
.carousel-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3rem;
    align-items: center;
    width: 100%;
}

.swiper {
    width: 90%;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: 500px;
    position: relative;
}

.swiper-slide img {
    width: 100%;
    height: 600px;
    border-radius: 1rem;
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

.title {
    font-size: 2.5rem;
    font-weight: 900;
}
</style>
