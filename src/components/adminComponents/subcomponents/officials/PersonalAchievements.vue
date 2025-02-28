<script setup>
import { ref } from 'vue';

const hoverIndex = ref(null);

const achievements = ref([
  {
    title: 'Certificate of Recognition: Successful Organization of the Barangay Youth Sports Festival',
    date: 'July 15, 2023'
  },
  {
    title: 'Best Youth Leader Award - Barangay Level',
    date: 'December 10, 2022'
  },
  {
    title: 'Completion of Leadership Training Program',
    date: 'March 5, 2023'
  },
  {
    title: 'Barangay Clean-Up Drive Coordinator',
    date: 'August 21, 2023'
  },
  {
    title: 'Successful Fundraising for Community Projects',
    date: 'October 15, 2022'
  },
  {
    title: 'Participation in National Youth Forum',
    date: 'September 3, 2023'
  },
  {
    title: 'Certificate of Appreciation: Volunteer Service in Disaster Relief',
    date: 'November 18, 2023'
  }
]);
</script>

<template>
  <v-card class="achievements-section" elevation="5">
    <!-- Title with Icon -->
    <v-card-title class="title d-flex align-center justify-center">
      <v-icon class="me-2" size="30">mdi-trophy</v-icon>
      <h2 class="mb-0">PERSONAL ACHIEVEMENTS</h2>
    </v-card-title>

    <div class="achievements-cards">    
      <v-card
        v-for="(achievement, index) in achievements"
        :key="index"
        elevation="4" 
        class="card"
        @mouseover="hoverIndex = index"
        @mouseleave="hoverIndex = null"
      >
        <article>
          <h2>{{ achievement.title }}</h2>
          <p>{{ achievement.date }}</p>
        </article>

        <!-- Actions appear with transition -->
        <transition name="fade">
            <div v-if="hoverIndex === index" class="educational-card-actions">
                <v-icon class="edit-icon" size="30">mdi-pencil-circle</v-icon>
                <v-icon class="delete-icon" size="30">mdi-delete-circle</v-icon>
            </div>
        </transition>
      </v-card>
    </div>

    <v-btn class="add-pa-button">
      <v-icon>mdi-plus-circle-outline</v-icon>
      <span class="ml-4">ADD NEW PERSONAL ACHIEVEMENTS</span>
    </v-btn>
  </v-card>
</template>

<style scoped>
.achievements-section {
  display: flex;
  flex-direction: column;
  justify-content: center;
  width: 75%;
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

.achievements-cards .card {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding: 2.5rem 2rem;
  border-radius: .5rem;
  gap: 1.75rem;
  border: 1px solid rgb(151, 151, 151);
  width: 450px;
  position: relative;
}

.add-pa-button {
    border-radius: .5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1.5rem;
    margin: auto;
    font-size: .7rem;
}

/* Actions */
.educational-card-actions {
    position: absolute;
    bottom: 10px;
    right: 10px;
    display: flex;
    gap: 10px;
}

/* Edit and Delete Icons */
.edit-icon, .delete-icon {
  cursor: pointer;
}

.edit-icon:hover {
  transform: scale(1.1);
  color: #4caf4fa1; /* Green for edit */
}

.delete-icon:hover {
  transform: scale(1.1);
  color: #f443369c; /* Red for delete */
}
</style>
