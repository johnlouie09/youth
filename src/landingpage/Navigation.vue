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

<script>
import Barangays from './Barangays.vue';
import $ from 'jquery';

export default {
    components: { Barangays },
    data() {
        return {
            clusters: [],
            selectedCluster: null,
            loading: false,
            error: null
        };
    },
    methods: {
        fetchClusters() {
            this.loading = true;
            this.error = null;

            $.ajax({
                url: '/api/getClusters.php',
                method: 'GET',
                dataType: 'json',
                success: (response) => {
                    if (response.success) {
                        this.clusters = response.data;
                        // Set default selected cluster to first cluster
                        if (this.clusters.length > 0 && !this.selectedCluster) {
                            this.selectedCluster = this.clusters[0];
                        }
                    } else {
                        this.error = 'Failed to fetch clusters';
                    }
                },
                error: () => {
                    this.error = 'Error connecting to the server';
                },
                complete: () => {
                    this.loading = false;
                }
            });
        },
        changeCluster(cluster) {
            this.selectedCluster = cluster;
        }
    },
    mounted() {
        this.fetchClusters();
    }
};
</script>