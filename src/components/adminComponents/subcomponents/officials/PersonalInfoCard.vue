<template>
    <!-- Intro Section -->
    <v-card justify="center" class="intro pa-4 info-card">
        <div class="image-container">
            <img :src="personalInfo.img" width="150" contain>
            
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

        <v-textarea class="motto" width="80%" v-model="personalInfo.motto">
        </v-textarea>
    </v-card>

    <!-- Personal Information Section -->
    <v-card class="personal-info" elevation="5">
        <!-- Title with Icon -->
        <v-card-title class="title d-flex align-center justify-center">
            <v-icon class="me-2" size="30">mdi-account-circle</v-icon>
            <h2 class="mb-0">Personal Information</h2>
        </v-card-title>

        <!-- Form -->
        <v-card-text class="form-content">
            <v-form>
                <v-text-field v-model="personalInfo.name" label="Full Name" variant="outlined" clearable></v-text-field>     
                <v-text-field v-model="personalInfo.email" label="Email" variant="outlined" type="email" clearable></v-text-field>                   
                <v-text-field v-model="personalInfo.birthday" label="Birthday" variant="outlined" type="date"></v-text-field>

                <!-- Buttons: Show only when changes are detected -->
                <div v-if="hasChangesPersonalInfo" class="button-container">
                    <v-btn color="primary" @click="saveChanges">Save Changes</v-btn>
                    <v-btn color="grey" @click="discardChanges">Discard Changes</v-btn>
                </div>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            originalInfo: {
                name: "John Doe Dela Cruz",
                email: "johnjohn@email.com",
                birthday: "1999-05-15",
                motto: "Lorem ipsum dolor sit amet consecteture. Sed ultrices ultrices volutpat lobortis nunc dictumst nulla neque.",
                img: "/public/Sangguniang_Kabataan_logo.svg"
            },
            personalInfo: {},
            fileInput: null
        };
    },
    computed: {
        hasChangesPersonalInfo() {
            return JSON.stringify(this.personalInfo) !== JSON.stringify(this.originalInfo);
        }
    },
    methods: {
        saveChanges() {
            this.originalInfo = { ...this.personalInfo };
        },
        discardChanges() {
            this.personalInfo = { ...this.originalInfo };
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.personalInfo.img = URL.createObjectURL(file);
            }
        }
    },
    mounted() {
        this.personalInfo = { ...this.originalInfo };
    }
};
</script>


<style scoped>
/* Intro Section */
.intro {
    width: 50%;
    flex-wrap: nowrap;
    flex-direction: column;
    justify-items: center;
    align-items: center;
    gap: 2rem;
}

.info-card {
    display: flex;
    gap: 1rem;
    border-radius: 1rem;
}
.motto {
    font-size: 1.25rem;
    text-align: center;
}

/* Personal Info Card */
.personal-info {
    width: 60%;
    border-radius: 1rem;
    padding: 1.5rem;
}

/* Title Section */
.title {
    text-align: center;
    padding: 1rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Form Spacing */
.form-content {
    padding-top: 1.5rem;
    width: 70%;
    margin: 0 auto;
}

/* Buttons */
.button-container {
    display: flex;
    justify-content: space-around;
    margin-top: 1rem;
}

/* Hide the file input */
.hidden-file-input {
    display: none;
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
    width: 48px;

}
</style>
