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
    <div class="main-navigation">
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
            <transition name="slide" mode="out-in">
                <Barangays
                    v-if="selectedCluster"
                    :cluster-id="selectedCluster.id"
                    :key="selectedCluster.id"
                />
            </transition>
        </div>
    </div>
</template>

<style scoped>
    .main-navigation {
        position: relative;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 3rem;
        padding: 5rem 15rem;
        /* Remove any box-shadow from here */
    }

    /* Left glow */
    .main-navigation::before {
        content: "";
        position: absolute;
        top: 0;        /* Adjust as needed to avoid top glow */
        bottom: 0;     /* Adjust as needed to avoid bottom glow */
        left: -100px;     /* Move outside the container a bit */
        width: 200px;     /* Make the glow wider */
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(to right, #FDCA40, transparent);
        filter: blur(75px);  /* Apply a strong blur for a soft glow */
        pointer-events: none;
    }

    /* Right glow */
    .main-navigation::after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        right: -100px;
        width: 200px;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(to left,#DF2935, transparent);
        filter: blur(75px);
        pointer-events: none;
    }

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

    .barangays {
        width: 100%;
        display: flex;
    }
</style>

