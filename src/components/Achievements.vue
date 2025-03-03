<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    achievements: {
        type: Array,
        required: true,
    },
});

// Create a reactive array to track each card's expanded state
const showStates = ref([]);

// Watch for changes in props.achievements and initialize showStates
watch(() => props.achievements, (newAchievements) => {
    showStates.value = newAchievements.map(() => false); 
}, { immediate: true });

const toggleShow = (index) => {
    showStates.value[index] = !showStates.value[index];
};
</script>

<template>
    <v-container class="container">
        <v-row>
            <v-col v-for="(achievement, index) in props.achievements" :key="index" cols="12" md="4">
                <v-card class="custom-card mx-auto" max-width="435" elevation="10">
                    <v-img
                        height="200"
                        style="scale: 35%"
                        src="/Sangguniang_Kabataan_logo.svg"
                    ></v-img>

                    <v-card-title class="overlay-titleee">
                        {{ achievement.title }}
                    </v-card-title>

                    <v-card-subtitle>
                        {{ achievement.subtitle }}
                    </v-card-subtitle>

                    <v-card-actions>
                        <v-btn color="orange-lighten-2" @click="toggleShow(index)">
                            {{ showStates[index] ? 'Show Less' : 'Show More' }}
                        </v-btn>
                    </v-card-actions>

                    <v-expand-transition>
                        <div v-show="showStates[index]">
                            <v-divider></v-divider>
                            <v-card-text>
                                {{ achievement.info }}
                            </v-card-text>
                        </div>
                    </v-expand-transition>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<style>
@import "../assets/Achievements.css";
@import "../assets/fontEffects.css";
</style>
