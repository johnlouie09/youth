<script>
  import { data } from 'flickity';
import $ from 'jquery';
import { error } from 'jquery';

  export default {
    name: "AdvocacyForm",
    emits: ['fetchOfficialInfo'],
    props: {
      advocacies: {
        type: Array,
        default: () => []
      },
      id: {
        type: Number,
      }
    },
    data() {
      return {
        initialAdvocaciesInfo: [],
        advocaciesInfo: [],
        newAdvocacy: {},
        editingAdvocacyIndex: null,
        addingNewAdvocacy: false,
      };
    },
    methods: {
      // Button events method
      saveChanges(action, advocacyObj) {
        if(action === 'update') {
          this.updateAdvocacy(advocacyObj);
        }
        else if(action === 'add') {
          this.addAdvocacy(this.newAdvocacy); 
        } 
      },

      // AJAX Methods
      addAdvocacy(advocacy) {
        const formData = new FormData();
        delete advocacy.preview; // Remove preview property before sending
        formData.append('advocacyInfo', JSON.stringify(advocacy));
        formData.append('sk_official_id', this.id);
        if (advocacy.file) {
          formData.append('file', advocacy.file); // Append file only if it exists
        }

        $.ajax({
          url: `${this.$store.getters['api_base']}?e=sk-official&a=addAdvocacy`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
          processData: false,
          contentType: false,
          data: formData,
          success: (data) => {
            console.log("Successfully added advocacy data:", data);
            this.addingNewAdvocacy = false;
            this.newAdvocacy = {};
            this.$emit("fetchOfficialInfo", true); // Refresh parent component data
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error adding advocacy data:", textStatus, errorThrown);
          }
        });
      },


      updateAdvocacy(advocacy) {
        const formData = new FormData();
        delete advocacy.preview; // Remove preview property before sending
        formData.append('advocacyInfo', JSON.stringify(advocacy));
        formData.append('sk_official_id', this.id);
        formData.append('file', advocacy.file); // Append the file if it exists


        $.ajax({
          url: `${this.$store.getters['api_base']}?e=sk-official&a=updateAdvocacy`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
          processData: false,
          contentType: false,
          data: formData,
          success: (data) => {
            console.log("Successfully updated advocacy data:", data);
            this.$emit("fetchOfficialInfo", true);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error updating advocacy data:", textStatus, errorThrown);
          }
        })
      },

      deleteAdvocacy(advocacyId) {
        $.ajax({
          url: `${this.$store.getters['api_base']}?e=sk-official&a=deleteAdvocacy`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
          },
          data: { id: advocacyId },
          success: (data) => {
            console.log("Advocacy deleted successfully", data);
            // Emit event to refresh official information
            this.$emit('fetchOfficialInfo', true);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error deleting achievement:", textStatus, errorThrown);
          }
        });
      },

      // Method for Image Files Handling
      triggerFileInput() {
        this.$refs.fileInput.click();
      },   

      handleFileUpload(event) {
        const selectedFile = event.target.files[0];
        if (!selectedFile) return; // ✅ check if a file exists

        const reader = new FileReader();

        if(this.newAdvocacy && this.editingAdvocacyIndex === null) {
          // Clear previous values
          this.newAdvocacy.file = null;
          this.newAdvocacy.preview = null;
          this.newAdvocacy.thumbnail = null;

          // Save file reference
          this.newAdvocacy.file = selectedFile;

          reader.onload = (e) => {
            this.newAdvocacy.preview =  e.target.result; // Store the preview
            this.newAdvocacy.thumbnail = selectedFile.name; // Store file name or handle as needed
          };
          
          reader.readAsDataURL(selectedFile);
          return;
        } 
        else {
          // Clear previous values
          this.advocaciesInfo[this.editingAdvocacyIndex].file = null;
          this.advocaciesInfo[this.editingAdvocacyIndex].preview = null;
          this.advocaciesInfo[this.editingAdvocacyIndex].thumbnail = null;

          // Save file reference
          this.advocaciesInfo[this.editingAdvocacyIndex].file = selectedFile;

          reader.onload = (e) => {
            this.advocaciesInfo[this.editingAdvocacyIndex].preview =  e.target.result; // Store the preview
            this.advocaciesInfo[this.editingAdvocacyIndex].thumbnail = selectedFile.name; // Store file name or handle as needed
          };
          
          reader.readAsDataURL(selectedFile);
        }
      },

      // Helper Methods
      /** Shows a confirmation dialog for deletion and, if confirmed, calls the deleteAchievement method. */
      async confirmDelete(advocacyId) {
        this.$store.commit('dialog/confirm/show', {
          title: 'Delete Advocacy',
          prompt: 'Are you sure you want to delete this Advocacy?',
          color: 'red',
          yesText: 'Delete',
          noText: 'Cancel',
          onConfirm: async () => {
            await this.deleteAdvocacy(advocacyId);
          },
          onCancel: () => {
            console.log('Deletion cancelled');
          }
        });
      },
    },
    watch: {
      advocacies: {
        immediate: true,
        handler(newVal) {
          this.advocaciesInfo = JSON.parse(JSON.stringify(newVal));
          this.initialAdvocaciesInfo = JSON.parse(JSON.stringify(newVal));
        }
      }
    },
    created() {
      this.advocaciesInfo = JSON.parse(JSON.stringify(this.advocacies));
      this.initialAdvocaciesInfo = JSON.parse(JSON.stringify(this.advocacies));
    }
  };
</script>

<template>
    <v-card class="w-[80%] d-flex flex-col justify-start items-center rounded-2xl pa-10 ga-5">
      <!-- Title Section -->
      <v-card-title class="w-[90%] d-flex align-center justify-center ga-5 border-b py-5">
        <v-icon size="40">mdi-trophy</v-icon>
        <h2 class="font-extrabold text-2xl">ADVOCACIES</h2>
        <v-icon size="40">mdi-trophy</v-icon>
      </v-card-title>

      <!-- Form Section -->
      <v-container class="w-[90%] d-flex flex-row flex-wrap justify-center pa-5 ga-10">

        <!-- Existing Advocacies -->
        <v-card
        v-for="(advocacy, index) in advocaciesInfo"
        class="custom-card w-[80%] d-flex flex-col ga-5 items-center elevation-10 px-15 py-10 border rounded-lg elevation-10">

          <!-- Advocacy Image, Title and Subtitle -->
          <div class="w-full d-flex justify-evenly items-center ga-5 border-b">
              <div class="w-2/6 d-flex justify-center items-center relative">
                <v-img 
                  class="w-full elevation-5 rounded-lg"
                  :src="
                    advocacy?.preview 
                      ? advocacy.preview 
                      : (advocacy?.thumbnail 
                          ? ($store.getters.base + 'public/advocacyImages/' + advocacy.thumbnail) 
                          : ($store.getters.base + 'public/advocacyImages/no-avatar.png')
                        )
                  "
                  cover
                ></v-img>


                
                <v-btn 
                @click="triggerFileInput(); editingAdvocacyIndex = index"
                class="bottom-0 right-0 ma-2"
                style="position: absolute;"
                icon>
                  <v-icon size="20">
                      mdi-camera
                  </v-icon>
                </v-btn>
              </div>

              <div class="w-4/6 d-flex flex-col justify-center items-center py-5 ga-2">
                  <!-- Advocacy Title Textarea -->
                  <v-textarea
                  class="w-full text-lg font-extrabold text-center"
                  v-model="advocacy.title"
                  label="Advocacy Title"
                  variant="outlined"
                  auto-grow
                  rows="1"
                  clearable>
                  </v-textarea>

                  <!-- Advocacy Subtitle Textarea -->
                  <v-textarea 
                  v-model="advocacy.subtitle"
                  class="w-full" 
                  label="Advocacy Subtitle" 
                  variant="outlined"
                  auto-grow 
                  rows="2">
                  </v-textarea>
              </div>
          </div>

          <!-- Advocacy Details -->
          <v-textarea 
          v-model="advocacy.detail"
          class="w-full text-justify" 
          label="Advocacy Details" 
          auto-grow 
          hide-details
          rows="3">
          </v-textarea>

          
          <!-- Action Buttons: Save/Discard -->
          <v-card-actions 
            class="w-full d-flex justify-center items-center gap-10 pt-5 border-t"
            v-if="JSON.stringify(advocacy) !== JSON.stringify(initialAdvocaciesInfo[index])"
            style="position: relative; bottom: 0;">
              <v-btn color="red-lighten-1" @click="advocaciesInfo[index] = JSON.parse(JSON.stringify(initialAdvocaciesInfo[index]))">Discard Changes</v-btn>
              <v-btn color="teal-lighten-1" @click="saveChanges('update', advocaciesInfo[index])">Save Changes</v-btn>
          </v-card-actions>


          <v-btn
          class="absolute top-0 right-0 ma-5"
          style="position: absolute; top: 0; right: 0;"
          @click="confirmDelete(advocacy.id);"
          outlined
          color="red-lighten-1"
          :size="30"
          icon>
            <v-icon :size="20">
              mdi-delete
            </v-icon>
          </v-btn>
        </v-card>

        <!-- Add New Advocacy Form -->
        <v-card
        v-if="addingNewAdvocacy"
        class="custom-card w-[80%] d-flex flex-col ga-5 items-center elevation-10 px-15 py-10 border rounded-lg elevation-10">
            <!-- Title Section -->
            <v-card-title class="w-[90%] d-flex align-center justify-center ga-5 border-b py-5">
              <h2 class="font-extrabold text-2xl">ADD NEW ADVOCACY</h2>
            </v-card-title>

            <!-- Advocacy Image, Title and Subtitle -->
            <div class="w-full d-flex justify-evenly items-center ga-5 border-b">
                <div class="w-2/6 d-flex justify-center items-center relative">
                  <v-img 
                      class="w-full elevation-5 rounded-lg"   
                      :src="newAdvocacy.preview ? newAdvocacy.preview : ($store.getters.base + 'public/AdvocacyImages/' + (newAdvocacy.thumbnail ? newAdvocacy.thumbnail : 'no-avatar.png'))"    
                  ></v-img>

                  <v-btn 
                  @click="triggerFileInput();"
                  class="bottom-0 right-0 ma-2"
                  style="position: absolute;"
                  icon>
                    <v-icon size="20">
                        mdi-camera
                    </v-icon>
                  </v-btn>
                </div>

                <div class="w-4/6 d-flex flex-col justify-center items-center py-5 ga-2">
                    <!-- Advocacy Title Textarea -->
                    <v-textarea
                    class="w-full text-lg font-extrabold text-center"
                    v-model="newAdvocacy.title"
                    label="Advocacy Title"
                    variant="outlined"
                    auto-grow
                    rows="1"
                    clearable>
                    </v-textarea>

                    <!-- New Advocacy Subtitle Textarea -->
                    <v-textarea 
                    v-model="newAdvocacy.subtitle"
                    class="w-full" 
                    label="Advocacy Subtitle" 
                    variant="outlined"
                    auto-grow 
                    rows="2">
                    </v-textarea>
                </div>
            </div>

            <!-- newAdvocacy Details -->
            <v-textarea 
            v-model="newAdvocacy.detail"
            class="w-full text-justify" 
            label="Advocacy Details" 
            auto-grow 
            hide-details
            rows="3">
            </v-textarea>

            
            <!-- Action Buttons: Save/Discard -->
            <v-card-actions 
            class="w-full d-flex justify-center items-center gap-10 pt-5 border-t"
            style="position: relative; bottom: 0;">
              <v-btn color="red-lighten-1" @click="newAdvocacy = {}; addingNewAdvocacy = false">CANCEL</v-btn>
              <v-btn color="teal-lighten-1" @click="saveChanges('add')">SAVE</v-btn>
          </v-card-actions>
        </v-card>
      </v-container>

      <!-- Button to add new platform -->
      <v-btn
        class="d-flex items-center justify-center px-15 py-10 text-lg"
        elevation="10"
        @click="addingNewAdvocacy = true"
        >
          <v-icon>mdi-plus-circle-outline</v-icon>
          <span class="ml-2">ADD NEW ADVOCACY</span>
      </v-btn>

    </v-card>

    <!-- File Upload Input -->
    <input
    ref="fileInput"
    type="file"
    accept="image/*"
    class="hidden"
    @change="handleFileUpload"
    />
</template>

<style scoped>   
</style>   



  