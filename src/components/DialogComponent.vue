<template>
    <v-dialog v-model="isDialogOpen" max-width="900px">
        <v-card style="border-radius: 20px;" border="warning lg">
            <v-card-title class="d-flex align-center">
                <v-avatar size="200">
                    <img src="/public/Sangguniang_Kabataan_logo.svg" alt="Profile Picture">
                </v-avatar>
                <div class="ml-3 text-wrap">
                    <span class="headline font-weight-bold">SK.CHAIRPERSON</span>
                    <br>
                    <v-subtitle-1 class="d-block text-grey motto-text">
                        "Dawa turog gisngon"
                    </v-subtitle-1>
                </div>
            </v-card-title>
            <v-divider class="mt-3"></v-divider>

            <!-- Scrollable content starts here -->
            <v-card-text style="max-height: 400px; overflow-y: auto;">
                <div class="d-flex justify-center mb-6">
                    <v-sheet width="800" elevation="10" style="border-radius: 20px; overflow: auto; text-align: center; padding: 16px;">
                        <v-card-title class="text-center">
                            <v-icon class="mr-2">mdi-account</v-icon>Profile Information
                        </v-card-title>
                        <v-divider class="border-opacity-25 my-3" color="info"></v-divider>
                        <v-container>
                            <v-row justify="center" align="center">
                                <!-- Left column -->
                                <v-col cols="6" class="text-left">
                                    <p><strong>Name:</strong> Juan Dela Cruz</p>
                                    <p><strong>Email:</strong> juandelacruz@example.com</p>
                                </v-col>
                                <!-- Right column -->
                                <v-col cols="4" class="text-left">
                                    <p><strong>SK Position:</strong> Chairperson</p>
                                    <p><strong>Birthday:</strong> January 1, 2000</p>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-sheet>
                </div>

                <div class="d-flex justify-center mb-6">
                    <v-sheet width="600" elevation="10">
                        <v-card-title style="text-align: center">
                            <v-icon class="mr-2">mdi-school</v-icon>Educational Background
                        </v-card-title> <v-divider class="border-opacity-25" color="info"></v-divider>
                        <v-card-text class="bg-surface">
                            <p>ILABYUUUUUUUUUU.</p>
                        </v-card-text>
                    </v-sheet>
                </div>

                <div class="d-flex justify-center mb-6">
                    <v-sheet width="600" elevation="10">
                        <v-card-title style="text-align: center">
                            <v-icon class="mr-2">mdi-trophy</v-icon>Personal Achievements
                        </v-card-title> <v-divider class="border-opacity-25" color="info"></v-divider>
                        <v-card-text class="bg-surface">
                            <p>ILABYUUUUUUUUUU.</p>
                            
                        </v-card-text>
                    </v-sheet>
                </div>

                <div class="d-flex justify-center mb-6">
                    <v-sheet width="600" elevation="10">
                        <v-card-title style="text-align: center">
                            <v-icon class="mr-2">mdi-plus-box</v-icon>Other Information
                        </v-card-title> <v-divider class="border-opacity-25" color="info"></v-divider>
                        <v-card-text class="bg-surface">
                            <p>ILABYUUUUUUUUUU.</p>
                        </v-card-text>
                    </v-sheet>
                </div>
            </v-card-text>
            <!-- Scrollable content ends here -->

            <v-card-actions>
                <v-btn color="blue" text @click="closeDialog">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script>
export default {
    data() {
        return {
            isDialogOpen: false,
            isDialogsOpen: false,
        };
    },
    methods: {
        openDialog() {
            this.isDialogOpen = true;
        },
        openDialogs() {
            this.isDialogsOpen = true;
        },
        closeDialog() {
            this.isDialogOpen = false;
        },
        closeDialogs() {
            this.isDialogsOpen = false;
        },
    },
};
</script>
<style scoped>

</style>

