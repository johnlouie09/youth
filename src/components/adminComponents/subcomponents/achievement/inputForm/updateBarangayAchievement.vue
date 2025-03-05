<script setup>
import { ref, watch } from 'vue';

import axios from 'axios';

const props = defineProps({
  year: String,
  month: String,
  barangayAchievement: Object
});

const dialog = ref(true);
const initialBarangayAchievement = ref({
    id: props.barangayAchievement.id,  // Ensure id is included
    img: props.barangayAchievement.img,
    title: props.barangayAchievement.title,
    subtitle: props.barangayAchievement.subtitle,
    info: props.barangayAchievement.info,
    date: props.barangayAchievement.date
});

// Reactive state for form
const barangayAchievementUpdate = ref(JSON.parse(JSON.stringify(initialBarangayAchievement.value)));
const hasChanges = ref(false);

// Save changes and update initial values
const updateAchievement = async (achievement) => {
    try {
        const response = await axios.put('http://localhost/youth/app/api/BarangayAchievement.php', {
            id: achievement.id,
            title: achievement.title,
            subtitle: achievement.subtitle,
            info: achievement.info,
            img: achievement.img,  // Ensure this is a valid image URL or Base64 string
            date: achievement.date
        });

        if (response.data.success) {
            console.log('Achievement updated successfully:', response.data.message);
        } else {
            console.error('Update failed:', response.data.error);
        }
    } catch (error) {
        console.error('Error updating achievement:', error);
    }

    emit('close');
};


// Watch for changes to enable the Save/Discard buttons
watch(barangayAchievementUpdate, (newVal) => {
    hasChanges.value = JSON.stringify(newVal) !== JSON.stringify(initialBarangayAchievement);
}, { deep: true });

// Discard changes and reset form
const discardChanges = () => {
    barangayAchievementUpdate.value = JSON.parse(JSON.stringify(initialBarangayAchievement.value));
    hasChanges.value = false;
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        barangayAchievementUpdate.value.img = URL.createObjectURL(file);
    }
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
                                <img :src="barangayAchievementUpdate.img" alt="Uploaded Image">
                            </label>

                            <article>
                                <v-text-field 
                                    v-model="barangayAchievementUpdate.title" 
                                    label="Barangay Achievement Title" 
                                    required>
                                </v-text-field>
                                <v-text-field 
                                    v-model="barangayAchievementUpdate.subtitle" 
                                    label="Barangay Achievement Subtitle" 
                                    required>
                                </v-text-field>
                                <v-textarea v-model="barangayAchievementUpdate.info" label="Info">
                                </v-textarea>
                            </article>
                            <v-btn color="error" class="ma-auto" @click="closeForm" width="30%">Cancel</v-btn>

                        </v-card>
                    </v-form>


                    <!-- Action Buttons -->
                    <v-card-actions v-if="hasChanges" class="actions">
                        <v-btn color="grey" @click="discardChanges">Discard Changes</v-btn>
                        <v-btn color="primary" @click="updateAchievement(barangayAchievementUpdate)">Save Changes</v-btn>
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
