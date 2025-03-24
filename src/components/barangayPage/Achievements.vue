<template>
    <v-container fluid class="achievement-main pa-0 ma-0 mb-15">
      <h1 class="gradient-text font-black uppercase py-10">Achievements</h1>
      <div class="achievements">
        <v-card elevation="15" 
            v-for="(achievement, index) in achievements" :key="index"
            class="card"
        >
          <img :src="`/public/achievements/${achievement.img}`" alt="" class="elevation-10">
          
          <article class="relative pb-5">
            <h3 class="text-lg uppercase font-extrabold">{{ achievement.title }}</h3>
            <h5 class="text-base">{{ achievement.subtitle }}</h5>
            <h5>{{ achievement.sk_official_id }}</h5>
            <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-1">{{ formatDate(achievement.date) }}</h5>
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
    props: {
      barangayId: {
        type: Number,
        required: true
      }
    },
    data() {
      return {
        myBarangayId: this.barangayId,
        showStates: [],
        achievements: []  // Initialize as an array, not a string.
      };
    },
    methods: {
      toggleShow(index) {
        this.showStates[index] = !this.showStates[index];
        // No need for $forceUpdate(), Vue should handle reactivity.
      },
      formatDate(dateStr) {
        if (!dateStr) return '';
          const date = new Date(dateStr);
          return date.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
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
            barangayId: this.myBarangayId,
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
  .achievements {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    align-items: flex-start;
    gap: 5rem;
    padding: 0rem 9rem;
  }

  h1 {
    font-size: 2.5rem;
    background: linear-gradient(
    45deg,
    #0533a0,
    #ffffff,
    #DF2935,
    #FDCA40,
    );
    background: linear-gradient(to left, #3772FF, #fffefe, #DF2935, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animate-gradient 4s linear infinite;
  }
  
  @keyframes animate-gradient {
  from {
    background-position: 200% 50%;
  }
  to {
    background-position: 0% 50%;
  }
}
  .card {
    width: 400px;
    border-radius: 1.5rem;
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
  
  
  article {
    width: 90%;
  }
  </style>
  