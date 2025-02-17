<script setup>
import { ref } from 'vue';
import DialogComponent from './DialogComponent.vue';

const dialogComponent = ref(null);

const openDialog = () => {
    dialogComponent.value.openDialog();


};

const model = ref(null);
const skPositions = ref([
    "SK Secretary",
    "SK Treasurer",
    "SK Kagawad 1",
    "SK Kagawad 2",
    "SK Kagawad 3",
    "SK Kagawad 4",
    "SK Kagawad 5",
    "SK Kagawad 6",
    "SK Kagawad 7",
    "SK Kagawad 8"

]);

</script>

<template>
    <v-sheet
        class="mx-auto bg-"
        elevation="8"
        max-width="1200"
        style="border-radius: 20px;"
        height="300"
    >
        <v-card-title class="font-bold" font-bold="font-bold">
            SANGGUNIANG KABATAAN OFFICIALS

        </v-card-title>
        <v-row>
            <!-- SK Chairperson -->
            <v-col cols="4">
                <v-card
                    class="custom-card"
                    height="200px"
                    width="200"
                    hover
                    style="margin-left: 50px; position: relative; overflow: hidden;"
                    elevation="10"
                    @click="openDialog"
                >
                    <v-img
                        src="/Sangguniang_Kabataan_logo.svg"
                        class="card-image"
                        cover
                        height="70%"
                        width="70%"
                        style="object-fit: cover;"
                    ></v-img>

                    <div class="overlay-title">
                        SK CHAIRPERSON
                    </div>
                </v-card>

                <DialogComponent ref="dialogComponent" />
            </v-col>

            <!-- SK Members Slider -->
            <v-col cols="6">
                <v-slide-group
                    v-model="model"
                    class="pa-4"
                    selected-class="bg-success"
                    show-arrows
                    style="width: 820px; margin-top: 1px;"
                >
                    <v-slide-group-item
                        v-for="(position, index) in skPositions"
                        :key="index"
                        v-slot="{ isSelected, toggle, selectedClass }"
                    >

                        <v-card
                            class="custom-card"
                            hover
                            :class="['ma-4', selectedClass]"
                            elevation="10"
                            height="150"
                            width="200"
                            @click="openDialog"
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
                                <div class="overlay-title">
                                    {{ position }}
                                </div>
                            </div>

                        </v-card>
                    </v-slide-group-item>
                </v-slide-group>
            </v-col>
        </v-row>
    </v-sheet>

    <DialogComponent ref="dialogComponent"/>

</template>


<style scoped>
@import "@/assets/cards.css";
@import "@/assets/fontEffects.css";
.font-bold {
    background-image: linear-gradient(45deg, #3772FF 2%, #DF2935 20%, #FDCA40 35%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
font-weight: bold;

}


</style>