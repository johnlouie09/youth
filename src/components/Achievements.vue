<script setup>
import DialogComponent from "../components/DialogComponent.vue"

</script>

<template>
    <v-container>
        <v-row>
            <v-col cols="12" md="4">
                <v-card class="custom-card" height="300px" hover
                elevation="10"
                        @click="openDialogs">
                    <div class="card-content">
                        <v-img
                            src="public/Sangguniang_Kabataan_logo.svg"
                            class="card-image"
                            cover
                        ></v-img>
                        <div class="card-text">
                        </div>
                    </div>
                </v-card>
            </v-col>

            <v-col cols="12" md="4">
                <v-card class="custom-card" height="300px"
                        @click="openDialogs"
                        hover
                        elevation="10">
                    <div class="card-content">
                        <v-img
                            src="public/Sangguniang_Kabataan_logo.svg"
                            class="card-image"
                            cover
                        ></v-img>
                        <div class="card-text">

                        </div>
                    </div>
                </v-card>

            </v-col>

            <v-col cols="12" md="4">
                <v-card class="custom-card" height="300px" hover
                        elevation="10"
                    @click="openDialogs">

                    <div class="card-content">
                        <v-img
                            src="public/Sangguniang_Kabataan_logo.svg"
                            class="card-image"
                            cover
                        ></v-img>
                        <div class="card-text">
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <DialogComponent ref="dialogComponent"/>

</template>


<script>
export default {
    components: {
        DialogComponent,
    },
    methods: {
        openDialog() {
            this.$refs.dialogComponent.openDialog();
        },
        openDialogs() {
            this.$refs.dialogComponent.openDialogs();
        },
    },
    data: () => ({
        model: null,
    }),
}
</script>
<style scoped>

@import "@/assets/Achievements.css";
</style>
