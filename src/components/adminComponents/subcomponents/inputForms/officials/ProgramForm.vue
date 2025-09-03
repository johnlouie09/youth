<script>
  import $ from 'jquery';
import { get } from 'jquery';

  export default {
    name: "ProgramForm",
    props: {
      platforms: {
        type: Array,
        required: true,
        default: () => []
      },
      programs: {
        type: Array,
        required: false,
        default: () => []
      }
    },
    emits: ['fetchOfficialInfo'],
    data() {
      return {
        platformsItems : [],
        initialProgramsInfo : [],
        programsInfo : [],
        newProgram: {},
        editingProgramIndex: null,
        addingNewProgram: false,
      };
    },
    methods: {
      saveChanges(action, program) {
        if(action === 'add') {
          this.addProgram(program);
        }
        else if(action === 'update') {
          this.updateProgram(program);
        }
      },

      // AJAX METHODS
      addProgram(program) {
        const formData = new FormData();
        delete program.preview;
        formData.append('programInfo', JSON.stringify(program));
        if(program.file) {
          formData.append('file', program.file);
        }

        $.ajax({
          url: `${this.$store.getters.api_base}?e=sk-official&a=addProgram`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
          data: formData,
          processData: false,
          contentType: false,
          success: (data) => {
            console.log(data);
            this.newProgram = {};
            this.addingNewProgram = false;
            this.$emit('fetchOfficialInfo');
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
          }
        });
      },

      
      updateProgram(program) {
        const formData = new FormData();
        delete program.preview;
        formData.append('programInfo', JSON.stringify(program));
        if(program.file) {
          formData.append('file', program.file);
        }

        formData.append('programInfo', JSON.stringify(program));
        $.ajax({
          url: `${this.$store.getters.api_base}?e=sk-official&a=updateProgram`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
          data: formData,
          processData: false,
          contentType: false,
          success: (data) => {
            console.log(data);
            this.$emit('fetchOfficialInfo');
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
          }
        });
      },

      deleteProgram(programId) {
        $.ajax({
          url: `${this.$store.getters.api_base}?e=sk-official&a=deleteProgram`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
          data: { id: programId },
          success: (data) => {
            console.log(data);
            this.$emit('fetchOfficialInfo');
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
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

        if(this.newProgram && this.editingProgramIndex === null) {
          // Clear previous values
          this.newProgram.file = null;
          this.newProgram.preview = null;
          this.newProgram.thumbnail = null;

          // Save file reference
          this.newProgram.file = selectedFile;

          reader.onload = (e) => {
            this.newProgram.preview =  e.target.result; // Store the preview
            this.newProgram.thumbnail = selectedFile.name; // Store file name or handle as needed
          };
          
          reader.readAsDataURL(selectedFile);
          return;
        } 
        else {
          // Clear previous values
          this.programsInfo[this.editingProgramIndex].file = null;
          this.programsInfo[this.editingProgramIndex].preview = null;
          this.programsInfo[this.editingProgramIndex].thumbnail = null;

          // Save file reference
          this.programsInfo[this.editingProgramIndex].file = selectedFile;

          reader.onload = (e) => {
            this.programsInfo[this.editingProgramIndex].preview =  e.target.result; // Store the preview
            this.programsInfo[this.editingProgramIndex].thumbnail = selectedFile.name; // Store file name or handle as needed
          };
          
          reader.readAsDataURL(selectedFile);
        }
      },


      // HELPER METHODS
      /** Shows a confirmation dialog for deletion and, if confirmed, calls the deleteProgram method. */
      async confirmDelete(programId) {
        this.$store.commit('dialog/confirm/show', {
          title: 'Delete Program',
          prompt: 'Are you sure you want to delete this program?',
          color: 'red',
          yesText: 'Delete',
          noText: 'Cancel',
          onConfirm: async () => {
            await this.deleteProgram(programId);
          },
          onCancel: () => {
            console.log('Deletion cancelled');
          }
        });
      },

      getImageSrc(program) {
        if(program?.preview) {
          return program.preview;
        } else if(program?.thumbnail) {
          return this.$store.getters.base + 'public/programImages/' + program.thumbnail;
        } else {
          return this.$store.getters.base + 'public/programImages/no-avatar.png';
        }
      }
    },
    watch: {
      platforms: {
        handler(newPlatforms) {
          this.platformsItems = newPlatforms.map(platform => ({
            title: platform.title,
            value: platform.id
          }));
        },
        immediate: true,
        deep: true
      },
      programs: {
        handler(newPrograms) {
          this.programsInfo = JSON.parse(JSON.stringify(newPrograms));
          this.initialProgramsInfo = JSON.parse(JSON.stringify(newPrograms));
        },
        immediate: true,
        deep: true
      }
    },
   created(){
      this.programsInfo = JSON.parse(JSON.stringify(this.programs));
      this.initialProgramsInfo = JSON.parse(JSON.stringify(this.programs));
    }

  };
</script>

<template>
    <v-card class="w-[80%] d-flex flex-col justify-start items-center rounded-2xl pa-10">
      <!-- Title Section -->
      <v-card-title class="w-full d-flex align-center justify-center ga-5 border-b py-5">
        <v-icon size="40">mdi-trophy</v-icon>
        <h2 class="font-extrabold text-2xl">PROGRAMS</h2>
        <v-icon size="40">mdi-trophy</v-icon>
      </v-card-title>

      <!-- Form Section -->
      <v-container class="grid grid-cols-2 ga-10 pa-10">

        <!-- Existing Programs Cards -->
        <v-card
        v-for="( program, index ) in programsInfo"
        class="custom-card col-span-1 d-flex flex-col items-center pa-10 border rounded-lg elevation-10">

            <!-- Program Image, Title and Subtitle -->
            <div class="w-[90%] d-flex flex-col justify-center items-center ga-5">
              <div class="relative w-full d-flex justify-center items-center">
                <v-img 
                class="elevation-5 rounded-lg"       
                :src="getImageSrc(program)"    
                cover 
                />

                <v-btn 
                @click="triggerFileInput(); editingProgramIndex = index"
                class="bottom-0 right-0 ma-2"
                style="position: absolute;"
                icon>
                  <v-icon size="20">
                      mdi-camera
                  </v-icon>
                </v-btn>
              </div>
                

                <div class="w-full d-flex flex-col justify-center items-center">

                  <!-- Platform Selector -->
                  <v-select
                  v-model="program.sk_platform_id"
                  :items="platformsItems"
                  item-title="title"
                  item-value="value"
                  class="w-full"
                  label="Choose a Platform"
                  />
                  
                  
                  <!-- Program Title Textarea -->
                  <v-textarea
                  v-model="program.title"
                  class="w-full text-lg font-extrabold text-center"
                  label="Program Title"
                  variant="outlined"
                  auto-grow
                  rows="1"
                  clearable>
                  </v-textarea>

                  <!-- Program Subtitle Textarea -->
                  <v-textarea 
                  v-model="program.subtitle"
                  class="w-full" 
                  label="Program Subtitle" 
                  variant="outlined"
                  auto-grow 
                  rows="1">
                  </v-textarea>

                  <!-- Program Details -->
                  <v-textarea 
                  v-model="program.detail"
                  class="w-full text-justify" 
                  label="Program Details" 
                  auto-grow 
                  rows="3">
                  </v-textarea>
                </div>
            </div>

            <!-- Action Buttons: Save/Discard -->
            <v-card-actions 
            class="w-full d-flex justify-center items-center gap-10 pt-5 border-t"
            style="position: relative; bottom: 0;"
            v-if="JSON.stringify(program) !== JSON.stringify(initialProgramsInfo[index])"
            >
              <v-btn color="red-lighten-1" @click="programsInfo[index] = JSON.parse(JSON.stringify(initialProgramsInfo[index]))">Discard Changes</v-btn>
              <v-btn color="teal-lighten-1" @click="saveChanges('update', program)">Save Changes</v-btn>
            </v-card-actions>


            <!-- Delete Button -->
            <v-btn
            class="absolute top-0 right-0 ma-5"
            style="position: absolute; top: 0; right: 0;"
            @click="confirmDelete(program.id);"
            outlined
            color="red-lighten-1"
            :size="30"
            icon>
              <v-icon :size="20">
                mdi-delete
              </v-icon>
            </v-btn>


        </v-card>


        <!-- Add New Program Card -->
        <v-card
        v-if="addingNewProgram"
        class="custom-card col-span-1 d-flex flex-col items-center ga-3 pa-10 border rounded-lg elevation-10">

            <v-card-title class="w-[90%] d-flex align-center justify-center border-b py-3">
              <h2 class="font-extrabold text-sm">ADD NEW PROGRAM</h2>
             </v-card-title>

            <!-- Program Image, Title and Subtitle -->
            <div class="w-[90%] d-flex flex-col justify-center items-center ga-5">
              <div class="relative w-full d-flex justify-center items-center">
                <v-img 
                class="w-[50%] elevation-5 rounded-lg"       
                :src="newProgram.preview ? newProgram.preview : newProgram.thumbnail ? ($store.getters.base + 'public/programImages/' + newProgram.thumbnail) : ($store.getters.base + 'public/programImages/no-avatar.png')"    
                cover 
                />


                <v-btn 
                @click="triggerFileInput(); editingProgramIndex = null"
                class="bottom-0 right-0 ma-2"
                style="position: absolute;"
                icon>
                  <v-icon size="20">
                      mdi-camera
                  </v-icon>
                </v-btn>
              </div>


                <div class="w-full d-flex flex-col justify-center items-center">

                  <!-- Platform Selector -->
                  <v-select
                  v-model="newProgram.sk_platform_id"
                  :items="platformsItems"
                  item-title="title"
                  item-value="value"
                  class="w-full"
                  label="Choose a Platform"
                  />
                  
                  
                  <!-- Program Title Textarea -->
                  <v-textarea
                  v-model="newProgram.title"
                  class="w-full text-lg font-extrabold text-center"
                  label="Program Title"
                  variant="outlined"
                  auto-grow
                  rows="1"
                  clearable>
                  </v-textarea>

                  <!-- Program Subtitle Textarea -->
                  <v-textarea 
                  v-model="newProgram.subtitle"
                  class="w-full" 
                  label="Program Subtitle" 
                  variant="outlined"
                  auto-grow 
                  rows="1">
                  </v-textarea>

                  <!-- Program Details -->
                  <v-textarea 
                  v-model="newProgram.detail"
                  class="w-full text-justify" 
                  label="Program Details" 
                  auto-grow 
                  rows="3">
                  </v-textarea>
                </div>
            </div>

            <!-- Action Buttons: Save/Discard -->
            <v-card-actions 
            class="w-full d-flex justify-center items-center gap-10 pt-5 border-t"
            style="position: relative; bottom: 0;"
            >
              <v-btn color="red-lighten-1" @click="newProgram = {}; addingNewProgram = false">CANCEL</v-btn>
              <v-btn color="teal-lighten-1" @click="saveChanges('add', newProgram)">SAVE</v-btn>
            </v-card-actions>


            <!-- Delete Button -->
            <v-btn
            class="absolute top-0 right-0 ma-5"
            style="position: absolute; top: 0; right: 0;"
            @click="confirmDelete(program.id);"
            outlined
            color="red-lighten-1"
            :size="30"
            icon>
              <v-icon :size="20">
                mdi-delete
              </v-icon>
            </v-btn>


        </v-card>
      </v-container>

      <!-- Button to add new Program -->
      <v-btn
      @click="addingNewProgram = true"
      class="d-flex items-center justify-center px-15 py-10 text-lg"
      elevation="10"
        >
          <v-icon>mdi-plus-circle-outline</v-icon>
          <span class="ml-2">ADD NEW PROGRAM</span>
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



  