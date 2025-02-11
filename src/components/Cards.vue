<script setup>
import DialogComponent from "../components/DialogComponent.vue"
</script>

<template>
    <v-sheet
        class="mx-auto"
        elevation="8"
        max-width="1200"
        style="border-radius: 20px;"
        height="300"
    >
        <v-row>
            <v-col cols="6">
                <v-card-title font-bold="font-bold">
                    SANGGUNIANG KABATAANG OFFICIALS

                </v-card-title>
                <v-card
                    class="custom-card"
                    height="200px"
                    width="200"
                    hover
                    style="margin-left: 50px;"
                    elevation="10"
                    @click="openDialog"
                >
                    <div class="card-content">
                        <v-img
                            src="public/Sangguniang_Kabataan_logo.svg"
                            class="card-image"
                            cover
                        ></v-img>
                    </div>
                </v-card>

                <!-- Dialog Component -->
                <DialogComponent ref="dialogComponent" />
                <!-- Left side content can go here -->

            </v-col>

            <v-col cols="6">


                <v-slide-group
                    v-model="model"
                    class="pa-4"
                    selected-class="bg-success"
                    show-arrows
                >
                    <v-slide-group-item
                        v-for="n in 15"
                        :key="n"
                        v-slot="{ isSelected, toggle, selectedClass }"
                    >
                        <v-card
                            class="custom-card"
                            hover
                            :class="['ma-4', selectedClass]"
                            color="grey-darken-1"
                            height="150"
                            width="200"
                            @click="toggle"
                        >
                            <div class="d-flex fill-height align-center justify-center">
                                <v-scale-transition>
                                    <v-icon
                                        v-if="isSelected"
                                        color="black"
                                        icon="mdi-close-circle-outline"
                                        size="4"
                                    ></v-icon>
                                </v-scale-transition>
                            </div>
                        </v-card>
                    </v-slide-group-item>
                </v-slide-group>
            </v-col>
        </v-row>
    </v-sheet>



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
    },
    data: () => ({
        model: null,
    }),
}
</script>

<style scoped>
@import "@/assets/cards.css";
</style>