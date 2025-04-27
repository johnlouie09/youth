<template>
    <v-dialog width="900px" max-height="90vh" v-model="dialog" persistent>
        <v-card elevation="5" class="d-flex flex-col items-center pa-10 gap-6">
        
        <!-- Title Section: Display different titles based on the action prop -->
        <div class="d-flex items-center justify-center gap-2">
            <h3 class="gradient-text text-2xl font-extrabold">
            ADD NEW SK OFFICIAL
            </h3>
        </div>

        <!-- Official Image and Motto Card -->
           
        <!-- Image Container -->
        <div class="image relative pa-0">
            <v-avatar 
            :image="filePreview || (skOfficial.img ? ($store.getters.base + 'OfficialImages/' + skOfficial.img) : '/OfficialImages/no-avatar.png')"
            alt="Profile Image" 
            cover
            size="125"
            class="rounded-circle mt-5"
            />

            <!-- Floating Upload Icon -->
            <v-btn class="upload-icon" icon @click="triggerFileInput" size="40">
                <v-icon size="15">mdi-camera</v-icon>
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
        
        <v-card-text class="w-[70%]">
            <v-form>
                <!-- Full Name Field -->
                <v-text-field
                v-model="skOfficial.full_name"
                label="Full Name"
                variant="outlined"
                clearable
                ></v-text-field>

                <v-select
                v-model="skOfficial.position"
                :items="positions"
                item-text="text"
                item-value="value"
                label="Select SK Position"
                variant="outlined"
                ></v-select>

                <!-- Email Field -->
                <v-text-field
                v-model="skOfficial.email"
                label="Email"
                variant="outlined"
                type="email"
                clearable
                ></v-text-field>

                <!-- Contact Number Field -->
                <v-text-field
                v-model="skOfficial.contact_number"
                label="Contact Number"
                variant="outlined"
                clearable
                ></v-text-field>

                <v-textarea 
                class="motto h-auto pa-0" 
                label="Motto" 
                variant="outlined"
                v-model="skOfficial.motto" 
                auto-grow 
                rows="1">
                </v-textarea>

                <!-- Birthdate Field -->
                <v-date-input
                v-model="skOfficial.birthday"
                label="Birthdate"
                prepend-icon=""
                prepend-inner-icon="$calendar"
                variant="solo"
                />

                <!-- Term Start and Term End Fields -->
                <div class="flex justify-evenly">
                <v-date-input
                    v-model="skOfficial.term_start"
                    label="Term Start"
                    prepend-icon=""
                    prepend-inner-icon="$calendar"
                    variant="solo"
                />
                <v-date-input
                    v-model="skOfficial.term_end"
                    label="Term End"
                    prepend-icon=""
                    prepend-inner-icon="$calendar"
                    variant="solo"
                />
                </div>
                <!-- Action Buttons -->
                <div class="button-container d-flex justify-center items-center">
                    <v-btn @click="addOfficial()" color="teal-lighten-1">Add SK OFFICIAL</v-btn>
                </div>
            </v-form>
        </v-card-text>

        
        <!-- Close Dialog Button -->
        <v-card-actions class="absolute top-0 right-0 pa-5">
            <v-btn icon color="error" @click="closeForm">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-card-actions>
        
        </v-card>
    </v-dialog>
</template>

<script>
import { VDateInput } from 'vuetify/lib/labs/components.mjs';
import $ from 'jquery';

export default {
  data() {
    return {
      dialog: true,
      skOfficial: {},
      positions: [
        "SK Secretary",
        "SK Treasurer",
        "SK Kagawad"
      ],
      // For file upload handling
      file: null,
      filePreview: null,
    };
  },
  methods: {
    // Closes the dialog and resets data
    closeForm() {
      this.dialog = false;
      this.skOfficial = {};
      this.file = null;
      this.filePreview = null;
      this.$emit('close');
    },
    // Triggers the hidden file input
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    // Handles file upload and creates a preview
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.file = file;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.filePreview = e.target.result;
          // Store the filename for later use
          this.skOfficial.img = file.name;
        };
        reader.readAsDataURL(file);
      }
    },
    // Converts a Date object or valid date string to a "YYYY-M-D" format string
    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
    },
    // AJAX method to add a new SK Official
    addOfficial() {
      // Convert date fields to strings before sending them to the backend.
      this.skOfficial.birthday = this.formatDate(this.skOfficial.birthday);
      this.skOfficial.term_start = this.formatDate(this.skOfficial.term_start);
      this.skOfficial.term_end = this.formatDate(this.skOfficial.term_end);

      // Create a FormData object and append the official info as JSON.
      const formData = new FormData();
      formData.append("officialInfo", JSON.stringify(this.skOfficial));
      if (this.file) {
        formData.append("file", this.file);
      }
      $.ajax({
        url: `${this.$store.getters['api_base']}?e=sk-official&a=addOfficial`,
        type: 'POST',
        xhrFields: { withCredentials: true },
        headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
        processData: false,
        contentType: false,
        data: formData,
        success: (data) => {
          console.log("SK Official added successfully", data);
          // Notify parent to refresh the official info list.
          
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error("Error adding SK Official:", textStatus, errorThrown);
        },
        complete: () => {
          this.dialog = false;
          this.skOfficial = {};
          this.file = null;
          this.filePreview = null;
          this.$emit('fetchOfficialInfo', true);
          this.$emit('close');
        }
      });
    }
  },
  watch: {
    // Watch for changes in full_name to auto-populate the slug (first word in lowercase)
    "skOfficial.full_name": {
      handler(newVal) {
        this.skOfficial.slug = newVal ? newVal.split(" ")[0].toLowerCase() : "";
      },
      immediate: true
    }
  },
  created() {
    // Set the barangay ID from the store when the component is created.
    this.skOfficial.barangay_id = this.$store.getters['auth/getBarangayId'];
    this.skOfficial.username = null;
    this.skOfficial.password = null;
  },
  components: {
    VDateInput
  }
};
</script>


<style scoped>
.info-card {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: auto;
  padding: 1rem;
  gap: .5rem;
  border-radius: 1rem;
}

.upload-icon {
    position: absolute;
    bottom: 0;
    right: 0;
}
</style>