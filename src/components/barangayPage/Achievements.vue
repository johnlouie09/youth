<template>
    <v-container fluid class="achievement-main pa-0 ma-0">
      <h1 class="gradient-text mb-9">Achievements</h1>
      <div class="achievements">
        <v-card elevation="15" 
            v-for="(achievement, index) in achievements" :key="index"
            class="card"
        >
          <img :src="`/public/achievements/${achievement.img}`" alt="" class="elevation-10">
          
          <article>
            <h3>{{ achievement.title }}</h3>
            <h5>{{ achievement.subtitle }}</h5>
          </article>
  
          <v-expand-transition>
            <div v-show="showStates[index]">
              <v-divider></v-divider>
              <v-card-text>
                {{ achievement.info }}
              </v-card-text>
            </div>
          </v-expand-transition>
          
          <v-btn @click="toggleShow(index)" color="green-darken-3">
            {{ showStates[index] ? 'Show Less' : 'Show More' }}
          </v-btn>
        </v-card>
      </div>
    </v-container>
  </template>
  
  <script>
  import $ from 'jquery';
  
  export default {
    data() {
      return {
        showStates: [],
        achievements: []  // Initialize as an array, not a string.
      };
    },
    methods: {
      toggleShow(index) {
        this.showStates[index] = !this.showStates[index];
        // No need for $forceUpdate(), Vue should handle reactivity.
      },
      async fetchBarangayAchievements() {
        const api_base = 'http://localhost/youth/app/api.php';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        await $.ajax({
          url: `${api_base}?e=barangay&a=achievements`,
          type: 'POST',
          xhrFields: {
            withCredentials: true
          },
          headers: {
            'X-CSRF-Token': csrfToken
          },
          data: {
            barangayId: this.$route.params.barangayId,
          },
          success: (data) => {
            this.achievements = data.data.achievements;
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
            let errorMsg = "An error occurred while processing your request.";
            if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
              errorMsg = jqXHR.responseJSON.message;
            } else if (jqXHR.responseText) {
              errorMsg = jqXHR.responseText;
            }
          },
          complete: () => {
            // Optional: any actions after completion.
          }
        });
      }
    },
    created() {
      // Initialize achievements as an empty array so that .map() works.
      this.achievements = [];
      this.fetchBarangayAchievements();
    },
    watch: {
      achievements: {
        handler(newAchievements) {
          if (Array.isArray(newAchievements)) {
            this.showStates = newAchievements.map(() => false);
          } else {
            this.showStates = [];
          }
        },
        immediate: true
      }
    }
  };
  </script>
  
  <style scoped>
  @import "../../assets/Achievements.css";
  @import "../../assets/fontEffects.css";
  
  .achievements {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    align-items: flex-start;
    gap: 5rem;
    padding: 0rem 9rem;
  }
  
  .card {
    width: 400px;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    transition: transform 0.3s ease-in-out, border 0.3s ease-in-out;
    padding-bottom: 2rem;
  }
  
  .card:hover {
    transform: scale(1.07);
  }
  
  .card img {
    width: 100%;
  }
  
  article h3 {
    text-transform: uppercase;
    font-size: 1.25rem;
    font-weight: 900;
  }
  
  article {
    width: 90%;
  }
  
  article h4 {
    font-size: 0.75rem;
  }
  
  article p {
    max-height: 90px;
    font-size: 0.75rem;
    overflow: hidden;
  }
  </style>
  