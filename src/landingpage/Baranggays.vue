<template>
    <v-row>
        <v-col v-for="(barangay, index) in barangays" :key="index" cols="12" md="4">
            <!-- Only show router-link for 'perpetual' -->
            <router-link
                v-if="barangay.name === 'perpetual'"
                :to="{ name: 'perpetual' }"
                class="d-block"
            >

                <v-card
                    class="custom-card ma-2 hoverable"
                    :max-width="350"
                    height="200px"
                >
                    <v-card-title class="overlay-titles">{{ barangay.name }}</v-card-title>

                </v-card>
            </router-link>

            <router-link
                v-if="barangay.name === 'San Francisco'"
                :to="{ name: 'San Francisco' }"
                class="d-block"
            >

                <v-card
                    class="custom-card ma-2 hoverable custom-card"
                    :max-width="350"
                    height="200px"
                >
                    <v-card-title class="overlay-titles">{{ barangay.name }}</v-card-title>

                </v-card>
            </router-link>

        </v-col>
    </v-row>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    unit: {
        type: String,
        required: true
    }
});

const barangays = computed(() => {
    if (props.unit === 'Mountain Unit') {
        return [
            { name: 'perpetual', unit: 'Mountain Unit' }
        ];
    } else if (props.unit === 'National Road Unit') {
        return [
            { name: 'Barangay 1', unit: 'National Road' }
        ];
    } else if (props.unit === 'East Road Unit') {
        return [
            { name: 'Barangay 1', unit: 'East Road' }
        ];
    } else if (props.unit === 'River Unit') {
        return [
            { name: 'Barangay 1', unit: 'River Unit' }
        ];
    } else if (props.unit === 'Poblacion') {
        return [
            { name: 'San Francisco', unit: 'Poblacion' } // Corrected spelling
        ];
    }
    return [];
});
</script>

<style scoped>
.custom-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.custom-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.hoverable {
    cursor: pointer;
}

.v-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>
