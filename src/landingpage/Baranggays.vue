<template>
    <v-row>
        <v-col v-for="(barangay, index) in barangays" :key="index" cols="12" md="4">
            <router-link
                v-if="barangay.name"
                :to="'/' + formatUnit(props.unit) + '/' + formatBarangay(barangay.name)"
                class="d-block"
            >
                <v-card elevation="10" class="custom-card ma-2 hoverable" :max-width="350" height="200px">
                    <v-card-title class="overlay-titles-barrangays">{{ barangay.name }}</v-card-title>
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
    const unitsData = {
        'Mountain Unit': [
            { name: 'Perpetual' },
            { name: 'Summit Heights' }
        ],
        'National Road Unit': [
            { name: 'Barangay 1' }
        ],
        'East Road Unit': [
            { name: 'Barangay 1' }
        ],
        'River Unit': [
            { name: 'Barangay 1' }
        ],
        'Poblacion': [
            { name: 'San Francisco' },
            { name: 'San Francisco' },
            { name: 'San Francisco' }

        ]
    };

    return unitsData[props.unit] || [];
});
const formatUnit = (unit) => {
    return unit.toLowerCase().replace(/\s+/g, '-'); // "Mountain Unit" → "mountain-unit"
};

const formatBarangay = (barangay) => {
    return barangay.toLowerCase().replace(/\s+/g, '-'); // "San Francisco" → "san-francisco"
};

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
