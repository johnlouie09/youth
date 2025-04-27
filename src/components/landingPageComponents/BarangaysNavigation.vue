<script>
import $ from 'jquery'
import Barangays from './subcomponents/Barangays.vue';
import '../../assets/Achievements.css'

export default {
    components: {
        Barangays
    },
    data() {
        return {
            clusters: [],
            selectedCluster: null,
            loading: false,
            error: null
        };
    },
    methods: {
        async fetchClusters() {
            this.loading = true;
            const api_base = '/app/api.php';
            await $.ajax({
                url: `${api_base}?e=cluster&a=fetchClusters`,
                type: 'GET',
                xhrFields: {
                    withCredentials: true
                },
                success: (data) => {
                    this.clusters = data.data.clusters;
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error:", textStatus, errorThrown);
                },
                complete: () => {
                    this.loading = false;
                    // Set the first cluster as default if available
                    if (this.clusters) {
                    this.selectedCluster = this.clusters[0];
                    }
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

<template>
    <v-container class="main-navigation elevation-15 ">
        <v-sheet class="d-flex ga-12 bg-transparent flex-wrap justify-center" :loading="loading">
                <v-btn
                    v-for="cluster in clusters"
                    :key="cluster.id"
                    @click="changeCluster(cluster)"
                    :class="{ 'active-btn': selectedCluster?.id === cluster.id, 'custom-btn': true }"
                    class="custom-btn text-lg font-bolder pa-5 px-10 h-auto"
                    :loading="loading"
                >
                    <span class="overlay-titles">{{ cluster.name }}</span>
                </v-btn>
        </v-sheet>
    
        <v-container class="barangays">
            <transition name="smooth" mode="out-in">
                <Barangays
                    v-if="selectedCluster"
                    :cluster-id="selectedCluster.id"
                    :key="selectedCluster.id"
                />
            </transition>
        </v-container>
    </v-container>
</template>

<style scoped>
.main-navigation {
    width: 90%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    padding: 3rem 5rem;
    border-radius: 2.5rem;
}

/* Smooth transition for Barangays component */
.smooth-enter-active,
.smooth-leave-active {
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.smooth-enter {
    opacity: 0;
    transform: scale(0.95);
}
.smooth-leave-to {
    opacity: 0;
    transform: scale(1.2);
}
</style>
