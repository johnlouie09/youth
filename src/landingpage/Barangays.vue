<template>
    <div class="barangays-cluster">
        <v-col v-if="loading" cols="12" class="text-center">
            <v-progress-circular indeterminate color="primary"></v-progress-circular>
        </v-col>

        <v-col v-else-if="error" cols="12" class="text-center">
            <v-alert type="error">{{ error }}</v-alert>
        </v-col>

        <v-card v-else v-for="barangay in barangays" :key="barangay.id" elevation="10" class="barangay custom-card hoverable" width="350px" height="262px" :to="barangay.name.toLowerCase().replace(/\s+/g, '-')">
            <v-card-title class="overlay-titles-barrangays">{{ barangay.name }}</v-card-title>
        </v-card>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        clusterId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            barangays: [],
            loading: false,
            error: null
        };
    },
    watch: {
        clusterId: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.fetchBarangays();
                }
            }
        }
    },
    methods: {
        async fetchBarangays() {
            try {
                this.loading = true;
                this.error = null;
                const response = await axios.get(`/api/getBarangaysByCluster.php?cluster_id=${this.clusterId}`);

                if (response.data.success) {
                    this.barangays = response.data.data;
                } else {
                    this.error = 'Failed to fetch barangays';
                }
            } catch (err) {
                this.error = 'Error connecting to the server';
                console.error('Error:', err);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>


<style scoped>
.barangays-cluster {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    align-items: center;
    gap: 4rem;
    z-index: 1001;
}

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
