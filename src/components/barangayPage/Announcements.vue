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


                    <v-card
                    style="border-radius: 1rem;"
                    class="announcement-card h-auto d-flex flex-col items-center justify-start ga-5 elevation-10 py-5 px-5 ma-5"
                    >
                        <img 
                            :src="announcement.img 
                                    ? ($store.getters.base + 'public/announcements/' + announcement.img) 
                                    : ($store.getters.base + 'public/announcements/exx.jpg')"
                            :alt="announcement.title"
                            style="border-radius: .5rem; width: 350px ;height: 500px;"
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

                        <v-card-actions>
                            <v-btn @click="showAnnouncement(announcement)" color="teal-lighten-1">SEE DETAILS</v-btn>
                        </v-card-actions>
                    </v-card>


                    
                        <!-- <img :src="`/public/announcements/${announcement.img}`" :alt="announcement.title"/> -->
                    
                    
                </div>
            </div>
        </div>
    </div>


    <v-dialog v-model=showAnnouncementDetails width="auto" max-width="1000px" max-height="80vh">
        <v-card class="d-flex justify-center items-center py-10 gap-5" style="border-radius: 1rem;">
            <h1 class="w-full text-2xl font-extrabold text-center uppercase py-5">Barangay Clean-Up Drive</h1>
            <div class="announcementDialog w-[90%] gap-10">
                <div class="d-flex flex-col justify-around items-center py-5">
                    <h3><i class="text-lg font-extrabold">WHAT:</i> Barangay Clean-Up Drive to collect trash, recycle, and improve public spaces.</h3>

                    <div>
                        <h3><i class="text-lg font-extrabold">WHEN:</i> April 15, 2025 | 7:00 AM – 12:00 PM</h3>
                    </div>

                    <h3><i class="text-lg font-extrabold">WHERE:</i> Barangay Francia, Iriga City – Starting at Barangay Hall, covering nearby areas.</h3>
                </div>
    
                <div>
                    <img 
                        :src="announcementDetails.img 
                                ? ($store.getters.base + 'public/announcements/' + announcementDetails.img) 
                                : ($store.getters.base + 'public/announcements/exx.jpg')"
                        :alt="announcementDetails.title"
                        style="border-radius: .5rem; width: 350px; height: 500px;"
                        cover
                    ></img>
                </div>

                <div class="d-flex flex-col justify-around items-center py-5">                      
                    <div>
                        <h3><i class="text-lg font-extrabold">WHO:</i> Organized by Barangay San Francisco. Open to all residents, especially youth and local groups.</h3>
                    </div>

                    <h3><i class="text-lg font-extrabold">WHY:</i> To promote cleanliness, reduce waste, and build community responsibility.</h3>
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
            showAnnouncementDetails: false,
            isFetchingAnnouncements: false
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
    overflow: visible;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: 455px;
    display: flex;
    justify-content: center;
    align-items: center;
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

.announcementDialog{
    display: grid;
    grid-template-columns: 1fr auto 1fr;
}

</style>