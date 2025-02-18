<template>
    <v-app>
        <v-container>
            <v-navigation :elevation="0" grow class="d-flex justify-center">
                <v-btn
                    hover
                    @click="selectedUnit = 'Poblacion'"
                    :class="{'active-btn': selectedUnit === 'Poblacion', 'custom-btn': true}"
                    class="mx-2">
                    <span class="overlay-titles">Poblacion Unit</span>
                </v-btn>

                <v-btn
                    @click="selectedUnit = 'Mountain Unit'"
                    :class="{'active-btn': selectedUnit === 'Mountain Unit', 'custom-btn': true}"
                    class="mx-2">
                    <span class="overlay-titles">Mountain Unit</span>
                </v-btn>

                <v-btn
                    @click="selectedUnit = 'National Road Unit'"
                    :class="{'active-btn': selectedUnit === 'National Road Unit', 'custom-btn': true}"
                    class="mx-2">
                    <span class="overlay-titles">National Road Unit</span>
                </v-btn>

                <v-btn
                    @click="selectedUnit = 'East Road Unit'"
                    :class="{'active-btn': selectedUnit === 'East Road Unit', 'custom-btn': true}"
                    class="mx-2">
                    <span class="overlay-titles">East Road Unit</span>
                </v-btn>

                <v-btn
                    @click="selectedUnit = 'River Unit'"
                    :class="{'active-btn': selectedUnit === 'River Unit', 'custom-btn': true}"
                    class="mx-2">
                    <span class="overlay-titles">River Unit</span>
                </v-btn>

            </v-navigation>
        </v-container>

        <v-sheet
            class="mx-auto"
            elevation="8"
            width="1200"
            style="border-radius: 20px;"
            height="700">
            <Baranggays :unit="selectedUnit" />
        </v-sheet>
    </v-app>
</template>

<script setup>
import { ref } from 'vue';
import Baranggays from './Baranggays.vue';

const selectedUnit = ref('');
</script>
<style scoped>
.font-bold {
    background-image: linear-gradient(45deg, #3772FF 2%, #DF2935 20%, #FDCA40 35%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: bold;

}
</style>
