<script setup>
import { ref, watch, computed } from 'vue';

const dialog = ref(true);
const props = defineProps({
    education: Object
});

// Initial Education Data
const initialEducationInfo = {
    school: props.education.school,
    detail: props.education.detail,
    startYear: props.education.years.start,
    endYear: props.education.years.end,
    icon: props.education.icon
};

// Reactive state for form
const educationInfo = ref({ ...initialEducationInfo });
const hasChanges = ref(false);

const fileInput = ref(null); // Reference for the hidden file input

// Handle file upload and preview
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        educationInfo.value.icon = URL.createObjectURL(file);
    }
};

// Trigger file input when clicking the icon
const triggerFileInput = () => {
    fileInput.value.click();
};

// Watch for changes to enable the Save/Discard buttons
watch(educationInfo, (newVal) => {
    hasChanges.value = JSON.stringify(newVal) !== JSON.stringify(initialEducationInfo);
}, { deep: true });

// Save changes and update initial values
const saveChanges = () => {
    Object.assign(initialEducationInfo, { ...educationInfo.value });
    hasChanges.value = false;
    emit('close');
};

// Discard changes and reset form
const discardChanges = () => {
    educationInfo.value = { ...initialEducationInfo };
    hasChanges.value = false;
};

const currentYear = new Date().getFullYear();
const years = Array.from({ length: 50 }, (_, i) => (currentYear - i).toString());

// Dynamically filter end years so they are not higher than start year
const filteredEndYears = computed(() => {
    return years.filter(year => parseInt(year) <= parseInt(educationInfo.value.startYear));
});

// Watch startYear to reset endYear if it becomes invalid
watch(() => educationInfo.value.startYear, (newStartYear) => {
    if (parseInt(educationInfo.value.endYear) > parseInt(newStartYear)) {
        educationInfo.value.endYear = newStartYear;
    }
});

const emit = defineEmits(['close']); // Define an event for closing
const closeForm = () => {
    emit('close'); // Emit event when closing
};
</script>

<template>
    <v-dialog v-model="dialog" max-width="900px" persistent>
        <v-card class="card" elevation="10">
            <!-- Image Upload Preview -->
            <div class="image-container">
                <img :src="educationInfo.icon" alt="University Logo" class="profile-image">
                
                <!-- Floating Upload Icon -->
                <v-btn class="upload-icon" icon @click="triggerFileInput">
                    <v-icon>mdi-camera</v-icon>
                </v-btn>

                <!-- Hidden File Input -->
                <input 
                    ref="fileInput" 
                    type="file" 
                    accept="image/*" 
                    class="hidden-file-input"
                    @change="handleFileUpload"
                >
            </div>

            <!-- Editable Form -->
            <v-form class="form-content">
                <v-text-field v-model="educationInfo.school" label="School Name" variant="outlined"></v-text-field>
                <v-text-field v-model="educationInfo.detail" label="Detail" variant="outlined"></v-text-field>
                
                <v-select 
                    v-model="educationInfo.startYear" 
                    :items="years" 
                    label="Start Year"
                    required
                ></v-select>

                <v-select 
                    v-model="educationInfo.endYear" 
                    :items="filteredEndYears" 
                    label="End Year"
                    required
                ></v-select>
            </v-form>

            <v-btn color="error" @click="closeForm">Cancel</v-btn>

            <!-- Action Buttons -->
            <v-card-actions v-if="hasChanges" class="actions">
                <v-btn color="grey" @click="discardChanges">Discard Changes</v-btn>
                <v-btn color="primary" @click="saveChanges">Save Changes</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>
.card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3rem;
    gap: 2rem;
}

/* Image and Upload Styling */
.image-container {
    position: relative;
    display: inline-block;
}

.profile-image {
    width: 100px;
    height: 100px;
    border-radius: 0.5rem;
    object-fit: cover;
}

/* Floating Upload Icon */
.upload-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    width: 32px;
    height: 32px;
    min-width: 32px;
    min-height: 32px;
}

/* Hide the file input */
.hidden-file-input {
    display: none;
}

/* Form Styling */
.form-content {
    width: 100%;
}

/* Buttons */
.actions {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-top: 1rem;
}
</style>
