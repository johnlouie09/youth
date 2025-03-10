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
<script>
import $ from 'jquery';

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
            handler(newClusterId) {
                if (newClusterId) {
                    this.fetchBarangays();
                }
            }
        }
    },
    methods: {
        fetchBarangays() {
            this.loading = true;
            this.error = null;

            $.ajax({
                url: `/api/getBarangaysByCluster.php?cluster_id=${this.clusterId}`,
                method: 'GET',
                dataType: 'json',
                success: (response) => {
                    if (response.success) {
                        this.barangays = response.data;
                    } else {
                        this.error = 'Failed to fetch barangays';
                    }
                },
                error: () => {
                    this.error = 'Error connecting to the server';
                },
                complete: () => {
                    this.loading = false;
                }
            });
        }
    }
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
</style>