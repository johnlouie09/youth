<script setup>
import { ref, watchEffect } from 'vue';
import axios from 'axios';

const props = defineProps({
    clusterId: {
        type: Number,
        required: true
    }
});

const barangays = ref([]);
const loading = ref(false);
const error = ref(null);

const fetchBarangays = async () => {
    try {
        loading.value = true;
        error.value = null;
        const response = await axios.get(`/api/getBarangaysByCluster.php?cluster_id=${props.clusterId}`);

        if (response.data.success) {
            barangays.value = response.data.data;
        } else {
            error.value = 'Failed to fetch barangays';
        }
    } catch (err) {
        error.value = 'Error connecting to the server';
        console.error('Error:', err);
    } finally {
        loading.value = false;
    }
};

watchEffect(() => {
    if (props.clusterId) {
        fetchBarangays();
    }
});
</script>

<template>
    <v-row>
        <v-col v-if="loading" cols="12" class="text-center">
            <v-progress-circular indeterminate color="primary"></v-progress-circular>
        </v-col>

        <v-col v-else-if="error" cols="12" class="text-center">
            <v-alert type="error">{{ error }}</v-alert>
        </v-col>

        <template v-else>
            <v-col v-for="barangay in barangays" :key="barangay.id" cols="12" md="4">
                <router-link
                        :to="barangay.name.toLowerCase().replace(/\s+/g, '-')"
                        class="d-block"
                >
                    <v-card elevation="10" class="custom-card ma-2 hoverable" :max-width="350" height="200px">
                        <v-card-title class="overlay-titles-barrangays">{{ barangay.name }}</v-card-title>
                    </v-card>
                </router-link>
            </v-col>
        </template>
    </v-row>
</template>

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
</style>
