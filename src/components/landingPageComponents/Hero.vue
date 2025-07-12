<template>

    <div class="hero-container">
        <div class="content relative">
            <h1>Empowering Youth,<br>Elevating Governance</h1>
            <h2>IRIGA CITY</h2>
            <p class="text-2xl font-bold italic">A unified digital hub that connects SK leaders and youth voters through transparency, engagement, and meaningful civic participation in Iriga City</p>
            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 d-flex flex-column justify-center items-center">
                <v-avatar 
                    :image="$store.getters.base + 'public/Group.svg'" 
                    size="500"
                    class="center-avatar">
                </v-avatar>
            </div>
            <SocialLinks class="d-flex flex-column justify-center items-center gap-3 px-15"></SocialLinks>  
        </div>

        <div class="magicpattern top-[-50%] left-[-12%]"/>
        <div class="magicpattern top-[-50%] right-[-15%]"/>
        <div class="magicpattern3 bottom-[-25%] left-[0%]"/>
        <div class="magicpattern2 bottom-[-25%] right-[-5%]"/>
    </div>

    <!-- 📽 Video Background -->
    <video class="video-bg" autoplay muted loop playsinline>
        <source src="./../../../public/bgvideo.webm" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="carousel-container">
        <div ref="swiperContainer" class="swiper mySwiper">
            <div class="swiper-wrapper">

                <div class="swiper-slide pa-5 d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/announcements/kalinisan.jpg`" class="max-h-[300px] rounded-lg" alt="">
                    <div class="w-full text-center">
                        <h4 class="uppercase font-bold text-sm">San Francisco, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Kalinisan Program</h3>
                        <span class="italic text-xs">February 15, 2025</span>
                    </div>
                </div>

                <div class="swiper-slide d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/achievements/1.jpg`" class="rounded-lg" alt="">
                    <div class="w-full">
                        <h4 class="uppercase font-bold text-sm">San Francisico, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Community Volunteers</h3>
                        <h4 class="w-full italic text-xs text-end">March 19, 2025</h4>
                    </div>
                </div>

                <div class="swiper-slide pa-5 d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/announcements/kalinisan.jpg`" class="max-h-[300px] rounded-lg" alt="">
                    <div class="w-full text-center">
                        <h4 class="uppercase font-bold text-sm">San Francisco, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Kalinisan Program</h3>
                        <span class="italic text-xs">February 15, 2025</span>
                    </div>
                </div>

                <div class="swiper-slide d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/achievements/1.jpg`" class="rounded-lg" alt="">
                    <div class="w-full">
                        <h4 class="uppercase font-bold text-sm">San Francisico, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Community Volunteers</h3>
                        <h4 class="w-full italic text-xs text-end">March 19, 2025</h4>
                    </div>
                </div>

                <div class="swiper-slide pa-5 d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/announcements/kalinisan.jpg`" class="max-h-[300px] rounded-lg" alt="">
                    <div class="w-full text-center">
                        <h4 class="uppercase font-bold text-sm">San Francisco, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Kalinisan Program</h3>
                        <span class="italic text-xs">February 15, 2025</span>
                    </div>
                </div>

                <div class="swiper-slide d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/achievements/1.jpg`" class="rounded-lg" alt="">
                    <div class="w-full">
                        <h4 class="uppercase font-bold text-sm">San Francisico, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Community Volunteers</h3>
                        <h4 class="w-full italic text-xs text-end">March 19, 2025</h4>
                    </div>
                </div>

                <div class="swiper-slide pa-5 d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/announcements/kalinisan.jpg`" class="max-h-[300px] rounded-lg" alt="">
                    <div class="w-full text-center">
                        <h4 class="uppercase font-bold text-sm">San Francisco, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Kalinisan Program</h3>
                        <span class="italic text-xs">February 15, 2025</span>
                    </div>
                </div>

                <div class="swiper-slide d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/achievements/1.jpg`" class="rounded-lg" alt="">
                    <div class="w-full">
                        <h4 class="uppercase font-bold text-sm">San Francisico, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Community Volunteers</h3>
                        <h4 class="w-full italic text-xs text-end">March 19, 2025</h4>
                    </div>
                </div>

                <div class="swiper-slide pa-5 d-flex flex-col justify-evenly items-center ga-5">
                    <img :src="$store.getters.base + `public/announcements/kalinisan.jpg`" class="max-h-[300px] rounded-lg" alt="">
                    <div class="w-full text-center">
                        <h4 class="uppercase font-bold text-sm">San Francisco, Iriga City</h4>
                        <h3 class="capitalize font-extrabold text-lg">Kalinisan Program</h3>
                        <span class="italic text-xs">February 15, 2025</span>
                    </div>
                </div>
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
import $ from 'jquery';
import SocialLinks from "./SocialLinks.vue";

export default {
    name: "HeroComponent",
    components : {
        SocialLinks
    },
    data() {
        return {
            shuffledImages: [],
        };
    },
    mounted() {
        this.$nextTick(() => {
            this.initSwiper();
        });
    },
    methods: {
        // Shuffle an array using the Fisher-Yates algorithm.
        shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        },

        // Fetch image filenames from the backend and shuffle them.
        getImageFilenames() {
            $.ajax({
              url: `${this.$store.getters['api_base']}?e=barangay&a=image-filenames`,
              type: 'GET',
              success: (data) => {
                this.shuffledImages = this.shuffleArray(data);
                console.log("Shuffled Images:", this.shuffledImages);
              },
              error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error fetching images:", textStatus, errorThrown);
              }
            });
        },
        initSwiper() {
            new Swiper(this.$refs.swiperContainer, {
                modules: [EffectCoverflow, Autoplay, Pagination],
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 0,
                    modifier: 1,
                    slideShadows: true,
                    loop: true,
                },
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
        ,
    },
    created() {
        this.getImageFilenames();
    }
};
</script>

<style scoped>
.hero-container {
    position: relative;
    width: 90%;
    height: 70vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    gap: 1rem;
    text-align: center;
    margin-top: 8vh;
    
}

.content {
    width: 60%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.content img {
    width: 250px;
}


h1, h2 {
    will-change: transform, opacity;
    font-weight: bold;
    background: linear-gradient(to left, #3772FF, #c9c7c7, #DF2935, #bdbcbc, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animate-gradient 3.5s linear infinite;
}

h1 {
    font-size: 4rem;
    font-weight: 800;
    line-height: 5rem;
    user-select: none;
    text-align: center;
    z-index: 3;
}

h2 {
    font-size: 2rem;
    font-weight: 800;
    user-select: none;
    text-align: center;
    z-index: 3;
}

p {
    user-select: none;
    z-index: 3;
}

@keyframes animate-gradient {
    from {
        background-position: 200% 50%;
    }
    to {
        background-position: 0% 50%;
    }
}


.login-btn {
    background-color: #4371f0;
    display: flex;
    justify-content: center;
    align-content: center;
    padding: 0rem 2rem;
    border-radius: .75rem;
    z-index: 2;
}

.center-avatar {
  opacity: .5;
}



@keyframes rotatingSlowly {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.magicpattern { 
    width: 700px;
    height: 700px;
    background: transparent;
    position: absolute;
    opacity: .9;
    background-size: cover;
    background-position: center center;
    background-repeat: repeat;
    animation: rotatingSlowly 60s linear infinite;
    background-image: url("data:image/svg+xml;utf8,%3Csvg viewBox=%220 0 1000 1000%22 xmlns=%22http:%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cdefs%3E%3ClinearGradient id=%22b%22 gradientTransform=%22rotate(45 .5 .5)%22%3E%3Cstop offset=%220%25%22 stop-color=%22%235a88fc%22%2F%3E%3Cstop offset=%2250%25%22 stop-color=%22%23f95a64%22%2F%3E%3Cstop offset=%22100%25%22 stop-color=%22%23fcd771%22%2F%3E%3C%2FlinearGradient%3E%3CclipPath id=%22a%22%3E%3Cpath fill=%22currentColor%22 d=%22M850 633q16 133-116 157t-236 31q-104 7-208-43T107 614Q28 500 76.5 364t169-206q120.5-70 237-17t229 88.5Q824 265 829 382.5T850 633Z%22%2F%3E%3C%2FclipPath%3E%3C%2Fdefs%3E%3Cg clip-path=%22url(%23a)%22%3E%3Cpath fill=%22url(%23b)%22 d=%22M850 633q16 133-116 157t-236 31q-104 7-208-43T107 614Q28 500 76.5 364t169-206q120.5-70 237-17t229 88.5Q824 265 829 382.5T850 633Z%22%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E");
}

.magicpattern2 { 
    width: 550px;
    height: 550px;
    background: transparent;
    position: absolute;
    opacity: .9;
    background-size: cover;
    background-position: center center;
    background-repeat: repeat;
    animation: rotatingSlowly 60s linear infinite;
    background-image: url("data:image/svg+xml;utf8,%3Csvg viewBox=%220 0 1000 1000%22 xmlns=%22http:%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cdefs%3E%3ClinearGradient id=%22b%22 gradientTransform=%22rotate(45 .5 .5)%22%3E%3Cstop offset=%220%25%22 stop-color=%22%235a88fc%22%2F%3E%3Cstop offset=%2250%25%22 stop-color=%22%23f95a64%22%2F%3E%3Cstop offset=%22100%25%22 stop-color=%22%23fcd771%22%2F%3E%3C%2FlinearGradient%3E%3CclipPath id=%22a%22%3E%3Cpath fill=%22currentColor%22 d=%22M847.5 625.5q-2.5 125.5-120 169t-243 92Q359 935 280.5 826T137 608.5q-65-108.5 17.5-204t154-184Q380 132 490 163t211.5 74q101.5 43 125 153t21 235.5Z%22%2F%3E%3C%2FclipPath%3E%3C%2Fdefs%3E%3Cg clip-path=%22url(%23a)%22%3E%3Cpath fill=%22url(%23b)%22 d=%22M847.5 625.5q-2.5 125.5-120 169t-243 92Q359 935 280.5 826T137 608.5q-65-108.5 17.5-204t154-184Q380 132 490 163t211.5 74q101.5 43 125 153t21 235.5Z%22%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E");
}

.magicpattern3 { 
    width: 550px;
    height: 550px;
    background: transparent;
    position: absolute;
    opacity: .9;
    background-size: cover;
    background-position: center center;
    background-repeat: repeat;
    animation: rotatingSlowly 60s linear infinite;
    background-image: url("data:image/svg+xml;utf8,%3Csvg viewBox='0 0 1000 1000' xmlns='http://www.w3.org/2000/svg'%3E%3Cdefs%3E%3ClinearGradient id='b' gradientTransform='rotate(45 .5 .5)'%3E%3Cstop offset='0%25' stop-color='%235a88fc'/%3E%3Cstop offset='50%25' stop-color='%23f95a64'/%3E%3Cstop offset='100%25' stop-color='%23fcd771'/%3E%3C/linearGradient%3E%3CclipPath id='a'%3E%3Cpath fill='currentColor' d='M776 594.5q-51 94.5-135 163T438 820q-119-6-217-94.5T91 488Q59 339 214.5 307T473 172q103-103 237-32t125.5 215.5Q827 500 776 594.5Z'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg clip-path='url(%23a)'%3E%3Cpath fill='url(%23b)' d='M776 594.5q-51 94.5-135 163T438 820q-119-6-217-94.5T91 488Q59 339 214.5 307T473 172q103-103 237-32t125.5 215.5Q827 500 776 594.5Z'/%3E%3C/g%3E%3C/svg%3E");
}

.carousel-container {
    display: absolute;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 1;
}

.swiper {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: auto;
    max-width: 25%;
    margin: 1rem 2rem;
}

.swiper-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}


.video-bg {
      position: absolute;
      top: 0; left: 0;
      z-index: 1;
      width: 100%;
      height: 100vh;
      object-fit: cover;
      opacity: .5;
    }
</style>
