<template>

    <!-- Achievements Card -->
    <v-container fluid class="achievement-main pa-0 ma-0 mb-15 d-flex flex-col ga-15">
        <h1 class="gradient-text font-black uppercase">Achievements</h1>
        <div class="achievements">
            <v-card
                v-for="(achievement, index) in achievements" :key="index"
                class="card custom-card elevation-10"
            >
                <img :src="`/achievements/${achievement.img}`" alt="" class="w-full max-h-[225px] elevation-10">

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
    <v-dialog v-model=showAchievementDetails width="1100px" height="95vh">
        <v-sheet class="hella rounded-3xl" style="border-radius: 2rem; overflow: hidden;"> 

            <!-- Achievement Images Slideshow -->
            <div ref="swiperContainer" class="swiper mySwiper w-[95%] h-[45%]">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="n of 10">
                        <img 
                            :src="achievementDetails.img 
                                    ? ($store.getters.base + 'public/achievements/' + achievementDetails.img) 
                                    : ($store.getters.base + 'public/achievements/exx.jpg')"
                            style="border-radius: .5rem; width: 611px; height: 314px;"
                            cover
                        ></img>
                    </div>
                </div>
            </div>


            <!-- Achievement Details -->
            <div class="w-full h-[40%] d-flex flex-col justify-around items-center gap-1" style="font-family: 'Inter', sans-serif;">
                <div class="d-flex flex-col justify-center items-center ga-2">
                    <h2 class='uppercase text-2xl font-extrabold'>{{ achievementDetails.title }}</h2>
                    <h3 class="capitalize w-[55%] text-sm text-center italic font-light">{{ achievementDetails.subtitle }} Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam rem dolorum quam! Odio t. Veniam rem dolorum quam! </h3>
                    <h3 class="font-bold text-xs">{{ formatDate(achievementDetails.date) }}</h3>
                </div>

                <p class="w-full h-[60%] text-base text-center overflow-y-auto my-2 px-2 py-4 rounded-md">{{ achievementDetails.info }} Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et exercitationem perferendis voluptates at. Qui, repudiandae fuga expedita possimus nisi necessitatibus consequuntur molestiae quisquam doloribus, culpa ipsum esse numquam eos. Sint. Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque ducimus nobis iusto explicabo, voluptatem quae. Commodi rem, officiis, rerum veritatis autem pariatur delectus voluptatibus nobis nam, consectetur animi nihil necessitatibus?</p>
            </div>

            <!-- SK Official Comments -->
            <v-sheet class="h-[16%] w-[90%] d-flex ga-8 items-center px-10 py-5 elevation-10">
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
                    <p class="italic font-extralight text-sm overflow-y-auto h-full">"As SK Chairperson, I am proud of the successful launch of the Adolescent Health Forum, which empowered our youth with knowledge, encouraged open dialogue, and reinforced our commitment to promoting their overall well-being and development."</p>
                </div>
            </v-sheet>
        </v-sheet>
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

            showAchievementDetails: false,
            achievementDetails: []
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
                    this.achievements = data.data.achievements;
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
    justify-content: space-between;
    align-items: center;
    padding: 3rem 4rem;
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

h1 {
    font-size: 2.5rem;
    background: linear-gradient(
        45deg,
        #0533a0,
        #ffffff,
        #DF2935,
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
    width: 100%;
    height: 314px;
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
  