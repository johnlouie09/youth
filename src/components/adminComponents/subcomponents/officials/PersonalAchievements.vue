<template>
    <v-card class="achievements-section" elevation="5">
      <v-card-title class="title d-flex align-center justify-center">
        <v-icon class="me-2" size="30">mdi-trophy</v-icon>
        <h2 class="mb-0">PERSONAL ACHIEVEMENTS</h2>
      </v-card-title>
  
      <div class="achievements-cards">
        <v-container class="d-flex flex-row flex-wrap justify-evenly pa-5 pt-0 ga-10">
          <v-card elevation="5" 
            v-for="(achievement, index) in achievements"
            :key="index"
            class="w-[30%] min-w-[250px] rounded-lg d-flex flex-col items-center overflow-hidden pb-10"
            @mouseover="hoverIndex = index"
            @mouseleave="hoverIndex = null"
          >
            <img :src="`/public/achievements/${achievement.img}`" alt="" class="elevation-5 w-full rounded-t-lg">
            <article class="d-flex flex-col items-start w-[90%] ma-5">
              <h3 class="uppercase text-xs font-extrabold">{{ achievement.title }}</h3>
              <h5 class="text-[.75rem] font-medium">{{ achievement.subtitle }}</h5>
              <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-5">{{ formatDate(achievement.date) }}</h5>
            </article>
            <transition name="fade">
              <div v-if="hoverIndex === index" class="achievement-card-actions">
                <v-icon class="edit-icon" size="25" @click="editAchievement(index)">mdi-pencil-circle</v-icon>
                <v-icon class="delete-icon" size="25" @click="confirmDelete(achievement.id)">mdi-delete-circle</v-icon>
              </div>
            </transition>
  
            <FormAchievement
              v-if="editingIndex === index"
              :action="'updating'"
              :achievement="achievement"
              @close="editingIndex = null"
              @fetchAchievement="handleChildEvent(true)"
            />
          </v-card>
        </v-container>


        <v-btn class="d-flex items-center justify-center px-10 py-10 text-lg" elevation="10" @click="showNewAchievement = true">
            <v-icon>mdi-plus-circle-outline</v-icon>
            <span class="ml-4">ADD PERSONAL ACHIEVEMENT</span>
        </v-btn>
      </div>
  
      <!-- New Achievement Dialog -->
      <FormAchievement
        v-if="showNewAchievement"
        :achievement="{ sk_official_id : this.id}"
        :action="'adding'"
        @close="showNewAchievement = false"
        @fetchAchievement="handleChildEvent(true)"
      />
    </v-card>

    <Dialogs></Dialogs>
  </template>
  
  <script>
  import FormAchievement from './InputForms/FormAchievement.vue';
  import Dialogs from '@/components/dialogs/Dialogs.vue';
  import $ from 'jquery';
  
  export default {
    components: {
      FormAchievement,
      Dialogs
    },
    props: {
      achievements: Object,
      id: Number
    },
    emits: ['fetchOfficialInfo'],
    data() {
      return {
        hoverIndex: null,
        editingIndex: null,
        personalAchievements: [],
        showNewAchievement: false  // flag to show new achievement form
      };
    },
    methods: {
      editAchievement(index) {
        this.editingIndex = index;
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
      handleChildEvent(payload) {
        // Close new achievement form after update
        this.showNewAchievement = false;
        // Emit event to refresh official info if needed
        this.$emit('fetchOfficialInfo', payload);
      },
      async confirmDelete(achievementId) {
        this.$store.commit('dialog/confirm/show', {
          title: 'Delete Achievement',
          prompt: 'Are you sure you want to delete this achievement?',
          color: 'red',
          yesText: 'Delete',
          noText: 'Cancel',
            onConfirm: async () => {
              // Call the deletion method if confirmed
              await this.deleteAchievement(achievementId);
            },
            onCancel: () => {
              // Optionally handle cancellation
              console.log('Deletion cancelled');
            }
        });
      },
      deleteAchievement(achievementId) {
        // Send an AJAX request to delete the achievement
        $.ajax({
          url: `${this.$store.getters['api_base']}?e=sk-official&a=deleteAchievement`,
          type: 'POST',
          xhrFields: { withCredentials: true },
          headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
          },
          data: { id: achievementId },
          success: (data) => {
            console.log("Achievement deleted successfully", data);
            // Optionally, refresh the achievements list:
            this.$emit('fetchOfficialInfo', true);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error deleting achievement:", textStatus, errorThrown);
          }
        });
      },
    },
    watch: {
      achievements: {
        immediate: true,
        handler(newVal) {
          this.personalAchievements = { ...newVal };
        },
        deep: true
      }
    }
  };
  </script>
  
  <style scoped>
  .achievements-section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 80%;
    border-radius: 1rem;
    padding: 2rem 0;
    gap: 3rem;
  }
  
  .achievements-cards {
    padding: 0 6rem;
    display: flex;
    align-items: flex-start;
    justify-content: space-evenly;
    gap: 2rem;
    flex-wrap: wrap;
  }
  
  .card article {
    width: 90%;
  }
  
  .achievement-card-actions {
    position: absolute;
    bottom: 0;
    left: 0;
    padding: 1rem;
    display: flex;
    gap: 10px;
  }
  
  .edit-icon, .delete-icon {
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
  }
  
  .edit-icon:hover {
    transform: scale(1.1);
    color: #4caf4fa1;
  }
  
  .delete-icon:hover {
    transform: scale(1.1);
    color: #f443369c;
  }
  </style>
  