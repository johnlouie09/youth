<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import $ from 'jquery';
  
export default {
props: {
    achievement: Object,
    action: String
},
data() {
    return {
    initialAchievementInfo: {},
    achievementInfo: {},
    dialog: true,

    // Flag to track if changes have been made
    hasChanges: false,
    // For file upload handling
    file: null,
    filePreview: null,
    };
},
methods: {
    // Methods for Button
    saveChanges() {
        // Format date fields as strings before sending
        this.achievementInfo.date = this.formatDate(this.achievementInfo.date);
        
        // Depending on the action prop, either update or add an achievement.
        if (this.action === 'updating') {
            this.updateAchievement();
        } else if (this.action === 'adding') {
            this.addAchievement();
        }
        
        // Reset change flag and close the dialog
        this.hasChanges = false;
        this.dialog = false;
    },
    discardChanges() {
        this.achievementInfo = { ...this.initialAchievementInfo };
        this.filePreview = null;
        this.hasChanges = false;
    },
    closeForm() {
        this.$emit('close');
    },
    updateDate(newDate) {
        this.achievementInfo.date = newDate;
    },

    // Method for Handling File Upload
    triggerFileInput() {
    this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
    const file = event.target.files[0];
    if (file) {
        this.file = file;
        const reader = new FileReader();
        reader.onload = (e) => {
        this.filePreview = e.target.result;
        // Store the filename for later use.
        this.achievementInfo.img = file.name;
        };
        reader.readAsDataURL(file);
    }
    },

    //   Ajax Methods for Updating and Adding Achievements
    updateAchievement() {
    const formData = new FormData();
    formData.append("achievementInfo", JSON.stringify(this.achievementInfo));
    if (this.file) {
        formData.append("file", this.file);
    }
    $.ajax({
        url: `${this.$store.getters['api_base']}?e=sk-official&a=updateAchievement`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
        processData: false,
        contentType: false,
        data: formData,
        success: (data) => {
        console.log("Data has been updated successfully", data);
        // Convert date string back to a Date object for v-date-input
        this.achievementInfo.date = new Date(this.achievementInfo.date);
        // Update the original info to match current info
        this.initialAchievementInfo = { ...this.achievementInfo };
        this.hasChanges = false;
        this.filePreview = null;
        // Emit an event to notify the parent that an update occurred
        this.$emit("fetchAchievement", true);
        },
        error: (jqXHR, textStatus, errorThrown) => {
        console.error("Error:", textStatus, errorThrown);
        }
    });
    },
    addAchievement() {
    const formData = new FormData();
    formData.append("achievementInfo", JSON.stringify(this.achievementInfo));
    if (this.file) {
        formData.append("file", this.file);
    }
    $.ajax({
        url: `${this.$store.getters['api_base']}?e=sk-official&a=addAchievement`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
        processData: false,
        contentType: false,
        data: formData,
        success: (data) => {
        console.log("Data has been added successfully", data);
        // Convert date string back to a Date object for v-date-input
        this.achievementInfo.date = new Date(this.achievementInfo.date);
        // Update the original info so all references are in sync
        this.initialAchievementInfo = { ...this.achievementInfo };
        this.hasChanges = false;
        this.filePreview = null;
        // Emit an event to notify the parent that a new achievement was added
        this.$emit("fetchAchievement", true);
        },
        error: (jqXHR, textStatus, errorThrown) => {
        console.error("Error:", textStatus, errorThrown);
        }
    });
    },

    // Some Method
    formatDate(date) {
        if (!date) return "";
        const d = new Date(date);
        return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
    },
},


// Watch the achievement prop and update local data accordingly
watch: {
    achievement: {
        immediate: true,
        handler(newVal) {
            // Create local copies from the provided achievement prop
            this.achievementInfo = { ...newVal };
            if (newVal.date) this.achievementInfo.date = new Date(newVal.date);
            this.initialAchievementInfo = { ...this.achievementInfo };
        },
        deep: true
    },
    // Watch for changes in achievementInfo to update the hasChanges flag
    achievementInfo: {
        handler(newVal) {
            this.hasChanges = JSON.stringify(newVal) !== JSON.stringify(this.initialAchievementInfo);
        },
        deep: true
    }
},
components: {
    VDateInput
}
};
</script>

<template>
    <v-dialog width="900px" max-height="90vh" v-model="dialog" persistent>
        <v-card elevation="5" class="d-flex flex-col items-center pa-10 gap-6">
        
        <!-- Title Section: Display different titles based on the action prop -->
        <div class="d-flex items-center justify-center gap-2">
            <h3 v-if="action === 'updating'" class="gradient-text text-2xl font-extrabold">
            UPDATE ACHIEVEMENT
            </h3>
            <h3 v-if="action === 'adding'" class="gradient-text text-2xl font-extrabold">
            ADD NEW ACHIEVEMENT
            </h3>
        </div>
        
        <!-- Achievement Display Image -->
        <div class="w-[60%] d-flex justify-center items-center relative">
            <v-img
            :src="filePreview || (achievementInfo.img ? ($store.getters.base + 'public/achievements/' + achievementInfo.img) : ($store.getters.base + 'public/exx.jpg'))"
            alt=""
            class="elevation-5 rounded-lg"
            ></v-img>
            <!-- Camera Icon Button to trigger file input -->
            <v-btn class="upload-icon ma-3" icon @click="triggerFileInput">
            <v-icon>mdi-camera</v-icon>
            </v-btn>
            <!-- Hidden File Input -->
            <input 
            ref="fileInput" 
            type="file" 
            accept="image/*" 
            class="hidden"
            @change="handleFileUpload"
            >
        </div>
        
        <!-- Achievement Form -->
        <article class="d-flex flex-col items-start w-[90%]">
            <!-- Achievement Title -->
            <v-text-field
            class="w-full text-lg uppercase"
            v-model="achievementInfo.title"
            label="Achievement Title"
            variant="outlined"
            required
            ></v-text-field>
            <!-- Achievement Subtitle -->
            <v-text-field
            class="w-full text-lg uppercase"
            v-model="achievementInfo.subtitle"
            label="Achievement Subtitle"
            variant="outlined"
            required
            ></v-text-field>
            <!-- Achievement Info -->
            <v-textarea
            class="w-full text-lg uppercase"
            v-model="achievementInfo.info"
            label="Achievement Info"
            variant="outlined"
            required
            auto-grow
            rows="1"
            ></v-textarea>
            <!-- Achievement Date Picker -->
            <v-date-input
            v-model="achievementInfo.date"
            label="Select a date"
            class="text-xs font-italic relative bottom-0 right-0 w-full"
            prepend-icon=""
            prepend-inner-icon="$calendar"
            variant="solo"
            />
        </article>
        
        <!-- Action Buttons: Save/Discard -->
        <v-card-actions v-if="hasChanges" class="w-[70%] d-flex justify-center items-center gap-10">
            <v-btn color="red-lighten-1" @click="discardChanges">Discard Changes</v-btn>
            <v-btn v-if="action === 'adding'" color="teal-lighten-1" @click="saveChanges">Add Achievement</v-btn>
            <v-btn v-if="action === 'updating'" color="teal-lighten-1" @click="saveChanges">Save Changes</v-btn>
        </v-card-actions>
        
        <!-- Close Dialog Button -->
        <v-card-actions class="absolute top-0 right-0 pa-5">
            <v-btn icon color="error" @click="closeForm">
            <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-card-actions>
        
        </v-card>
    </v-dialog>
</template>

<style scoped>
    /* Custom button style if needed */
    .add-ebg-button {
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1.5rem;
        margin: auto;
        font-size: 0.7rem;
    }

    /* Floating Upload Icon styling */
    .upload-icon {
        position: absolute;
        bottom: 0;
        right: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        width: 48px;
    }
</style>
  