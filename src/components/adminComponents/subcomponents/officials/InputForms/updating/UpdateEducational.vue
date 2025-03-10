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

<script>
export default {
    props: {
        education: Object
    },
    data() {
        const currentYear = new Date().getFullYear();
        return {
            dialog: true,
            fileInput: null,
            initialEducationInfo: {
                school: this.education.school,
                detail: this.education.detail,
                startYear: this.education.years.start,
                endYear: this.education.years.end,
                icon: this.education.icon
            },
            educationInfo: {
                school: this.education.school,
                detail: this.education.detail,
                startYear: this.education.years.start,
                endYear: this.education.years.end,
                icon: this.education.icon
            },
            hasChanges: false,
            years: Array.from({ length: 50 }, (_, i) => (currentYear - i).toString())
        };
    },
    computed: {
        filteredEndYears() {
            return this.years.filter(year => parseInt(year) <= parseInt(this.educationInfo.startYear));
        }
    },
    watch: {
        educationInfo: {
            handler(newVal) {
                this.hasChanges = JSON.stringify(newVal) !== JSON.stringify(this.initialEducationInfo);
            },
            deep: true
        },
        'educationInfo.startYear'(newStartYear) {
            if (parseInt(this.educationInfo.endYear) > parseInt(newStartYear)) {
                this.educationInfo.endYear = newStartYear;
            }
        }
    },
    methods: {
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.educationInfo.icon = URL.createObjectURL(file);
            }
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        saveChanges() {
            Object.assign(this.initialEducationInfo, { ...this.educationInfo });
            this.hasChanges = false;
            this.$emit('close');
        },
        discardChanges() {
            this.educationInfo = { ...this.initialEducationInfo };
            this.hasChanges = false;
        },
        closeForm() {
            this.$emit('close');
        }
    }
};
</script>


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
