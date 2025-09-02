<script>
  import $ from 'jquery';
import { update } from 'lodash';
import { initial } from 'lodash';

  export default {
    name: "PlatformForm",
    props: {
      advocacies: {
        type: Array,
        required: true,
        default: () => []
      },
      platforms: {
        type: Array,
        required: false,
        default: () => []
      }
    },
    emits: ['fetchOfficialInfo'],
    data() {
      {
        return {
          advocaciesItems: [],
          initialPlatformsInfo: [],
          platformsInfo: [],
          newPlatform: {},
          addingNewPlatform: false,

        }
      }
    },
    methods: {
      // Button events method
      saveChanges(action, PlatformObj) {
        if(action === 'update') {
          this.updatePlatform(PlatformObj);
        }
        else if(action === 'add') {
          this.addPlatform(this.newPlatform); 
        } 
      },

      updatePlatform(platformObj) {
        $.ajax({
          url: `${this.$store.getters.api_base}?e=sk-official&a=updatePlatform`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
          data: { platformInfo: platformObj },
          success: (data) => {
            console.log(data);
            this.$emit('fetchOfficialInfo', true);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
          }
        });
      },

      addPlatform(newPlatform) {
        $.ajax({
          url: `${this.$store.getters.api_base}?e=sk-official&a=addPlatform`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
          data: { platformInfo: newPlatform, sk_official_id: this.sk_id },
          success: (data) => {
            console.log(data);
            this.$emit('fetchOfficialInfo');
            this.addingNewPlatform = false;
            this.newPlatform = {}; // Reset the form
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
          }
        });
      },

      deletePlatform(platformId) {
        $.ajax({
          url: `${this.$store.getters['api_base']}?e=sk-official&a=deletePlatform`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
          },
          data: { id: platformId },
          success: (data) => {
            console.log("Platform deleted successfully", data);
            // Emit event to refresh official information
            this.$emit('fetchOfficialInfo', true);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error deleting achievement:", textStatus, errorThrown);
          }
        });
      },




      // Helper Methods
      /** Shows a confirmation dialog for deletion and, if confirmed, calls the deleteAchievement method. */
      async confirmDelete(platformId) {
        this.$store.commit('dialog/confirm/show', {
          title: 'Delete Platform',
          prompt: 'Are you sure you want to delete this Platform?',
          color: 'red',
          yesText: 'Delete',
          noText: 'Cancel',
          onConfirm: async () => {
            await this.deletePlatform(platformId);
          },
          onCancel: () => {
            console.log('Deletion cancelled');
          }
        });
      },



    },
    watch: {
      advocacies: {
        handler(newAdvocacies) {
          this.advocaciesItems = newAdvocacies.map(advocacy => ({
            title: advocacy.title,
            value: advocacy.id
          }));
        },
        immediate: true
      },
      platforms: {
        handler(newPlatforms) {
          this.initialPlatformsInfo = JSON.parse(JSON.stringify(newPlatforms));
          this.platformsInfo = JSON.parse(JSON.stringify(newPlatforms));
        },
        immediate: true
      }
    },

  };
</script>

<template>
    <v-card class="w-[80%] d-flex flex-col justify-start items-center rounded-2xl pa-10 ga-5">
      <!-- Title Section -->
      <v-card-title class="w-[90%] d-flex align-center justify-center ga-5 border-b py-5">
        <v-icon size="40">mdi-trophy</v-icon>
        <h2 class="font-extrabold text-2xl">PLATFORMS</h2>
        <v-icon size="40">mdi-trophy</v-icon>
      </v-card-title>

      <!-- Form Section -->
      <v-container class="d-flex flex-row flex-wrap ga-10 justify-evenly pa-5">

        <!-- Existing Platforms Cards -->
        <v-card
        v-for="( platform, index ) in platformsInfo"
        class="custom-card h-auto d-flex flex-col ga-3 justify-start items-center w-[40%] border rounded-lg elevation-10 overflow-visible">

            <!--Platform Image, Title and Subtitle -->
            <div class="w-[90%] d-flex justify-center items-center ga-5">
                <div class="w-full d-flex flex-col justify-center items-center py-5 ga-2">
                  <!-- Platform Selector -->
                  <v-select
                    v-model="platform.sk_advocacy_id"
                    :items="advocaciesItems"
                    item-title="title"
                    item-value="value"
                    class="w-full"
                    label="Choose an Advocacy"
                  />


                  <!--Platform Title Textarea -->
                  <v-textarea
                  v-model="platform.title"
                  class="w-full text-lg font-extrabold text-center"
                  label="Platform Title"
                  variant="outlined"
                  auto-grow
                  rows="1"
                  clearable>
                  </v-textarea>

                <!--Platform Details -->
                <v-textarea 
                v-model="platform.detail"
                class="w-full text-justify" 
                label="Platform Details" 
                auto-grow 
                rows="3"
                hide-details="auto">
                </v-textarea>

                </div>
            </div>
            
          <!-- Action Buttons: Save/Discard -->
          <v-card-actions 
          class="w-[90%] d-flex justify-center items-center gap-10 py-5 border-t text-sm"
          v-if="JSON.stringify(platform) !== JSON.stringify(initialPlatformsInfo[index])"
          style="position: relative; bottom: 0;">
            <v-btn color="red-lighten-1" @click="platformsInfo[index] = JSON.parse(JSON.stringify(initialPlatformsInfo[index]))">Discard Changes</v-btn>
            <v-btn color="teal-lighten-1" @click="saveChanges('update', platform)">Save Changes</v-btn>
          </v-card-actions>

          <v-btn
          class="absolute top-0 right-0"
          style="position: absolute; top: 0; right: 0; margin: -10px;"
          @click="confirmDelete(platform.id);"
          outlined
          color="red-lighten-1"
          :size="30"
          icon>
            <v-icon :size="20">
              mdi-delete
            </v-icon>
          </v-btn>


        </v-card>


        <!-- Add New Plaform Form -->
        <v-card
        v-if="addingNewPlatform"
        class="custom-card h-auto d-flex flex-col ga-3 justify-start items-center w-[40%] border rounded-lg elevation-10 overflow-visible">
          
        <!-- Title Section -->
          <v-card-title class="w-[90%] d-flex align-center justify-center border-b py-5">
            <h2 class="font-extrabold text-sm">ADD NEW PLATFORM</h2>
          </v-card-title>

          <!--Platform Image, Title and Subtitle -->
          <div class="w-[90%] d-flex justify-center items-center ga-5">
              <div class="w-full d-flex flex-col justify-center items-center py-5 ga-2">
                <!-- Platform Selector -->
                <v-select
                  v-model="newPlatform.sk_advocacy_id"
                  :items="advocaciesItems"
                  item-title="title"
                  item-value="value"
                  class="w-full"
                  label="Choose an Advocacy"
                />


                <!--newPlatform Title Textarea -->
                <v-textarea
                v-model="newPlatform.title"
                class="w-full text-lg font-extrabold text-center"
                label="Platform Title"
                variant="outlined"
                auto-grow
                rows="1"
                clearable>
                </v-textarea>

              <!--newPlatform Details -->
              <v-textarea 
              v-model="newPlatform.detail"
              class="w-full text-justify" 
              label="Platform Details" 
              auto-grow 
              rows="3"
              hide-details="auto">
              </v-textarea>

              </div>
          </div>
            
          <!-- Action Buttons: Save/Discard -->
          <v-card-actions 
          class="w-[90%] d-flex justify-center items-center gap-10 py-5 border-t text-sm"
          style="position: relative; bottom: 0;">
            <v-btn color="red-lighten-1" @click="newPlatform = {}; addingNewPlatform = false">CANCEL</v-btn>
            <v-btn color="teal-lighten-1" @click="saveChanges('add', newPlatform)">Save</v-btn>
          </v-card-actions>
        </v-card>



      </v-container>

      <!-- Button to add new platform -->
      <v-btn
        class="d-flex items-center justify-center px-15 py-10 text-lg"
        @click="addingNewPlatform = true"
        elevation="10"
        >
          <v-icon>mdi-plus-circle-outline</v-icon>
          <span class="ml-2">ADD NEW PLATFORM</span>
      </v-btn>
    </v-card>
</template>

<style scoped>   
</style>   



  