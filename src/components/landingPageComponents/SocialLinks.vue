<template>
    <v-sheet class="social-links" elevation="10">  
      <v-sheet class="d-flex flex-column justify-center items-center gap-5">
        <v-btn icon href="https://www.facebook.com/profile.php?id=100078971831746" target="_blank" rel="noopener noreferrer" size="30">
          <v-avatar :image="$store.getters.base + 'public/fb.png'" size="30"></v-avatar>      
        </v-btn>
  
        <v-btn icon size="30">
          <v-avatar :image="$store.getters.base + 'public/insta.png'" size="30"></v-avatar>
        </v-btn>

        <v-btn icon size="30">
          <v-avatar class="bg-white" :image="$store.getters.base + 'public/yt.png'" size="30"></v-avatar>
        </v-btn>

        <v-btn icon size="30">
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

    },
    computed: {
    },
    methods: {
    }
  };
  </script>
  
  <style scoped>
  .social-links {
    position: fixed;
    bottom: 5%;
    left: 5%;
    z-index: 3;
    padding: 1rem 1rem;
    border-radius: .5rem;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    align-items: center;
  }

  </style>
  