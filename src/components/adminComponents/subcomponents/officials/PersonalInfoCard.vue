<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import $ from 'jquery';

export default {
  props: {
    info: {
      type: Object
    }
  },
  data() {
    return {
      personalInfo: {},
      initialPersonalInfo: {},
      file: null,
      filePreview: null, // new property for file preview
      hasChanges: false
    };
  },
  methods: {
    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
    },
    saveChanges() {
      this.hasChanges = false;
      // Convert date fields to string format (YYYY-MM-DD) before sending
      this.personalInfo.birthday = this.formatDate(this.personalInfo.birthday);
      this.personalInfo.term_start = this.formatDate(this.personalInfo.term_start);
      this.personalInfo.term_end = this.formatDate(this.personalInfo.term_end);
      
      this.updateOfficialInfos();
    },
    discardChanges() {
      this.personalInfo = { ...this.initialPersonalInfo };
      this.filePreview = null; // reset preview if needed
      this.hasChanges = false;
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.file = file;
        // Create a file preview URL
        const reader = new FileReader();
        reader.onload = (e) => {
          this.filePreview = e.target.result; // store the base64 preview
          // Optionally, store the filename in personalInfo.img for later use
          this.personalInfo.img = file.name;
        };
        reader.readAsDataURL(file);
      }
    },
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
        headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
        processData: false,
        contentType: false,
        data: formData,
        success: (data) => {
          console.log("Data has been updated successfully", data);
          // Convert date strings back to Date objects for the v-date-input
          this.personalInfo.birthday = new Date(this.personalInfo.birthday);
          this.personalInfo.term_start = new Date(this.personalInfo.term_start);
          this.personalInfo.term_end = new Date(this.personalInfo.term_end);
          // Update initial data so all references are in sync
          this.initialPersonalInfo = { ...this.personalInfo };
          this.hasChanges = false;
          // Optionally clear file preview if upload is complete
          this.filePreview = null;
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error("Error:", textStatus, errorThrown);
        }
      });
    }
  },
  watch: {
    info: {
      immediate: true,
      handler(newVal) {
        this.personalInfo = { ...newVal };
        // Convert string dates to Date objects initially
        if (newVal.birthday) this.personalInfo.birthday = new Date(newVal.birthday);
        if (newVal.term_start) this.personalInfo.term_start = new Date(newVal.term_start);
        if (newVal.term_end) this.personalInfo.term_end = new Date(newVal.term_end);
        this.initialPersonalInfo = { ...this.personalInfo };
      },
      deep: true
    },
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
  <v-card justify="center" class="intro pa-4 info-card">
    <div class="image-container pa-5">
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

    <v-textarea class="motto" label="Motto" width="80%" v-model="personalInfo.motto" auto-grow rows="1">
    </v-textarea>
  </v-card>

  <!-- Personal Information Section -->
  <v-card class="personal-info" elevation="5">
    <v-card-title class="title d-flex align-center justify-center">
      <v-icon class="me-2" size="30">mdi-account-circle</v-icon>
      <h2 class="mb-0">Personal Information</h2>
    </v-card-title>

    <v-card-text class="form-content">
      <v-form>
        <v-text-field v-model="personalInfo.full_name" label="Full Name" variant="outlined" clearable></v-text-field>     
        <v-text-field v-model="personalInfo.email" label="Email" variant="outlined" type="email" clearable></v-text-field>                   
        <v-text-field v-model="personalInfo.contact_number" label="Contact Number" variant="outlined" clearable></v-text-field>                   
        <v-date-input v-model="personalInfo.birthday" label="Birthdate" prepend-icon="" prepend-inner-icon="$calendar" variant="solo" />

        <div class="d-flex space-evenly">
          <v-date-input v-model="personalInfo.term_start" label="Term Start" prepend-icon="" prepend-inner-icon="$calendar" variant="solo" />
          <v-date-input v-model="personalInfo.term_end" label="Term End" prepend-icon="" prepend-inner-icon="$calendar" variant="solo" />
        </div>
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
