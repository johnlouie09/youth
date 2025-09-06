<template>
    <!-- Achievements Card -->
    <v-container fluid class="pa-0 ma-0 mb-15 d-flex flex-col justify-start items-center ga-5">
                <!-- Title Section -->
        <v-card-title class="gradient-text title d-flex items-center justify-center ga-5 ma-5">
            <v-icon size="60">mdi-trophy</v-icon>
                <h1 class="gradient-text font-black uppercase">Achievements</h1>
            <v-icon size="60">mdi-trophy</v-icon>
        </v-card-title>


        <!-- Achievement Sorting Selector -->
        <v-tabs v-model="selectedAchievementSort" grow class="my-5">
            <div class="grid grid-cols-2 ga-5">
                <v-tab value='all' class="border rounded-md col-span-1">ALL</v-tab>
                <v-tab value="month" class="border rounded-md col-span-1">
                    <v-select
                        v-model="selectedMonth"
                        class="border rounded-md w-full"
                        :items="items"
                        density="comfortable"
                        hide-details
                    />
                </v-tab>
            </div>
        </v-tabs>

        <div class="achievements">
            <v-card
                v-for="(achievement, index) in achievements" :key="index"
                class="card custom-card elevation-10"
            >
                <img :src="achievement.img ? ($store.getters.base + 'public/achievements/' + achievement.img) : ($store.getters.base + 'public/achievements/no-avatar.png')" alt="" class="w-full max-h-[225px] elevation-10">

                <article class="relative pb-5">
                    <h3 class="text-lg uppercase font-extrabold">{{ achievement.title }}</h3>
                    <h5 class="text-base">{{ achievement.subtitle }}</h5>
                    <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-1">{{ formatDate(achievement.date) }}</h5>
                </article>

                <v-card class="w-[90%] d-flex items-center ga-1 px-5 mb-5 elevation-5">
                    <v-avatar
                        :image="achievement.sk_official_img
                        ? (baseUrl + '/OfficialImages/' + achievement.sk_official_img)
                        : (baseUrl + '/OfficialImages/no-avatar.png')"
                        size="50"
                    />
                    <v-card-text class="d-flex flex-col">
                        <span class="text-sm">Hon. {{ achievement.sk_official_name }}</span>
                        <span class="uppercase text-xs">{{ achievement.sk_official_position }}</span>
                    </v-card-text>
                </v-card>

                <v-btn 
                class="px-5" 
                color="teal-darken-3"
                @click="showAchievement(achievement)">
                DETAILS
                </v-btn>
            </v-card>
        </div>
    </v-container>

    <!-- Achievement Dialog -->
    <v-dialog v-model=showAchievementDetails width="1100px" max-height="95vh">
        <v-card class="hella rounded-3xl overflow-y-auto" style="border-radius: 2rem;"> 

            <!-- Achievement Images Slideshow -->
            <div class="w-full">
                <div ref="swiperContainer" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="(image, index) in achievementDetails.images">
                            <img 
                                :src="image.img
                                        ? ($store.getters.base + 'public/achievements/' + image.img) 
                                        : ($store.getters.base + 'public/achievements/no-avatar.png')"
                                style="border-radius: .5rem; height: 300px;"
                                contain
                            ></img>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Achievement Details -->
            <div class="w-full d-flex flex-col justify-around items-center gap-1" style="font-family: 'Inter', sans-serif;">
                <div class="w-full d-flex flex-col justify-center items-center ga-1 border-b py-3 relative">
                    <h2 class='uppercase text-2xl font-extrabold'>{{ achievementDetails.title }}</h2>
                    <h3 class="capitalize w-[55%] text-sm text-center italic font-light">{{ achievementDetails.subtitle }}</h3>
                    <div class="absolute right-0 bottom-0 pa-2">
                        <p class="italic text-xs font-light" v-for="(date, index) in achievementDetails.dates">{{ formatDate(date.date) }}</p>
                    </div>
                </div>

                <p class="w-full text-base text-center my-2 px-2 py-4 rounded-md">{{ achievementDetails.info }}</p>
            </div>

            <!-- SK Official Comments -->
            <v-sheet class="w-[90%] d-flex ga-8 items-center px-10 py-5 elevation-10">
                <div class="d-flex flex-col justify-center items-center ga-2 w-auto">
                    <v-avatar                         
                    :image="achievementDetails.sk_official_img
                    ? (baseUrl + '/OfficialImages/' + achievementDetails.sk_official_img)
                    : (baseUrl + '/OfficialImages/no-avatar.png')"
                    size="70">
                    </v-avatar>
                    <h3 class="w-full uppercase text-xs whitespace-nowrap overflow-hidden text-ellipsis">{{ achievementDetails.sk_official_position }}</h3>
                </div>

                <div class="d-flex flex-col justify-center ga-1 h-full">
                    <h3 class="font-bold text-sm">Hon. {{ achievementDetails.sk_official_name }}</h3>
                    <p class="italic font-extralight text-sm overflow-y-auto h-full">{{ achievementDetails.sk_official_comment }}</p>
                </div>
            </v-sheet>
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
    props: {
        barangayId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            myBarangayId: this.barangayId,
            achievements: [],  // Initialize as an array, not a string.
            allAchievements: [], // store unfiltered list

            showAchievementDetails: false,
            achievementDetails: [],

            items: [],
            selectedAchievementSort: 'all',  
            selectedMonth: 'Select a Month' // ✅ default value
        };
    },
    methods: {
        toggleShow(index) {
            this.showStates[index] = !this.showStates[index];
            // No need for $forceUpdate(), Vue should handle reactivity.
        },
        formatDate(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
            });
        },
        async fetchBarangayAchievements() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            await $.ajax({
                url: `${this.$store.getters['api_base']}?e=barangay&a=achievements`,
                type: 'POST',
                xhrFields: {
                    withCredentials: true
                },
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                data: {
                    barangayId: this.myBarangayId,
                },
                success: (data) => {
                    this.allAchievements = data.data.achievements; // ✅ keep original
                    this.achievements = [...this.allAchievements]; // show all initially
                    this.populateMonths();

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
        },

        populateMonths() {
            const monthYearSet = new Set();

            this.achievements.forEach(achievement => {
                if (achievement.dates && Array.isArray(achievement.dates)) {
                    achievement.dates.forEach(d => {
                        if (d.date) {
                            // Convert '2025,07,25' → Date object
                            const parts = d.date.split('-');
                            const date = new Date(parts[0], parts[1] - 1, parts[2]);

                            // Format "April 2002"
                            const monthYear = date.toLocaleDateString('en-US', {
                                month: 'long',
                                year: 'numeric'
                            });

                            monthYearSet.add(monthYear);
                        }
                    });
                }
            });

            // Convert Set → Array of strings like "April 2002"
            this.items = Array.from(monthYearSet).sort((a, b) => {
                // Parse back into Date for sorting
                const [monthA, yearA] = a.split(' ');
                const [monthB, yearB] = b.split(' ');
                const dateA = new Date(`${monthA} 1, ${yearA}`);
                const dateB = new Date(`${monthB} 1, ${yearB}`);
                return dateB - dateA; // latest first
            });

            // Add "Select a Month" at the beginning
            this.items.unshift('Select a Month');

            console.log("📅 Available Months:", this.items);
        },

        
        filterAchievementsByMonth(monthYear) {
            if (!monthYear || monthYear === 'Select a Month') {
                // Reset back to all
                this.achievements = [...this.allAchievements];
                return;
            }

            this.achievements = this.allAchievements.filter(achievement => {
                if (!achievement.dates) return false;

                return achievement.dates.some(d => {
                    if (!d.date) return false;

                    // Parse "2025-07-25" or "2025,07,25"
                    const parts = d.date.includes('-') ? d.date.split('-') : d.date.split(',');
                    const date = new Date(parts[0], parts[1] - 1, parts[2]);

                    const formatted = date.toLocaleDateString('en-US', {
                        month: 'long',
                        year: 'numeric'
                    });

                    return formatted === monthYear;
                });
            });
        },

        showAchievement(achievement){
            this.showAchievementDetails = true;
            this.achievementDetails = { ... achievement };

            this.$nextTick(() => {
                this.initSwiper(); // Now the dialog content (including swiperContainer) is mounted
            });
        },
        initSwiper() {
            const swiperContainer = this.$refs.swiperContainer;
            if (!swiperContainer) {
                console.error('Swiper container not found!');
                return;
            }

            // Ensure Swiper modules are imported above:
            // import Swiper from 'swiper';
            // import { EffectCoverflow, Autoplay, Pagination } from 'swiper/modules';

            const swiper = new Swiper(swiperContainer, {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                loop: true, // Enables continuous autoplay loop
                autoplay: {
                    delay: 3000, // 3 seconds per slide
                    disableOnInteraction: false,
                },
                coverflowEffect: {
                    rotate: 10,      // More rotation = more 3D effect
                    stretch: 0,      // Space between slides
                    depth: 200,      // Controls how "deep" slides appear in 3D
                    modifier: 1,     // Intensity of the coverflow
                    scale: 1,
                    slideShadows: true,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                modules: [EffectCoverflow, Autoplay, Pagination],
            });
        }

    },
    created() {
        // Initialize achievements as an empty array so that .map() works.
        this.achievements = [];
        this.fetchBarangayAchievements();
    },
    watch: {
        achievements: {
            handler(newAchievements) {
                if (Array.isArray(newAchievements)) {
                    this.showStates = newAchievements.map(() => false);
                } else {
                    this.showStates = [];
                }
            },
            immediate: true
        },
        selectedAchievementSort(newVal) {
            if (newVal === 'all') {
                this.achievements = [...this.allAchievements];
            } else if (newVal === 'month' && this.selectedMonth && this.selectedMonth !== 'Select a Month') {
                this.filterAchievementsByMonth(this.selectedMonth);
            }
        },
        selectedMonth(newVal) {
            if (this.selectedAchievementSort === 'month') {
                this.filterAchievementsByMonth(newVal);
            }
        }

    },
    computed: {
        baseUrl() {
            return window.location.origin === 'http://localhost:5173'
            ? 'http://localhost:5173'
            : this.$store.getters['base'];
        }
    }
};
</script>

<style scoped>
.hella {
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;
    padding: 3rem 4rem;
    position: relative;
    gap: 1rem;
}

.achievements {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    align-items: flex-start;
    gap: 5rem;
    padding: 0rem 9rem;
}

.title > * {
    font-size: 2.5rem;
    background: linear-gradient(
        45deg,
        #0533a0,
        #ffffff,
        #DF2935,
        #ffffff,
        #FDCA40,
    );
    background: linear-gradient(to left, #3772FF, #fffefe, #DF2935, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animate-gradient 4s linear infinite;
}

@keyframes animate-gradient {
    from {
        background-position: 200% 50%;
    }
    to {
        background-position: 0% 50%;
    }
}

.card {
    width: 400px;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    position: relative;
    transition: transform 0.3s ease-in-out, border 0.3s ease-in-out;
    padding-bottom: 2rem;
}

.card:hover {
    transform: scale(1.04);
}

article {
    width: 90%;
}


.swiper {
    width: 95%;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: 611px;
    display: flex;
    justify-content: center;
    align-items: center;

}

.swiper-slide img {
    width: 100%;
    border-radius: 1rem;
}

</style>
  