<template>

        <v-container>
            <v-navigation grow class="d-flex justify-center">
                <v-btn
                    v-for="unit in units"
                    :key="unit"
                    @click="changeUnit(unit)"
                    :class="{ 'active-btn': selectedUnit === unit, 'custom-btn': true }"
                    class="mx-2"
                >
                    <span class="overlay-titles">{{ unit }}</span>
                </v-btn>
            </v-navigation>
        </v-container>

        <v-sheet class="mx-auto" width="1200" style="border-radius: 20px;" height="700">
            <!-- Apply transition -->
            <transition name="slide" mode="out-in">
                <Baranggays style="padding: 50px;" :unit="selectedUnit" :key="selectedUnit" />
            </transition>
        </v-sheet>

</template>

<script setup>
import { ref } from 'vue';
import Baranggays from './Baranggays.vue';

const units = ref([
    'Poblacion',
    'Mountain Unit',
    'National Road Unit',
    'East Road Unit',
    'River Unit'
]);

const selectedUnit = ref('Poblacion'); // Set a default unit

const changeUnit = (unit) => {
    selectedUnit.value = unit;
};
</script>

<style scoped>

</style>
