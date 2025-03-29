<script>
  import FormAchievement from './subcomponents/officials/InputForms/FormAchievement.vue';
  import $ from 'jquery';

  export default {
    components: {
      FormAchievement,
    },
    data() {
      return {
        hoverIndex: null,
        editingIndex: null,
        achievements: {},
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

      fetchBarangayAchievements() {
        $.ajax({
          url: `${this.$store.getters.api_base}?e=barangay&a=achievements`,
          type: 'POST',
          xhrFields: {
            withCredentials: true
          },
          headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
          },
          data: {
            barangayId: 1,
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
          }
        });
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
            this.fetchBarangayAchievements();
          },
          error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error deleting achievement:", textStatus, errorThrown);
          }
        });
      }
    },
    created() {
      this.fetchBarangayAchievements();
    },
    watch: {
    }
  };
</script>

<template>
  <v-card class="achievements-section">

    <!-- Title Section -->
    <v-card-title class="title d-flex items-center justify-center ma-5">
      <v-icon class="mr-3" size="75">mdi-trophy</v-icon>
      <h2 class="font-black text-3xl">BARANGAY ACHIEVEMENTS</h2>
      <v-icon class="ml-3" size="75">mdi-trophy</v-icon>
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
            :src="`/public/achievements/${achievement.img}`"
            alt=""
            class="elevation-5 w-full rounded-t-lg"
          />

          <!-- Achievement Details -->
          <article class="d-flex flex-col items-start w-[90%] my-5">
            <h3 class="uppercase text-lg font-extrabold">{{ achievement.title }}</h3>
            <h5 class="text-base font-medium">{{ achievement.subtitle }}</h5>
            <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-5">{{ formatDate(achievement.date) }}</h5>
          </article>

          <v-card class="w-[80%] d-flex items-center ga-1 px-5 mb-5 elevation-5">
            <v-avatar :image="(achievement.sk_official_img ? ($store.getters.base + 'public/OfficialImages/' + achievement.sk_official_img) : ($store.getters.base + 'public/OfficialImages/no-avatar.jpg'))" size="50"></v-avatar>
            <v-card-text class="d-flex flex-col">
              <span class="text-sm">{{ achievement.sk_official_name }}</span>
              <span class="uppercase text-xs">SK Chairperson</span>
            </v-card-text>
          </v-card>

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
            :action="'updating-main'"
            :achievement="achievement"
            @close="editingIndex = null"
            @fetchInfo="fetchBarangayAchievements"
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
      :action="'adding-main'"
      @close="showNewAchievement = false"
      @fetchInfo="fetchBarangayAchievements"
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
  align-items: center;
  width: 100%;
  border-radius: 1rem;
  padding: 2rem 0;
  gap: 1rem;
}

.achievements-cards {
  padding: 1rem 2rem;
  width: 90%;
  height: 90vh;
  display: flex;
  align-items: flex-start;
  justify-content: space-evenly;
  flex-wrap: wrap;
  overflow-y: scroll;
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

  