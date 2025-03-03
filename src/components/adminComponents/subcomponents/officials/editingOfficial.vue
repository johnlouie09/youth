<template>
    <v-container class="editing-official-main">
        <PersonalInfoCard></PersonalInfoCard>
        <EducationalOfficial></EducationalOfficial>
        <PersonalAchievements></PersonalAchievements>
        <OtherInformation></OtherInformation>
        <div class="back" @click="$router.push('/admin/officials')">
            <v-icon>mdi-arrow-left</v-icon>
        </div>




    </v-container>
</template>Oth

<script setup>
import { ref } from "vue";
import PersonalInfoCard from "./PersonalInfoCard.vue";
import EducationalOfficial from "./EducationalOfficial.vue";
import PersonalAchievements from "./PersonalAchievements.vue";
import OtherInformation from "./OtherInformation.vue";
</script>

<style scoped>
.editing-official-main {
    padding: 4rem 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 4rem;
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
