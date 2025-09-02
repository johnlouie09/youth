<script>
  import $ from 'jquery';

  export default {
    name: "ProgramForm",

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
          <v-card
          v-for="n of 2"
          class="custom-card col-span-1 d-flex flex-col items-center pa-10 border rounded-lg elevation-10">

              <!-- Program Image, Title and Subtitle -->
              <div class="w-[90%] d-flex flex-col justify-center items-center ga-5">
                  <v-img 
                      class="w-[50%] elevation-5 rounded-lg"       
                      :src="$store.getters.base + 'Flogo.svg'"    
                  ></v-img>

                  <div class="w-full d-flex flex-col justify-center items-center">

                    <!-- Platform Selector -->
                    <v-select
                    class="w-full"
                    label="Choose a Platform"
                    />
                    
                    
                    <!-- Program Title Textarea -->
                    <v-textarea
                    class="w-full text-lg font-extrabold text-center"
                    label="Program Title"
                    variant="outlined"
                    auto-grow
                    rows="1"
                    clearable>
                    </v-textarea>

                    <!-- Program Subtitle Textarea -->
                    <v-textarea 
                    class="w-full" 
                    label="Program Subtitle" 
                    variant="outlined"
                    auto-grow 
                    rows="1">
                    </v-textarea>

                    <!-- Program Details -->
                    <v-textarea 
                    class="w-full text-justify" 
                    label="Program Details" 
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

      <!-- Button to add new Program -->
      <v-btn
        class="d-flex items-center justify-center px-15 py-10 text-lg"
        elevation="10"
        >
          <v-icon>mdi-plus-circle-outline</v-icon>
          <span class="ml-2">ADD PROGRAM</span>
      </v-btn>
    </v-card>
</template>

<style scoped>   
</style>   



  