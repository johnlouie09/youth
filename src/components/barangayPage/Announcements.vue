<template>

    <!-- Announcements Cards -->
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
            <div class="swiper-wrapper h-full">
                    <v-card
                    v-for="announcement in announcements" :key="announcement.id"
                    style="border-radius: 1rem;"
                    class="swiper-slide w-sm d-flex flex-col items-center justify-center ga-5 elevation-10 pt-10 pb-5 px-5 ma-5"
                    >
                        <div>
                            <img 
                                :src="announcement.img 
                                        ? ($store.getters.base + 'public/announcements/' + announcement.img) 
                                        : ($store.getters.base + 'public/announcements/exx.jpg')"
                                :alt="announcement.title"
                                style="border-radius: .5rem; width: 280px ;height: 400px;"
                                cover
                                class="elevation-10"
                            ></img>
                        </div>

                        <div class="d-flex flex-col justify-between items-center h-full">
                            <v-card-item class="w-[90%] relative d-flex py-5 pb-10 elevation-5 rounded-lg">
                                <h2 class="uppercase text-center text-base font-extrabold mb-2">
                                    {{ announcement.title }}
                                    <v-divider class="mt-1"></v-divider>
                                </h2>

                                <p class="text-sm font-base italic text-center">
                                    {{ announcement.description }} Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi quo facere com. lorem
                                </p>

                                <span class="text-xs font-italic absolute bottom-0 right-0 pa-2">
                                    {{ formatDateStr(announcement.date) }}
                                </span>
                            </v-card-item>

                            <v-card-actions class="h-[20%]">
                                <v-btn @click="showAnnouncement(announcement)" color="teal-lighten-1">SEE DETAILS</v-btn>
                            </v-card-actions>
                        </div>
                    </v-card>                    
            </div>
        </div>
    </div>

    <!-- Announcement Dialog -->
    <v-dialog v-model=showAnnouncementDetails width="auto" max-width="1200px" max-height="90vh">
        <v-card class="d-flex justify-center items-center py-15 ga-5" style="border-radius: 1rem;">
            <h1 class="w-[90%] text-3xl font-extrabold text-center uppercase">{{ announcementDetails.title }} <v-divider class="mt-3"></v-divider></h1>
            <div class="announcementDialog w-[90%]">
                <div class="d-flex flex-col justify-around items-center py-5">
                    <div class="d-flex justify-center items-center ga-3">
                        <div class="custom-card w-full d-flex justify-center items-center ga-3 elevation-5 py-3 px-5 rounded-md border">
                            <h3 class='text-center text-sm'><i class="text-lg font-extrabold">WHO</i><br>Organized by Barangay San Francisco. Open to all residents, especially youth and local groups.</h3>
                        </div>

                        <v-btn icon class="border">
                            <v-icon :size="30">mdi-account</v-icon>
                        </v-btn>
                        
                    </div>

                    <div class="d-flex justify-center items-center ga-3">
                        <div class="custom-card w-full d-flex justify-center items-center ga-3 elevation-5 py-3 px-5 rounded-md border">
                            <h3 class='text-center text-sm'><i class="text-lg font-extrabold">WHY</i><br>To promote cleanliness, reduce waste, and build community responsibility.</h3>
                        </div>
                        <v-btn class="border" icon>
                            <v-icon :size="30">mdi-lightbulb-on-outline</v-icon>
                        </v-btn>
                    </div>

                    <div class="d-flex justify-center items-center ga-3">
                        <div class="custom-card w-full d-flex justify-center items-center ga-3 elevation-5 py-3 px-5 rounded-md border">
                            <h3 class='text-center text-sm'><i class="text-lg font-extrabold">WHAT</i><br>Barangay Clean-Up Drive to collect trash, recycle, and improve public spaces.</h3>
                        </div>
                        <v-btn class="border" icon>
                            <v-icon :size="30">mdi-help-circle-outline</v-icon>
                        </v-btn>
                    </div>
                </div>

                <div class="d-flex flex-col justify-center items-center ga-3">
                    <Carousel v-if="showAnnouncementImages" v-bind="config">
                        <Slide v-for="n of 1">
                        <img                    
                        :src="announcementDetails.img 
                            ? ($store.getters.base + 'public/announcements/' + announcementDetails.img) 
                            : ($store.getters.base + 'public/announcements/exx.jpg')"
                        :alt="announcementDetails.title" />
                        </Slide>

                        <template #addons>
                        <Navigation />
                        </template>
                    </Carousel>

                    <img
                        class="rounded-lg max-h-[600px] max-w-[400px] elevation-10"
                        :src="announcementDetails.img 
                            ? ($store.getters.base + 'public/announcements/' + announcementDetails.img) 
                            : ($store.getters.base + 'public/announcements/exx.jpg')"
                        :alt="announcementDetails.title">
                    </img>

                    <v-card-actions>
                        <v-btn color="teal">SEE MORE IMAGES</v-btn>
                    </v-card-actions>
                </div>



                
                <div class="d-flex flex-col justify-around items-center py-5"> 
                    <div class="d-flex justify-center items-center ga-3">
                        <v-btn class="border" icon>
                            <v-icon :size="30">mdi-calendar-clock</v-icon>
                        </v-btn>
                        <div class="custom-card w-full d-flex justify-center items-center ga-3 elevation-5 py-3 px-5 rounded-md border">
                            <h3 class='text-center text-sm'><i class="text-center text-lg font-extrabold">WHEN</i><br>April 15, 2025 | 7:00 AM – 12:00 PM</h3>
                        </div>
                    </div>

                    <div class="d-flex justify-center items-center ga-3">
                        <v-btn class="border" icon>
                            <v-icon :size="30">mdi-map-marker</v-icon>
                        </v-btn>
                        <div class="custom-card w-full d-flex justify-center items-center ga-3 elevation-5 py-3 px-5 rounded-md border">
                            <h3 class='text-center text-sm'><i class="text-center text-lg font-extrabold">WHERE</i><br>Barangay Francia, Iriga City – Starting at Barangay Hall, covering nearby areas.</h3>
                        </div>
                    </div>
                </div>
            </div>
        </v-card>
    </v-dialog>
</template>

<script>
import { Swiper } from "swiper";
import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/autoplay";
import "swiper/css/pagination";
import { EffectCoverflow, Autoplay, Pagination } from "swiper/modules";

import 'vue3-carousel/carousel.css'
import { Carousel, Slide, Navigation } from 'vue3-carousel'
import $ from 'jquery';

export default {
    name: "Announcements",
    components : {
        Carousel,
        Slide,
        Navigation,
    },
    props: {
        barangayId: Number
    },
    data() {
        return {
            announcements: [],
            items: ['Select a Month', 'January', 'February', 'March', 'April'],
            selectedAnnoncementItem: 'Select a Month',
            announcementDetails: [],
            showAnnouncementDetails: false,
            isFetchingAnnouncements: false,


            config: {
                height: 500,
                gap: 5,
                wrapAround: true,
            },
        };

    },
    computed: {
        baseUrl() {
            return window.location.origin === 'http://localhost:5173'
                ? 'http://localhost:5173'
                : this.$store.getters['base'];
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.initSwiper();
        });
    },
    methods: {
        showAnnouncement(announcement) {
            this.announcementDetails = { ...announcement };
            this.showAnnouncementDetails = true
        },
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
            const swiperContainer = this.$refs.swiperContainer;
            if (!swiperContainer) {
                console.error('Swiper container not found!');
                return;
            }

            const swiper = new Swiper(swiperContainer, {
                initialSlide: 1,
                modules: [EffectCoverflow, Autoplay, Pagination],       
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 0,
                    modifier: 1,
                },
                loop: false,
                autoplay: {
                    delay: 100000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        },
        async fetchBarangayAnnouncements() {
            if (this.isFetchingAnnouncements) {
                console.log('Fetch already in progress, skipping...');
                return;
            }
            this.isFetchingAnnouncements = true;
            try {
                await $.ajax({
                    url: `${this.$store.getters['api_base']}?e=barangay&a=announcements`,
                    type: 'POST',
                    xhrFields: { withCredentials: true },
                    headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
                    data: { barangayId: this.barangayId },
                    beforeSend: function(xhr) {
                        const token = document.querySelector('meta[name="csrf-token"]').content || '';
                    },
                    success: (data, textStatus, jqXHR) => {
                        try {
                            this.announcements = data.data.announcements || [];
                        } catch (error) {
                            console.error('Error parsing JSON response:', error);
                            console.log('Raw response:', jqXHR.responseText);
                            this.announcements = [];
                            this.$nextTick(() => {
                                this.initSwiper();
                            });
                        }
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        console.error("Fetch error:", textStatus, errorThrown);
                        console.log('Raw response:', jqXHR.responseText);
                        this.announcements = [];
                        this.$nextTick(() => {
                            this.initSwiper();
                        });
                    },
                    complete: () => {
                        this.isFetchingAnnouncements = false;
                    }
                });
            } catch (error) {
                console.error('Promise rejection:', error);
                this.announcements = [];
                this.isFetchingAnnouncements = false;
                this.$nextTick(() => {
                    this.initSwiper();
                });
            }
        },
    },
    created() {
        this.fetchBarangayAnnouncements();
    },
    watch: {
        barangayId(newVal, oldVal) {
            if (newVal !== oldVal) {
                this.fetchBarangayAnnouncements();
            }
        }
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
    width: 100%;
}

.swiper {
    width: 100%;
    height: 80vh;
    overflow: visible;
}

.swiper-slide {
    background-position: center;
    width: 400px;
    height: auto;    
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

.announcementDialog{
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    column-gap: 1.5rem;
}

.carousel {
  --vc-nav-background: rgba(255, 255, 255, 0.7);
  --vc-nav-border-radius: 90%;
}

img {
  border-radius: 8px;
  width: auto;
  height: auto;
}

</style>