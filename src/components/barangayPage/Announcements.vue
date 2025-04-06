<template>
    <div class="carousel-container">
        <div class="relative w-[80%] d-flex flex-col justify-center items-center gap-5">
            <h1 class="title">ANNOUNCEMENTS</h1>
            <v-tabs grow class="w-[50%] d-flex justify-center gap-5">
                <v-tab>FEATURED</v-tab>
                <v-tab>
                    <v-select 
                    class="w-[100%]"
                    :items="items"
                    v-model='selectedAnnoncementItem'>
                    </v-select>
                </v-tab>

            </v-tabs>
        </div>

        <div ref="swiperContainer" class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="announcement in announcements" :key="announcement.id">


                    <div 
                    style="border-radius: 1rem;"
                    class="announcement-card bg-black h-auto d-flex flex-col items-center justify-start ga-5 elevation-10 py-5 px-5"
                    >
                        <img 
                            :src="announcement.img 
                                    ? ($store.getters.base + 'public/announcements/' + announcement.img) 
                                    : ($store.getters.base + 'public/announcements/exx.jpg')"
                            :alt="announcement.title"
                            style="border-radius: .5rem;"
                            cover
                        ></img>

                        <article class="w-[90%] relative py-5 pb-10 elevation-10">
                            <h4 class="uppercase text-center text-base font-extrabold mb-2">
                                {{ announcement.title }}
                            </h4>

                            <p class="text-sm font-medium">
                                {{ announcement.description }} Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi quo facere cum.
                            </p>

                            <span class="text-xs font-italic absolute bottom-0 right-0 pa-2">
                                {{ formatDateStr(announcement.date) }}
                            </span>
                        </article>

                    </div>


                    
                        <!-- <img :src="`/public/announcements/${announcement.img}`" :alt="announcement.title"/> -->
                    
                    
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
            announcements: [],
            items: ['Select a Month', 'January', 'February', 'March', 'April'],
            selectedAnnoncementItem: 'Select a Month',

        };
    },
    mounted() {
        this.$nextTick(() => {
            this.initSwiper();
        });
    },
    methods: {
        formatDateStr(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
            });
        },
        initSwiper() {
            new Swiper(this.$refs.swiperContainer, {
                initialSlide: 1,
                modules: [EffectCoverflow, Autoplay, Pagination],
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 5,
                    stretch: 0,
                    depth: 400,
                    modifier: 1,
                    slideShadows: true,
                },
                loop: false,
                autoplay: {
                    delay: 10000,
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
    gap: 2rem;
    align-items: center;
    width: 100%;
}

.swiper {
    width: 75%;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: 455px;
    position: relative;
}

.swiper-slide img {
    width: 100%;
    height: 650px;
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
