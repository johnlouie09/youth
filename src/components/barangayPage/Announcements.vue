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
                        v-model="selectedAnnoncementItem"
                    />
                </v-tab>
            </v-tabs>
        </div>

        <div ref="swiperContainer" class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="announcement in announcements" :key="announcement.id">
                    <div class="announcement-card bg-black h-auto d-flex flex-col items-center justify-start ga-5 elevation-10 py-5 px-5">
                        <img
                            :src="announcement.img
                                ? (baseUrl + '/announcements/' + announcement.img)
                                : (baseUrl + '/announcements/exx.jpg')"
                            :alt="announcement.title"
                            style="border-radius: .5rem;"
                            cover
                        />
                        <article class="w-[90%] relative py-5 pb-10 elevation-10">
                            <h4 class="uppercase text-center text-base font-extrabold mb-2">
                                {{ announcement.title || 'No Title' }}
                            </h4>
                            <p class="text-sm font-medium">
                                {{ announcement.description || 'No description available.' }} Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                            </p>
                            <span class="text-xs font-italic absolute bottom-0 right-0 pa-2">
                                {{ formatDateStr(announcement.date) }}
                              </span>
                        </article>
                    </div>
                </div>
                <div class="swiper-slide" v-if="announcements.length === 0">
                    <p>No announcements available.</p>
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
            isFetchingAnnouncements: false,
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
                    delay: 5000,
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
                            this.fetchImageFilenames();
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
        async fetchImageFilenames() {
            try {
                await $.ajax({
                    url: `${this.$store.getters['api_base']}?e=barangay&a=image_filenames`,
                    type: 'GET',
                    xhrFields: { withCredentials: true },
                    data: { barangayId: this.barangayId, type: 'announcements' },
                    success: (data, textStatus, jqXHR) => {
                        try {
                            const imageFilenames = data.data || [];
                            console.log('Image filenames:', imageFilenames);
                            this.announcements = this.announcements.map((announcement, index) => ({
                                ...announcement,
                                img: imageFilenames[index] || announcement.img || 'exx.jpg'
                            }));
                            console.log('Updated announcements with images:', this.announcements);
                            this.$nextTick(() => {
                                this.initSwiper();
                            });
                        } catch (error) {
                            console.error('Error parsing image filenames JSON:', error);
                            console.log('Raw response:', jqXHR.responseText);
                            this.$nextTick(() => {
                                this.initSwiper();
                            });
                        }
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        console.error("Error fetching image filenames:", textStatus, errorThrown);
                        this.$nextTick(() => {
                            this.initSwiper();
                        });
                    }
                });
            } catch (error) {
                console.error('Promise rejection in fetchImageFilenames:', error);
                this.$nextTick(() => {
                    this.initSwiper();
                });
            }
        }
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