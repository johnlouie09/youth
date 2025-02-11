<script setup>
import Preloader from "../components/Preloader.vue";
import barangayHall from '/San_Francisco_Barangay_Hall.JPG?url';
import Carousel from "../components/Carousel.vue";
import Cards from "../components/Cards.vue";
import Achievements from "../components/Achievements.vue";
import Footer from "../components/Footer.vue";
import ThemeSwitcher from "../components/ThemeSwitcher.vue";
</script>

<template>
    <Preloader/>
    <v-app :theme="$vuetify.theme.global.name.value">
        <!-- Navbar -->
        <v-app-bar app color="black" rounded>
           <v-img src="/youth.svg" style="scale: 300%; margin-left: -300px;"></v-img>
            <v-spacer></v-spacer>
            <v-btn>
                <ThemeSwitcher />
            </v-btn>
        </v-app-bar>

        <!-- Hero Section -->
        <div class="relative flex justify-center items-center overflow-hidden">
            <img class="w-full object-fill" :src="barangayHall" style="height: 350px;" />

            <!-- Left Logo -->
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2" style="margin-left: 100px; scale: 2.5;">
                <img class="w-24 h-auto" src="/Logoseal.svg" alt="logo" />
            </div>

            <!-- Center Text -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-5xl font-bold">
                Barangay San Francisco
            </div>

            <!-- Right Logo -->
            <div class="absolute right-0 top-1/2 transform -translate-y-1/2" style="margin-right: 100px; scale: 2.5;">
                <img class="w-24 h-auto" src="/Logoseal.svg" alt="logo" />
            </div>
        </div>

        <br>

        <!-- Announcements Section -->
        <div>
            <h1>Announcements</h1>
            <Carousel />

            <br><br>
            <Cards/>
        </div>

        <br>

        <!-- Achievements Section -->
        <h1>Achievements</h1>
        <Achievements />
    </v-app>
</template>
<style>
h1 {
    text-align: center;
    font-size: 32px;
    text-transform: uppercase;
    font-weight: bold;
}
.container {
    background-color: #1f1d1d;
}
.light-theme {
    font-family: 'Arial, sans-serif';
}

.dark-theme {
    font-family: 'Courier New, monospace';
}
</style>