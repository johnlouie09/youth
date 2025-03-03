<script setup>
import { ref, computed } from 'vue';
import { VDateInput } from 'vuetify/lib/labs/components.mjs';

const dialog = ref(false);
const achievement = ref({
    title: '',
    date: null // Stores YYYY-MM
});


const submitForm = () => {
    console.log("Submitted Data:", achievement.value);
    dialog.value = false; // Close dialog after submission
};
</script>

<template>
    <v-container>
        <v-btn class="add-ebg-button" @click="dialog = true">
            <v-icon>mdi-plus-circle-outline</v-icon>
            <span class="ml-4">ADD NEW PERSONAL ACHIEVEMENT</span>
        </v-btn>

        <v-dialog max-width="700px" class="dialog-padding" v-model="dialog">
            <v-card>
                <v-card-title class="text-h5 d-flex justify-center">
                    NEW PERSONAL ACHIEVEMENT
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-text-field 
                            v-model="achievement.title" 
                            label="Achievement Title" 
                            required>
                        </v-text-field>

                        <!-- Month & Year Picker -->
                        <v-date-input
                            v-model="achievement.date"
                            label="Select a date"
                            prepend-icon=""
                            prepend-inner-icon="$calendar"
                            variant="solo"
                        />
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
    margin: auto;
    font-size: .7rem;
}
</style>
