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
            class="barangay custom-card hoverable"
            width="350px"
            height="250px"
            :style="{
                'background-image': `url(/public/barangayHall/${barangay.img})`,
                'background-size': 'cover',
                'background-position': 'center'
            }"
        >
        <v-card-title class="overlay-titles-barangays" style="font-weight: 900; font-size: 1rem;">{{ barangay.name.toUpperCase() }}</v-card-title>
        </v-card>
    </div>
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
            this.loading = true;
            const api_base = 'http://localhost/youth/app/api.php';
            await $.ajax({
                url: `${api_base}?e=cluster&a=fetchBarangays`,
                type: 'POST',
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    barangayId: this.clusterId
                },
                success: (data) => {
                    this.barangays = data.data.barangays;
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error:", textStatus, errorThrown);
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
    display: flex;
    justify-content: center;
    align-items: flex-end;
    padding-bottom: .5rem;
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
