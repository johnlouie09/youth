
<template>
    <v-container>
        <v-row>
            <v-col cols="12" md="4">
                <v-card class="custom-card" height="300px" hover
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
                <div class="text-center text-caption">Using Props Only</div>
            </v-col>

            <v-col cols="12" md="4">
                <v-card class="custom-card" height="300px" hover
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
                <div class="text-center text-caption">Using Slots Only</div>
            </v-col>

            <v-col cols="12" md="4">
                <v-card class="custom-card" height="300px" hover
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
                <div class="text-center text-caption">Using Markup Only</div>
            </v-col>
        </v-row>
    </v-container>

</template>

<script setup>
</script>

<style scoped>

@import "@/assets/Achievements.css";
</style>
