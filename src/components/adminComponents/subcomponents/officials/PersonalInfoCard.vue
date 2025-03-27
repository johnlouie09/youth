<script>
  import { VDateInput } from 'vuetify/lib/labs/components.mjs';
  import $ from 'jquery';

  export default {
    // Props received from parent component
    props: {
      info: {
        type: Object
      }
    },
    data() {
      return {
        personalInfo: {},
        initialPersonalInfo: {},

        // For handling file uploads
        file: null,
        filePreview: null,
        
        // Flag to track if any changes have been made
        hasChanges: false,
        // Controls dialog visibility (if applicable)
        dialog: true
      };
    },
    methods: {
      saveChanges() {
        this.hasChanges = false;
        // Format date fields before sending to API
        this.personalInfo.birthday = this.formatDate(this.personalInfo.birthday);
        this.personalInfo.term_start = this.formatDate(this.personalInfo.term_start);
        this.personalInfo.term_end = this.formatDate(this.personalInfo.term_end);

        // Call the API to update the official's information
        this.updateOfficialInfos();
      },
      discardChanges() {
        this.personalInfo = { ...this.initialPersonalInfo };
        this.filePreview = null; // Reset file preview
        this.hasChanges = false;
      },

      /**
       * Trigger the hidden file input element.
       */
      triggerFileInput() {
        this.$refs.fileInput.click();
      },

      /**
       * Handle file selection, create a preview, and store the file name.
       * @param {Event} event
       */
      handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
          this.file = file;
          const reader = new FileReader();
          reader.onload = (e) => {
            this.filePreview = e.target.result; // Base64 preview for immediate display
            // Optionally store the filename for later use (e.g., in API update)
            this.personalInfo.img = file.name;
          };
          reader.readAsDataURL(file);
        }
      },

      /**
       * Update official's information via an AJAX request.
       */
      updateOfficialInfos() {
        const formData = new FormData();
        formData.append("personalInfo", JSON.stringify(this.personalInfo));
        if (this.file) {
          formData.append("file", this.file);
        }
        $.ajax({
          url: `${this.$store.getters['api_base']}?e=sk-official&a=updatePersonalInfo`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
          },
          processData: false,
          contentType: false,
          data: formData,
          success: (data) => {
            console.log("Data has been updated successfully", data);
            // Convert the updated date strings back into Date objects
            this.personalInfo.birthday = new Date(this.personalInfo.birthday);
            this.personalInfo.term_start = new Date(this.personalInfo.term_start);
            this.personalInfo.term_end = new Date(this.personalInfo.term_end);
            // Sync initial state with the current state
            this.initialPersonalInfo = { ...this.personalInfo };
            this.hasChanges = false;
            // Clear file preview if needed
            this.filePreview = null;
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
          }
        });
      },

            /**
       * Convert a Date object (or valid date string) to a formatted "YYYY-M-D" string.
       * @param {Date|string} date
       * @returns {string}
       */
       formatDate(date) {
        if (!date) return "";
        const d = new Date(date);
        return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
      },
    },
    watch: {
      /**
       * Watch for changes in the parent 'info' prop and update local state.
       */
      info: {
        immediate: true,
        handler(newVal) {
          this.personalInfo = { ...newVal };
          // Convert string dates to Date objects for v-date-input compatibility
          if (newVal.birthday) this.personalInfo.birthday = new Date(newVal.birthday);
          if (newVal.term_start) this.personalInfo.term_start = new Date(newVal.term_start);
          if (newVal.term_end) this.personalInfo.term_end = new Date(newVal.term_end);
          // Set initial state for change detection
          this.initialPersonalInfo = { ...this.personalInfo };
        },
        deep: true
      },
      /**
       * Watch changes on personalInfo to update the 'hasChanges' flag.
       */
      personalInfo: {
        handler(newVal) {
          this.hasChanges = JSON.stringify(newVal) !== JSON.stringify(this.initialPersonalInfo);
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
  <!-- Achievement Image and Motto Card -->
  <v-card justify="center" class="intro pa-4 info-card">
    <div class="image-container pa-5">
      <!-- Image Container -->
      <v-avatar 
      :image="filePreview || (personalInfo.img ? ($store.getters.base + 'public/OfficialImages/' + personalInfo.img) : '/public/OfficialImages/no-avatar.jpg')"
      alt="Profile Image" 
      cover
      size="200"
      class="rounded-circle"
      />

      <!-- Floating Upload Icon -->
      <v-btn class="upload-icon" icon @click="triggerFileInput">
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

    <!-- Motto Textarea -->
    <v-textarea 
    class="motto" 
    label="Motto" 
    width="80%" 
    v-model="personalInfo.motto" 
    auto-grow 
    rows="1">
    </v-textarea>
  </v-card>

  <!-- Personal Information Section -->
  <v-card class="personal-info w-[60%] d-flex flex-col justify-center items-center ga-5" elevation="5">
    <!-- Title Section -->
    <v-card-title class="d-flex align-center justify-center ga-3">
      <v-icon class="active me-2" size="40">mdi-account-circle</v-icon>
      <h2 class="gradient-text font-extrabold text-2xl">PERSONAL INFORMATION</h2>
    </v-card-title>

    <!-- Form Section -->
    <v-card-text class="w-[70%]">
      <v-form>
        <!-- Full Name Field -->
        <v-text-field
          v-model="personalInfo.full_name"
          label="Full Name"
          variant="outlined"
          clearable
        ></v-text-field>

        <!-- Email Field -->
        <v-text-field
          v-model="personalInfo.email"
          label="Email"
          variant="outlined"
          type="email"
          clearable
        ></v-text-field>

        <!-- Contact Number Field -->
        <v-text-field
          v-model="personalInfo.contact_number"
          label="Contact Number"
          variant="outlined"
          clearable
        ></v-text-field>

        <!-- Birthdate Field -->
        <v-date-input
          v-model="personalInfo.birthday"
          label="Birthdate"
          prepend-icon=""
          prepend-inner-icon="$calendar"
          variant="solo"
        />

        <!-- Term Start and Term End Fields -->
        <div class="flex justify-evenly">
          <v-date-input
            v-model="personalInfo.term_start"
            label="Term Start"
            prepend-icon=""
            prepend-inner-icon="$calendar"
            variant="solo"
          />
          <v-date-input
            v-model="personalInfo.term_end"
            label="Term End"
            prepend-icon=""
            prepend-inner-icon="$calendar"
            variant="solo"
          />
        </div>

        <!-- Action Buttons -->
        <div v-if="hasChanges" class="button-container">
          <v-btn color="teal-lighten-1" @click="saveChanges">Save Changes</v-btn>
          <v-btn color="red-lighten-1" @click="discardChanges">Discard Changes</v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<style scoped>
/* Intro Section */
.active {
  /* Style the active icon button (you can adjust colors, borders, etc.) */
  background-image: linear-gradient(45deg, #004bf9, #f65c66, #ffd45e);
  border-radius: 50%;
}

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
  height: auto;
}

/* Personal Info Card */
.personal-info {
  border-radius: 2rem;
  padding: 3rem 0rem;
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

/* Image and Upload Styling */
.image-container {
  position: relative;
  display: inline-block;
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
