<script>
  import FormAchievement from './InputForms/FormAchievement.vue';
  import $ from 'jquery';

  export default {
    components: {
      FormAchievement,
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
        // Controls the visibility of the new achievement form
        showNewAchievement: false
      };
    },
    methods: {
      /**
       * Set the editing index for a given achievement.
       */
      editAchievement(index) {
        this.editingIndex = index;
      },

      /**
       * Format a date string to a localized string.
       */
      formatDate(dateStr) {
        if (!dateStr) return '';
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', {
          month: 'long',
          day: 'numeric',
          year: 'numeric'
        });
      },

      /**
       * Handles child events by closing the new achievement form
       * and emitting an event to refresh official information.
       */
      handleChildEvent(payload) {
        this.showNewAchievement = false;
        this.editingIndex = null;
        this.$emit('fetchOfficialInfo', payload);
      },

      /**
       * Shows a confirmation dialog for deletion and, if confirmed,
       * calls the deleteAchievement method.
       */
      async confirmDelete(achievementId) {
        this.$store.commit('dialog/confirm/show', {
          title: 'Delete Achievement',
          prompt: 'Are you sure you want to delete this achievement?',
          color: 'red',
          yesText: 'Delete',
          noText: 'Cancel',
          onConfirm: async () => {
            await this.deleteAchievement(achievementId);
          },
          onCancel: () => {
            console.log('Deletion cancelled');
          }
        });
      },

      /**
       * Deletes an achievement via an AJAX request.
       */
      deleteAchievement(achievementId) {
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
            // Emit event to refresh official information
            this.$emit('fetchOfficialInfo', true);
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error deleting achievement:", textStatus, errorThrown);
          }
        });
      }
    },
    watch: {
      achievements: {
        immediate: true,
        handler(newVal) {
          // Clone the achievements data if needed
          this.personalAchievements = { ...newVal };
        },
        deep: true
      }
    }
  };
</script>

<template>
  <v-card class="achievements-section" elevation="5">

    <!-- Title Section -->
    <v-card-title class="title d-flex items-center justify-center">
      <v-icon class="me-2" size="30">mdi-trophy</v-icon>
      <h2 class="uppercase font-extrabold text-2xl">PERSONAL ACHIEVEMENTS</h2>
    </v-card-title>

    <!-- Achievements List -->
    <div class="achievements-cards">
      <v-container class="d-flex flex-row flex-wrap justify-evenly p-5 pt-0 gap-10">
        <v-card
          v-for="(achievement, index) in achievements"
          :key="index"
          class="achievement-card w-[30%] min-w-[250px] rounded-lg d-flex flex-col justify-start items-center overflow-hidden pb-10"
          elevation="5"
          @mouseover="hoverIndex = index"
          @mouseleave="hoverIndex = null"
        >
          <!-- Achievement Image -->
          <v-img
            :src="`/achievements/${achievement.img}`"
            alt=""
            class="elevation-5 w-full rounded-t-lg"
          />

          <!-- Achievement Details -->
          <article class="d-flex flex-col items-start w-[90%] my-5">
            <h3 class="uppercase text-xs font-extrabold">{{ achievement.title }}</h3>
            <h5 class="text-[.75rem] font-medium">{{ achievement.subtitle }}</h5>
            <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-5">{{ formatDate(achievement.date) }}</h5>
          </article>

          <!-- Action Buttons on Hover -->
          <transition name="fade">
            <div v-if="hoverIndex === index" class="achievement-card-actions">
              <v-icon class="edit-icon" size="25" @click="editAchievement(index)">mdi-pencil-circle</v-icon>
              <v-icon class="delete-icon" size="25" @click="confirmDelete(achievement.id)">mdi-delete-circle</v-icon>
            </div>
          </transition>

          <!-- Edit Achievement Form (shown for updating an achievement) -->
          <FormAchievement
            v-if="editingIndex === index"
            :action="'updating'"
            :achievement="achievement"
            @close="editingIndex = null"
            @fetchInfo="handleChildEvent(true)"
          />
        </v-card>
      </v-container>

      <!-- Add New Achievement Button -->
      <v-btn
        class="d-flex items-center justify-center px-10 py-10 text-lg"
        elevation="10"
        @click="showNewAchievement = true"
      >
        <v-icon>mdi-plus-circle-outline</v-icon>
        <span class="ml-4">ADD PERSONAL ACHIEVEMENT</span>
      </v-btn>
    </div>

    <!-- New Achievement Dialog -->
    <FormAchievement
      v-if="showNewAchievement"
      :achievement="{ sk_official_id: id }"
      :action="'adding'"
      @close="showNewAchievement = false"
      @fetchInfo="handleChildEvent(true)"
    />
  </v-card>
</template>

<style scoped>
.achievement-card {
  transition: transform 0.3s ease;
}

.achievement-card:hover {
  transform: scale(1.05);
}

/* Other existing styles */
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
  padding: 0 5rem;
  display: flex;
  align-items: flex-start;
  justify-content: space-evenly;
  flex-wrap: wrap;
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

  