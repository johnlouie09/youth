<template>
    <v-sheet class="social-links" elevation="10">
      <div class="text-xs text-grey italic">
        FOLLOW US IN OUR BARANGAY SOCIALS
      </div>  
      <v-sheet class="d-flex flex-row justify-between items-center w-full ga-5">
        <v-btn icon href="https://www.facebook.com/profile.php?id=100078971831746" target="_blank" rel="noopener noreferrer" size="40">
          <v-avatar :image="$store.getters.base + 'fb.png'"></v-avatar>      
        </v-btn>
  
        <v-btn icon size="40">
          <v-avatar class="w-full h-full" :image="$store.getters.base + 'insta.png'"></v-avatar>
        </v-btn>

        <v-btn icon size="40">
          <v-avatar class="w-full h-full" :image="$store.getters.base + 'yt.png'" ></v-avatar>
        </v-btn>

        <v-btn icon size="40">
          <v-icon>mdi-link-variant</v-icon>
        </v-btn>
      </v-sheet>
    </v-sheet>
  
    
  </template>
  
  <script>
  import ThemeSwitcher from '../ThemeSwitcher.vue';
  
  export default {
    name: 'SocialLinks',
    components: { ThemeSwitcher },
    data() {
      return {}
    },
    computed: {
    },
    methods: {
    }
  };
  </script>
  
  <style scoped>
  .social-links {
    /* position: fixed;
    bottom: 5%;
    left: 5%; */

    /* position: relative; */


    z-index: 3;
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    height: auto;
  }

  </style>
  