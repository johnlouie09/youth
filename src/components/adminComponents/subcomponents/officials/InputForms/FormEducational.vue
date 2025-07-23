<script>
import $ from 'jquery';
export default {
  props: {
    education: Object,
    action: String
  },
  data() {
    const currentYear = new Date().getFullYear();
    return {
      dialog: true,
      initialEducationInfo: {},
      educationInfo: {},
      years: Array.from({ length: 50 }, (_, i) => (currentYear - i).toString()),
      educationLevels: [],
      // Flag to track if changes have been made
      hasChanges: false,
      // For file upload handling
      file: null,
      filePreview: null,
    };
  },
  methods: {
    // Save changes by updating via AJAX
    saveChanges() {
      // Format date fields as strings before sending
      this.educationInfo.date = this.formatDate(this.educationInfo.date);
      if (this.action === 'updating') {
        this.updateEducation();
      } else if (this.action === 'adding') {
        this.addEducation();
      }
      // Reset change flag and close the dialog
      this.hasChanges = false;
      this.dialog = false;
    },
    // Discard changes and revert to initial state
    discardChanges() {
      this.educationInfo = { ...this.initialEducationInfo };
      this.file = null;
      this.filePreview = null;
      this.hasChanges = false;
    },
    closeForm() {
      this.dialog = false;
      this.$emit('close');
    },
    // Format a date to "YYYY-M-D" string
    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
    },
    // Trigger the hidden file input
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    // Handle file upload and create a preview
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.file = file;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.filePreview = e.target.result;
          // Store the filename for later use
          this.educationInfo.school_logo = file.name;
        };
        reader.readAsDataURL(file);
      }
    },
    // Fetch education levels from the API
    fetchEducationLevel() {
      $.ajax({
        url: `${this.$store.getters['api_base']}?e=education-level&a=fetchEducationLevel`,
        type: 'GET',
        xhrFields: { withCredentials: true },
        success: (data) => {
          this.educationLevels = data.data.educationLevel;
          console.log("Education Level Fetched Successfully", data.data.educationLevel);
          // Once education levels are fetched, update the education level name if an id exists.
          this.updateEducationLevelName();
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error("Error:", textStatus, errorThrown);
        }
      });
    },
    // Update the educationInfo.educational_level_name based on education_level_id.
    updateEducationLevelName() {
      if (this.educationInfo.education_level_id) {
        const level = this.educationLevels.find(item => item.id === this.educationInfo.education_level_id);
        if (level) {
          this.educationInfo.educational_level_name = level.name;
          // Update the initial copy so that it contains the new name.
          this.initialEducationInfo = { ...this.educationInfo };
        }
      }
    },
    // AJAX method for updating an education record.
    updateEducation() {
      const formData = new FormData();
      formData.append("educationInfo", JSON.stringify(this.educationInfo));
      if (this.file) {
        formData.append("file", this.file);
      }
      $.ajax({
        url: `${this.$store.getters['api_base']}?e=sk-official&a=updateEducation`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
        processData: false,
        contentType: false,
        data: formData,
        success: (data) => {
          console.log("Education Data has been Updated Successfully", data);
          // Update initial info so all references are in sync.
          this.initialEducationInfo = { ...this.educationInfo };
          this.hasChanges = false;
          this.file = null;
          this.filePreview = null;
          this.$emit("fetchInfo", true);
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error("Error:", textStatus, errorThrown);
        }
      });
    },
    // AJAX method for adding a new education record.
    addEducation() {
      const formData = new FormData();
      formData.append("educationInfo", JSON.stringify(this.educationInfo));
      if (this.file) {
        formData.append("file", this.file);
      }
      $.ajax({
        url: `${this.$store.getters['api_base']}?e=sk-official&a=addEducation`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
        processData: false,
        contentType: false,
        data: formData,
        success: (data) => {
          console.log("Education data has been added successfully", data);
          if (this.educationInfo.date) {
            this.educationInfo.date = new Date(this.educationInfo.date);
          }
          this.initialEducationInfo = { ...this.educationInfo };
          this.hasChanges = false;
          this.filePreview = null;
          this.$emit("fetchInfo", true);
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error("Error adding education:", textStatus, errorThrown);
        }
      });
    },
    // Helper method: returns the education level id for a given name.
    findEducationalLevelIdByName(name) {
      const level = this.educationLevels.find(item => item.name === name);
      return level ? level.id : null;
    }
  },
  computed: {
    // Create an array of education level names from the educationLevels array.
    educationLevelNames() {
      return this.educationLevels.map(educationLevel => educationLevel.name);
    }
  },
  watch: {
    // When the education prop changes, update the local educationInfo and initialEducationInfo.
    education: {
      immediate: true,
      handler(newVal) {
        this.educationInfo = { ...newVal }; 
        this.initialEducationInfo = { ...this.educationInfo };
      },
      deep: true
    },
    // Watch changes in educationInfo to update the hasChanges flag.
    educationInfo: {
      handler(newVal) {
        this.hasChanges = JSON.stringify(newVal) !== JSON.stringify(this.initialEducationInfo);
      },
      deep: true
    },
    'educationInfo.educational_level_name': {
        immediate: true,
        handler(newVal) {
        if (newVal && newVal.trim() !== '') {
            // Find the education level id based on the name.
            const levelId = this.findEducationalLevelIdByName(newVal);
            if (levelId !== null) {
            this.educationInfo.education_level_id = levelId;
            }
        } else {
            // Revert to the original id if no name is provided.
            this.educationInfo.education_level_id = this.initialEducationInfo.education_level_id;
        }
        },
        deep: true
    }
  },
  created() {
    // Initialize local copies from the prop and fetch education levels.
    this.educationInfo = { ...this.education };
    this.initialEducationInfo = { ...this.educationInfo };
    this.fetchEducationLevel();
  }
};
</script>


<template>
    <v-dialog v-model="dialog" max-width="900px" persistent>
      <v-card class="card w-full" elevation="10">
        <!-- Title Section -->
        <div class="d-flex items-center justify-center gap-2">
          <h3 v-if="action === 'updating'" class="gradient-text text-2xl font-extrabold">
            UPDATE EDUCATION
          </h3>
          <h3 v-if="action === 'adding'" class="gradient-text text-2xl font-extrabold">
            ADD NEW EDUCATION
          </h3>
        </div>
  
        <div class="d-flex flex-col items-center justify-center gap-5 w-full">
          <!-- Image Container -->
          <div class="image-container">
            <v-avatar
              :image="filePreview || (educationInfo.school_logo ? ($store.getters.base + 'public/schoolLogos/' + educationInfo.school_logo) : ($store.getters.base + 'public/schoolLogos/favicon.ico'))"
              size="150"
            />
            <v-btn class="upload-icon" icon @click="triggerFileInput">
              <v-icon>mdi-camera</v-icon>
            </v-btn>
            <input
              ref="fileInput"
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleFileUpload"
            />
          </div>
          
          <!-- Form Fields -->
          <article class="w-[90%]">
            <v-text-field
              class="w-full text-lg"
              v-model="educationInfo.school_name"
              label="School Name"
              variant="outlined"
              required
            />
            <v-text-field
              class="w-full text-lg"
              v-model="educationInfo.course"
              label="Course or Details"
              variant="outlined"
              required
            />
            <!-- Education Level Select -->
            <v-select
              v-model="educationInfo.educational_level_name"
              :items="educationLevelNames"
              label="Select Educational Level"
              outlined
            />
            <!-- Year Selects -->
            <div class="d-flex gap-10">
              <v-select
                v-model="educationInfo.start_year"
                :items="years"
                label="School Start Year"
                required
              />
              <v-select
                v-model="educationInfo.end_year"
                :items="years"
                label="School End Year"
                required
              />
            </div>
          </article>
        </div>
  
        <!-- Action Buttons -->
        <v-card-actions v-if="hasChanges" class="w-[70%] d-flex justify-center items-center gap-10">
          <v-btn color="red-lighten-1" @click="discardChanges">Discard Changes</v-btn>
          <v-btn v-if="action === 'adding'" color="teal-lighten-1" @click="saveChanges">Add Education</v-btn>
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


/* Form Styling */
.form-content {
    width: 100%;
}

</style>
