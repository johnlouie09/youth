<script setup>
import Preloader from "../../components/Preloader.vue";
import barangayHall from '/San_Francisco_Barangay_Hall.JPG?url';
import Carousel from "../../components/Carousel.vue";
import Cards from "../../components/Cards.vue";
import Achievements from "../../components/Achievements.vue";
import ThemeSwitcher from "../../components/ThemeSwitcher.vue";
</script>

<template>
    <Preloader/>
    <v-app :theme="$vuetify.theme.global.name.value">

        <v-app-bar app color="black">
            <v-img src="/youth.svg" style="scale: 300%; margin-left: -300px;"></v-img>
            <v-spacer></v-spacer>
            <v-btn>
                <ThemeSwitcher />
            </v-btn>
        </v-app-bar>
        <div class="relative flex justify-center items-center overflow-hidden">
            <img class="w-full object-fill" :src="barangayHall" alt="" style="height: 350px;" />

            <div class="absolute left-0 top-1/2 transform -translate-y-1/2" style="margin-left: 100px; scale: 2.5;">
                <img class="w-24 h-auto" src="/Logoseal.svg" alt="logo" />
            </div>

            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-5xl font-bold">
                Baranggay San Francisco
            </div>
            <div class="absolute right-0 top-1/2 transform -translate-y-1/2" style="margin-right: 100px; scale: 2.5;">
                <img class="w-24 h-auto" src="/Logoseal.svg" alt="logo" />
            </div>
        </div>
        <br>
        <div>
            <h1 class="gradient-text">Announcements</h1>
            <Carousel/>
            <br>
            <Cards/>
        </div>
        <br>
        <h1 class="gradient-text">Achievements</h1>
        <Achievements />
    </v-app>
</template>

<style>

.gradient-text {
    background-image: linear-gradient(to right, #3772FF 40%, #DF2935 50%, #FDCA40 60%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.font-bold {
    background-image: linear-gradient(45deg, #3772FF 2%, #DF2935 20%, #FDCA40 35%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: bold;

}
</style>
