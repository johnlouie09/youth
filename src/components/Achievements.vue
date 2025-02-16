<script setup>
import { ref } from 'vue';

const showStates = ref([]); // Array to track each card's show state

const toggleShow = (index) => {
    showStates.value[index] = !showStates.value[index];
};
</script>

<template>
    <v-container>
        <v-row>
            <v-col v-for="(index) in 3" :key="index" cols="12" md="4">
                <v-card
                    class="custom-card mx-auto"
                    max-width="350"
                >
                    <v-img
                        height="200"
                        style="scale: 35%"
                        src="/Sangguniang_Kabataan_logo.svg"
                    ></v-img>

                    <v-card-title class="overlay-titleee">
                        Basketball
                    </v-card-title>

                    <v-card-subtitle>
                        Kung walang nilaga sana tayo nalang...
                    </v-card-subtitle>

                    <v-card-actions>
                        <v-btn
                            color="orange-lighten-2"
                            @click="toggleShow(index)"
                        >
                            {{ showStates[index] ? 'Show Less' : 'Show More' }}
                        </v-btn>
                    </v-card-actions>

                    <v-expand-transition>
                        <div v-show="showStates[index]">
                            <v-divider></v-divider>

                            <v-card-text>
                                I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape.
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
