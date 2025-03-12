

<template>
    <v-container class="announcement-main">
        <h1>ANNOUNCEMENTS</h1>

        <form class="announcement-form" v-if="showForm">
            <input type="file" accept="image/*" @change="addAnnouncement" required />
        </form>

        <div class="carousel-container">
            <div ref="swiperContainer" class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="movie in movies" :key="movie.id">
                        <img :src="movie.src" :alt="movie.title" />
                        <v-btn color="red-lighten-1" class="delete">DELETE</v-btn>
                    </div>
                    <v-card class="swiper-slide add-announcement">
                        <label for="file-upload" class="add-btn">
                            <v-icon color="teal-lighten-1" size="75">mdi-plus-circle-outline</v-icon>
                            <p>ADD ANNOUNCEMENT</p>
                        </label>
                        <input id="file-upload" type="file" accept="image/*" @change="addAnnouncement" hidden />
                    </v-card>
                </div>
            </div>
        </div>
    </v-container>
</template>

<script>
import { Swiper } from "swiper";
import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/autoplay";
import { EffectCoverflow, Autoplay } from "swiper/modules";

export default {
    data() {
        return {
            swiperContainer: null,
            newImage: null,
            movies: Array.from({ length: 7 }, (_, i) => ({ id: i + 1, src: `/${i + 1}.jpg`, title: `Movie ${i + 1}` })),
            showForm: false,
        };
    },
    methods: {
        addAnnouncement(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.movies.push({
                        id: this.movies.length + 1,
                        src: e.target.result,
                        title: `Movie ${this.movies.length + 1}`,
                    });
                };
                reader.readAsDataURL(file);
            }
        }
    },
    mounted() {
        this.swiperContainer = this.$refs.swiperContainer;
        new Swiper(this.swiperContainer, {
            modules: [EffectCoverflow, Autoplay],
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
                delay: 5000,
            },
        });
    }
};
</script>

<style scoped>
.announcement-main {
    padding: 4rem 5rem;
    display: flex;
    flex-direction: column;
    gap: 3rem;
}

h1 {
    text-align: center;
    font-size: 2rem;
    font-weight: bolder;
}

.announcement-form {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.carousel-container {
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);
    padding: 1rem 3rem;
    border-radius: 1.5rem;
}

.swiper {
    width: 100%;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: 450px;
    text-align: center;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
}

.swiper-slide .delete {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.swiper-slide:hover .delete {
    opacity: 1;
}

.swiper-slide img {
    display: block;
    width: 100%;
    border-radius: 0.5rem;
}

.delete {
    padding: 0.5rem 1rem;
}

.add-announcement {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 400px;
    height: 85%;
    border-radius: 10px;
    cursor: pointer;
}

.add-btn {
    font-size: 2rem;
    border-radius: 50%;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;

    font-size: 1rem;
}
</style>