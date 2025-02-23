<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Barangays from './Barangays.vue';

const clusters = ref([]);
const selectedCluster = ref(null);
const loading = ref(false);
const error = ref(null);

const fetchClusters = async () => {
    try {
        loading.value = true;
        error.value = null;
        const response = await axios.get('/api/getClusters.php');

        if (response.data.success) {
            clusters.value = response.data.data;
            // Set default selected cluster to first cluster
            if (clusters.value.length > 0 && !selectedCluster.value) {
                selectedCluster.value = clusters.value[0];
            }
        } else {
            error.value = 'Failed to fetch clusters';
        }
    } catch (err) {
        error.value = 'Error connecting to the server';
        console.error('Error:', err);
    } finally {
        loading.value = false;
    }
};

const changeCluster = (cluster) => {
    selectedCluster.value = cluster;
};

onMounted(() => {
    fetchClusters();
});
</script>

<template>
    <v-app>
        <v-container>
            <v-navigation grow class="d-flex justify-center">
                <template v-if="loading">
                    <v-progress-circular indeterminate color="primary"></v-progress-circular>
                </template>

                <template v-else-if="error">
                    <v-alert type="error">{{ error }}</v-alert>
                </template>

                <template v-else>
                    <v-btn
                            v-for="cluster in clusters"
                            :key="cluster.id"
                            @click="changeCluster(cluster)"
                            :class="{ 'active-btn': selectedCluster?.id === cluster.id, 'custom-btn': true }"
                            class="mx-2"
                    >
                        <span class="overlay-titles">{{ cluster.name }}</span>
                    </v-btn>
                </template>
            </v-navigation>
        </v-container>

        <v-sheet class="mx-auto" width="1200" style="border-radius: 20px;" height="700">
            <!-- Apply transition -->
            <transition name="slide" mode="out-in">
                <Barangays
                v-if="selectedCluster"
                style="padding: 50px;"
                :cluster-id="selectedCluster.id"
                :key="selectedCluster.id"
                />
            </transition>
        </v-sheet>
    </v-app>
</template>
