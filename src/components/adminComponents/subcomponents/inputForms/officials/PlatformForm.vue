<script>
  import $ from 'jquery';

  export default {
    name: "PlatformForm",

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
      <v-container class="d-flex flex-row flex-wrap justify-evenly pa-5">
        <v-card
        v-for="n of 2"
        class="custom-card d-flex flex-col ga-5 justify-evenly items-center w-[40%] border rounded-lg elevation-10">

            <!--Platform Image, Title and Subtitle -->
            <div class="w-[90%] d-flex justify-center items-center ga-5">
                <div class="w-full d-flex flex-col justify-center items-center py-5 ga-2">
                  <!-- Platform Selector -->
                  <v-select
                  class="w-full"
                  label="Choose an Advocacy"
                  />

                  <!--Platform Title Textarea -->
                  <v-textarea
                  class="w-full text-lg font-extrabold text-center"
                  label="Platform Title"
                  variant="outlined"
                  auto-grow
                  rows="1"
                  clearable>
                  </v-textarea>

                  <!--Platform Subtitle Textarea -->
                  <v-textarea 
                  class="w-full" 
                  label="Platform Subtitle" 
                  variant="outlined"
                  auto-grow 
                  rows="2">
                  </v-textarea>

                <!--Platform Details -->
                <v-textarea 
                class="w-full text-justify" 
                label="Platform Details" 
                auto-grow 
                rows="3">
                </v-textarea>

                </div>
            </div>



            
            <!-- Action Buttons: Save/Discard -->
            <!-- <v-card-actions 
            class="w-full d-flex justify-center items-center gap-10 pt-5 border-t"
            style="position: relative; bottom: 0;">
              <v-btn color="red-lighten-1" @click="discardChanges">Discard Changes</v-btn>
              <v-btn color="teal-lighten-1" @click="saveChanges">Save Changes</v-btn>
          </v-card-actions> -->
        </v-card>
      </v-container>

      <!-- Button to add new platform -->
      <v-btn
        class="d-flex items-center justify-center px-15 py-10 text-lg"
        elevation="10"
        >
          <v-icon>mdi-plus-circle-outline</v-icon>
          <span class="ml-2">ADD PLATFORM</span>
      </v-btn>
    </v-card>
</template>

<style scoped>   
</style>   



  