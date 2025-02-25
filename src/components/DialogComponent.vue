<script setup>
import { ref, defineExpose } from 'vue';

const isDialogOpen = ref(false);
const openDialog = () => {
    isDialogOpen.value = true;
};
const closeDialog = () => {
    isDialogOpen.value = false;
};

defineExpose({
    openDialog
});

const profileData = ref([
    { title: 'Hobbies', items: ['Playing Basketball', 'Writing Poem'] },
    { title: 'Favorite Show', items: ['The Crown'] },
    { title: 'Favorite Book', items: ['No Longer Human'] },
    { title: 'Inspirational Figure', items: ['iShowSpeed'] }
]);
</script>
<template>
    <v-dialog v-model="isDialogOpen" max-width="900px">
        <v-card style="border-radius: 20px;" border="primary lg">
            <v-card-title class="d-flex align-center">
                <v-avatar size="200">
                    <img src="/Sangguniang_Kabataan_logo.svg" alt="Profile Picture">
                </v-avatar>
                <div class="ml-3 text-wrap">
                    <span class="headline font-weight-bold">SK.CHAIRPERSON</span>
                    <br>
                    <v-card-title class="d-block text-grey motto-text">
                        "Dawa turog gisngon"
                    </v-card-title>
                </div>
            </v-card-title>
            <v-divider class="mt-3"></v-divider>

            <v-card-text style="max-height: 400px; overflow-y: auto;">
                <div class="d-flex justify-center mb-6">
                    <v-sheet width="800" elevation="10" style="border-radius: 20px; overflow: auto; text-align: center; padding: 16px;">
                        <v-card-title class="text-center">
                            <v-icon class="mr-2">mdi-account</v-icon>PROFILE INFORMATION
                        </v-card-title>
                        <v-divider class="border-opacity-25 my-3" color="info"></v-divider>
                        <v-container>
                            <v-row justify="center" align="center">
                                <v-col cols="6" class="text-left">
                                    <p><strong>Name:</strong> Juan Dela Cruz</p>
                                    <p><strong>Email:</strong> juandelacruz@example.com</p>
                                </v-col>
                                <v-col cols="4" class="text-left">
                                    <p><strong>SK Position:</strong> Chairperson</p>
                                    <p><strong>Birthday:</strong> January 1, 2000</p>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-sheet>
                </div>

                <div class="d-flex justify-center mb-6">
                    <v-sheet width="800" elevation="10" style="border-radius: 20px; overflow: auto; text-align: start; padding: 16px;">
                        <v-card-title style="text-align: center">
                            <v-icon class="mr-2">mdi-school</v-icon>EDUCATIONAL BACKGROUNDS
                        </v-card-title>
                        <v-divider class="border-opacity-25" color="info"></v-divider>
                        <v-card-text class="bg-surface">
                            <v-timeline side="end">
                                <v-timeline-item color="primary" small>
                                    <v-card>
                                        <v-card-title>2020-2024</v-card-title>
                                        <v-card-subtitle>Ateneo de Naga University</v-card-subtitle>
                                        <v-card-text>Bachelor of Public Administration (BPA)</v-card-text>
                                    </v-card>
                                </v-timeline-item>
                                <v-timeline-item color="primary" small>
                                    <v-card>
                                        <v-card-title>2018-2020</v-card-title>
                                        <v-card-subtitle>Ateneo de Naga University Senior High School</v-card-subtitle>
                                        <v-card-text>Strand: STEM (Science, Technology, Engineering, and Mathematics)</v-card-text>
                                    </v-card>
                                </v-timeline-item>
                                <v-timeline-item color="primary" small>
                                    <v-card>
                                        <v-card-title>2014-2018</v-card-title>
                                        <v-card-subtitle>Naga City Science High School</v-card-subtitle>
                                    </v-card>
                                </v-timeline-item>
                                <v-timeline-item color="primary" small>
                                    <v-card>
                                        <v-card-title>2008-2014</v-card-title>
                                        <v-card-subtitle>Ateneo de Naga University Grade School</v-card-subtitle>
                                    </v-card>
                                </v-timeline-item>

                            </v-timeline>
                        </v-card-text>
                    </v-sheet>
                </div>
                <div class="d-flex justify-center mb-6">
                    <v-sheet width="800" elevation="10" style="border-radius: 20px; overflow: auto; text-align: start; padding: 16px;">
                        <v-card-title class="text-center d-flex align-start justify-center">
                            <v-icon class="mr-2">mdi-trophy</v-icon>PERSONAL ACHIEVEMENTS
                        </v-card-title>
                        <v-divider class="border-opacity-25 my-3" color="info"></v-divider>
                        <v-container>
                            <v-list dense>
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title class="font-weight-bold">
                                            Certificate of Completion: SK Mandatory Training
                                        </v-list-item-title>
                                        <v-list-item-subtitle>July 15, 2023</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title class="font-weight-bold">
                                            Certificate of Recognition: Successful Organization of the Barangay Youth Sports Festival
                                        </v-list-item-title>
                                        <v-list-item-subtitle>November 25, 2023</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title class="font-weight-bold">
                                            Certificate of Participation: Leadership and Governance Workshop
                                        </v-list-item-title>
                                        <v-list-item-subtitle>September 10, 2023</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>

                            </v-list>
                        </v-container>
                    </v-sheet>
                </div>
                <div class="d-flex justify-center mb-6">
                    <v-sheet width="800" elevation="10" class="profile-sheet">
                        <v-card-title class="text-center">
                            <v-icon class="mr-2">mdi-plus-box</v-icon>OTHER INFORMATIONS
                        </v-card-title>
                        <v-divider class="border-opacity-25 my-3" color="info"></v-divider>
                        <v-container>
                            <section v-for="(category, index) in profileData" :key="index" class="mb-4">
                                <h3 class="font-weight-bold">{{ category.title }}</h3>
                                <v-divider class="my-2" color="grey darken-1"></v-divider>
                                <ul class="list-none pa-0">
                                    <li v-for="(item, i) in category.items" :key="i" class="d-flex align-center">
                                        <v-icon size="12" class="mr-2">mdi-circle-small</v-icon>
                                        {{ item }}
                                    </li>
                                </ul>
                            </section>
                        </v-container>
                    </v-sheet>
                </div>

            </v-card-text>
            <v-card-actions>
                <v-btn color="blue" @click="closeDialog">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style scoped>

</style>


