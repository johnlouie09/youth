<template>
    <v-container class="barangays-cluster">
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
            class="barangay custom-card hoverable"
            width="350px"
            height="250px"
            :style="barangay.img ? {
                'background-image': `url(${this.$store.getters.base}/barangayHall/${barangay.img.toLowerCase()}?v=1)`,
                'background-size': 'cover',
                'background-position': 'center'
            } : {}"
            @click = "toBarangay(barangay)"
        >
            <v-card-title class="overlay-titles-barangays" style="font-weight: 900; font-size: 1rem;">
                {{ barangay.name.toUpperCase() }}
            </v-card-title>
        </v-card>
    </v-container>
</template>

<script>
import $ from 'jquery'


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
            error: null,
            activeBarangay: ''
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
            this.loading = true;
            await $.ajax({
                url: `${this.$store.getters['api_base']}?e=cluster&a=fetchBarangays`,
                type: 'POST',
                xhrFields: {
                    withCredentials: true
                },
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                data: {
                    barangayId: this.clusterId
                },
                success: (data) => {
                    this.barangays = data.data.barangays;
                    console.log("Barangays Data:", this.barangays); // Debug the data
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error:", textStatus, errorThrown);
                    this.error = "Failed to fetch barangays. Please try again.";
                },
                complete: () => {
                    this.loading = false;
                }
            });
        },
        toBarangay(barangay) {
            this.$router.replace({
                name: 'barangay-landingpage',
                params: { 
                barangaySlug: barangay.slug
                }
            });
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
    border-radius: 1.25rem;
    transition: transform 0.3s ease-in-out;
    opacity: .6;
    color: white;
    display: flex;
    justify-content: center;
    align-items: flex-end;
    padding-bottom: .5rem;
    overflow: hidden;
    background-color: #f0f0f0;
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
