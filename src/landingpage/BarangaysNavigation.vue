<script>
import axios from 'axios';
import Barangays from './Barangays.vue';

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
            try {
                this.loading = true;
                this.error = null;
                const response = await axios.get('/api/getClusters.php');

                if (response.data.success) {
                    this.clusters = response.data.data;
                    if (this.clusters.length > 0 && !this.selectedCluster) {
                        this.selectedCluster = this.clusters[0];
                    }
                } else {
                    this.error = 'Failed to fetch clusters';
                }
            } catch (err) {
                this.error = 'Error connecting to the server';
                console.error('Error:', err);
            } finally {
                this.loading = false;
            }
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
    <v-container class="main-navigation elevation-15">
        <v-navigation class="barangay-navigation">
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
                    class="cluster-btn"
                >
                    <span class="overlay-titles">{{ cluster.name }}</span>
                </v-btn>
            </template>
        </v-navigation>
    
        <div class="barangays">
            <transition name="smooth" mode="out-in">
                <Barangays
                    v-if="selectedCluster"
                    :cluster-id="selectedCluster.id"
                    :key="selectedCluster.id"
                />
            </transition>
        </div>
    </v-container>
</template>

<style scoped>
.main-navigation {
    width: 90%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 4rem;
    padding: 4rem 5rem;
    border-radius: 2.5rem;
}
    



/* Left glow */
/* .main-navigation::before {
    content: "";
    position: absolute;
    top: 0;     
    bottom: 0;   
    left: -100px;     
    width: 200px;     
    height: 100%;
    border-radius: 50%;
    pointer-events: none;
} */

/* Right glow */
/* .main-navigation::after {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    right: -100px;
    width: 200px;
    height: 100%;
    border-radius: 50%;
    background: linear-gradient(to left, #DF2935, transparent);
    filter: blur(75px);
    pointer-events: none;
    z-index: 1090;
} */


.barangay-navigation {
    width: 80%;
    display: flex;
    justify-content: space-around;
}

.barangay-navigation .cluster-btn {
    font-size: 1rem;
    padding: 1rem 1.5rem;
    height: auto;
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
