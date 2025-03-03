<script setup>
import { ref, computed } from 'vue';
import AddPersonalAchievement from './InputForms/adding/AddPersonalAchievement.vue';
import UpdatingAchievement from './InputForms/updating/UpdatingAchievement.vue';

const hoverIndex = ref(null);
const editingIndex = ref(null);

const editAchievement = (index) => {
    editingIndex.value = index;
};

const achievements = ref([
  { title: 'Certificate of Recognition: Successful Organization of the Barangay Youth Sports Festival', date: new Date(2004, 9, 8) },
  { title: 'Best Youth Leader Award - Barangay Level', date: new Date() }
]);

const formattedDates = computed(() => 
  achievements.value.map(a => a.date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }))
);
</script>

<template>
  <v-card class="achievements-section" elevation="5">
    <v-card-title class="title d-flex align-center justify-center">
      <v-icon class="me-2" size="30">mdi-trophy</v-icon>
      <h2 class="mb-0">PERSONAL ACHIEVEMENTS</h2>
    </v-card-title>

    <div class="achievements-cards">    
      <v-card
        v-for="(achievement, index) in achievements"
        :key="index"
        class="card"
        @mouseover="hoverIndex = index"
        @mouseleave="hoverIndex = null"
      >
        <article>
          <h2>{{ achievement.title }}</h2>
          <p>{{ formattedDates[index] }}</p>
        </article>

        <transition name="fade">
          <div v-if="hoverIndex === index" class="achievement-card-actions">
            <v-icon class="edit-icon" size="30" @click="editAchievement(index)">mdi-pencil-circle</v-icon>
            <v-icon class="delete-icon" size="30">mdi-delete-circle</v-icon>
          </div>
        </transition>

        <UpdatingAchievement 
          v-if="editingIndex === index" 
          :achievement="achievement"  
          @close="editingIndex = null"
        />
      </v-card>
    </div>

    <AddPersonalAchievement />
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
  border-radius: 0.5rem;
  gap: 1.75rem;
  border: 1px solid rgb(43, 42, 42);
  width: 450px;
  position: relative;
  box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);
}

.card article {
  width: 90%;
}

.achievement-card-actions {
  position: absolute;
  bottom: 10px;
  right: 10px;
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
