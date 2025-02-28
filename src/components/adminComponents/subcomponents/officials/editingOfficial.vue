<template>
    <v-container class="editing-official-main">
        <!-- Intro Section -->
        <v-row justify="center" class="intro">
            <v-img :src="personalInfo.img" width="180" contain />
            <p class="motto" >
                {{ personalInfo.motto }}
            </p>
        </v-row>
        <PersonalInfoCard :personalInfo="personalInfo"></PersonalInfoCard>
        <EducationalOfficial></EducationalOfficial>
        <PersonalAchievements></PersonalAchievements>
        <OtherInformation></OtherInformation>

        <div class="back" @click="$router.push('/admin/officials')">
            <v-icon>mdi-arrow-left</v-icon>
        </div>

    </v-container>
</template>

<script setup>
import { ref } from "vue";
import PersonalInfoCard from "./PersonalInfoCard.vue";
import EducationalOfficial from "./EducationalOfficial.vue";
import PersonalAchievements from "./PersonalAchievements.vue";
import OtherInformation from "./OtherInformation.vue";

const personalInfo = ref({
    name: "John Doe Dela Cruz",
    email: "johnjohn@email.com",
    birthday: "1999-05-15",
    motto : "Lorem ipsum dolor sit amet consectetur. Sed ultrices ultrices volutpat lobortis nunc dictumst nulla neque.",
    img : "/public/Sangguniang_Kabataan_logo.svg"
})
</script>

<style scoped>
/* Intro Section */
.intro {
    padding: 2rem;
    border-bottom: 3px solid white;
    border-radius: 1rem;
    width: 50%;
    flex-wrap: nowrap;
    flex-direction: column;
    justify-items: center;
    align-items: center;
    gap: 2rem;
}

.motto {
    font-size: 1.25rem;
    text-align: center;
    margin-top: 1rem;
}


.editing-official-main {
    padding: 4rem 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 6rem;
}

.back {
    position: absolute;
    top: 4rem;
    right: 4rem;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    padding: 1.5rem;
}


</style>
