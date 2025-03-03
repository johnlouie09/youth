<script setup>
import { ref } from 'vue';
const dialog = ref(false);
const education = ref({
    school: '',
    img: null,
    detail: '',
    year: {start: 1999, end: null},
});

const currentYear = new Date().getFullYear();
const years = Array.from({ length: 50 }, (_, i) => (currentYear - i).toString());

const submitForm = () => {
    console.log("Submitted Data:", education.value);
    dialog.value = false; // Close dialog after submission
};
</script>



<template>
    <v-container>
        <v-btn class="add-ebg-button" @click="dialog = true" >
            <v-icon>mdi-plus-circle-outline</v-icon>
            <span class="ml-4">ADD NEW EDUCATIONAL BACKGROUND</span>
        </v-btn>

        <v-dialog max-width="700px" class="dialog-padding" v-model="dialog">
            <v-card>
                <v-card-title class="text-h5 d-flex justify-center">
                    NEW EDUCATIONAL BACKGROUND
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-text-field v-model="education.school" label="School Name" required></v-text-field>

                        <v-file-input v-model="education.img" label="Upload School Logo" accept="image/*"></v-file-input>

                        <v-text-field v-model="education.detail" label="Degree" required></v-text-field>

                        <v-row>
                            <v-col>
                                <v-select v-model="education.year.start" :items="years" label="Start Year" required></v-select>
                            </v-col>
                            <v-col>
                                <v-select v-model="education.year.end" :items="years" label="End Year" required></v-select>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="grey" @click="dialog = false">Cancel</v-btn>
                    <v-btn color="primary" @click="submitForm">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>



<style scoped>
.v-dialog {
    backdrop-filter: blur(5px);
}

.dialog-padding .v-card {
    padding: 2rem;
    border-radius: 1rem;
}

.add-ebg-button {
    border-radius: .5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1.5rem;
    align-items: center;
    margin: auto;
    font-size: .7rem;
}
</style>
