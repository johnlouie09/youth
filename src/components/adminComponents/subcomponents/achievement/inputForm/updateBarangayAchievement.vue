<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  year: String,
  month: String,
  barangayAchievement: Object
});

const dialog = ref(true);
const initialBarangayAchievement = ref({
    img: props.barangayAchievement.img,
    title: props.barangayAchievement.title,
    subtitle: props.barangayAchievement.subtitle,
    info: props.barangayAchievement.info,
});

// Reactive state for form
const barangayAchievement = ref(JSON.parse(JSON.stringify(initialBarangayAchievement.value)));
const hasChanges = ref(false);

// Save changes and update initial values
const saveChanges = () => {
    Object.assign(initialBarangayAchievement, { ...barangayAchievement.value });
    hasChanges.value = false;
    emit('close');
};

// Watch for changes to enable the Save/Discard buttons
watch(barangayAchievement, (newVal) => {
    hasChanges.value = JSON.stringify(newVal) !== JSON.stringify(initialBarangayAchievement);
}, { deep: true });

// Discard changes and reset form
const discardChanges = () => {
    barangayAchievement.value = JSON.parse(JSON.stringify(initialBarangayAchievement.value));
    hasChanges.value = false;
};


const emit = defineEmits(['close']); // Define an event for closing
const closeForm = () => {
    emit('close'); // Emit event when closing
};

</script>

<template>
    <v-container>
        <v-btn class="add-ebg-button" @click="dialog = true">
            <v-icon>mdi-plus-circle-outline</v-icon>
            <span class="ml-4">ADD NEW BARANGAY ACHIEVEMENT</span>
        </v-btn>

        <v-dialog max-width="700px" class="dialog-padding" v-model="dialog" persistent>
            <v-card>
                <v-card-title class="text-h5 d-flex justify-center">
                    EDIT BARANGAY ACHIEVEMENT
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-card elevation="5" class="form-container">
                            <label class="image-upload" @click="$refs.fileInput.click()">
                                <input type="file" ref="fileInput" accept="image/*" @change="handleImageUpload" hidden>
                                <img :src="barangayAchievement.img" alt="Uploaded Image">
                            </label>

                            <article>
                                <v-text-field 
                                    v-model="barangayAchievement.title" 
                                    label="Barangay Achievement Title" 
                                    required>
                                </v-text-field>
                                <v-text-field 
                                    v-model="barangayAchievement.subtitle" 
                                    label="Barangay Achievement Subtitle" 
                                    required>
                                </v-text-field>
                                <v-textarea v-model="barangayAchievement.info" label="Info">
                                </v-textarea>
                            </article>
                            <v-btn color="error" class="ma-auto" @click="closeForm" width="30%">Cancel</v-btn>

                        </v-card>
                    </v-form>


                    <!-- Action Buttons -->
                    <v-card-actions v-if="hasChanges" class="actions">
                        <v-btn color="grey" @click="discardChanges">Discard Changes</v-btn>
                        <v-btn color="primary" @click="saveChanges">Save Changes</v-btn>
                    </v-card-actions>
                </v-card-text>
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
    max-height: 100vh;
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

.form-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.image-upload {
    width: 80%;
    border: 2px dashed #ccc;
    border-radius: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    overflow: hidden;
    position: relative;
    margin: auto;
}

.image-upload img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

.upload-icon {
    font-size: 50px;
    color: #aaa;
}

/* Buttons */
.actions {
    display: flex;
    justify-content: space-evenly;
    width: 100%;
    margin-top: 1rem;
}
</style>
