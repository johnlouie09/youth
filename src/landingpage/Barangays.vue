<template>
    <div class="barangays-cluster">
        <v-col v-if="loading" cols="12" class="text-center">
            <v-progress-circular indeterminate color="primary"></v-progress-circular>
        </v-col>

        <v-col v-else-if="error" cols="12" class="text-center">
            <v-alert type="error">{{ error }}</v-alert>
        </v-col>

        <v-card
            v-else
            v-for="barangay in barangays"
            :key="barangay.id"
            elevation="10"
            class="barangay hoverable"
            width="350px"
            height="250px"
            :to="barangay.name.toLowerCase().replace(/\s+/g, '-')"
            :style="{
                'background-image': `url(/public/barangayHall/${barangay.img})`,
                'background-size': 'cover',
                'background-position': 'center'
            }"
        >
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
    min-height: 40vh;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    align-items: center;
    gap: 4rem;

}

/* Add transition for smooth scaling */
.barangay {
    border-radius: 1rem;
    transition: transform 0.3s ease-in-out;
    opacity: .8;
    color: white;
}

/* Corrected hover effect using transform */
.barangay:hover {
    transform: scale(1.1);
    opacity: 1;
}

.hoverable {
    cursor: pointer;
}
</style>
