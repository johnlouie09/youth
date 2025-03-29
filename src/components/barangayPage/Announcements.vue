<template>
    <div class="carousel-container">
        <h1 class="title">ANNOUNCEMENTS</h1>
        <div ref="swiperContainer" class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="announcement in announcements" :key="announcement.id">
                    <img :src="`/public/announcements/${announcement.img}`" :alt="announcement.title"/>
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

export default {
    name: "Announcements",
    props: {
        barangayId: Number
    },
    data() {
        return {
            announcements: []
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
                initialSlide: 3,
                modules: [EffectCoverflow, Autoplay, Pagination],
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
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        },
        async fetchBarangayAnnouncements() {
        const api_base = 'http://localhost/youth/app/api.php';
        await $.ajax({
          url: `${api_base}?e=barangay&a=announcements`,
          type: 'POST',
          xhrFields: {
            withCredentials: true
          },
          headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
          },
          data: {
            barangayId: this.barangayId,
          },
          success: (data) => {
            this.announcements = data.data.announcements;
            console.log(data);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
            let errorMsg = "An error occurred while processing your request.";
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
              errorMsg = jqXHR.responseJSON.message;
            } else if (jqXHR.responseText) {
              errorMsg = jqXHR.responseText;
            }
          },
          complete: () => {
            // Optional: any actions after completion.
          }
        });
        }
    },
    created() {
        this.achievements = [];
        this.fetchBarangayAnnouncements();
    },
    watch: {

    }
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
    width: 80%;
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
