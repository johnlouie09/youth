<script setup>
import { ref, watchEffect } from 'vue';
import axios from 'axios';
import addBarangayAchievement from './subcomponents/achievement/inputForm/addBarangayAchievement.vue';
import updateBarangayAchievement from './subcomponents/achievement/inputForm/updateBarangayAchievement.vue';
import DialogConfirm from '../dialogs/DialogConfirm.vue';

const hoverIndex = ref(null);
const editingAchievement = ref(null); // Track the selected achievement for editing
const barangayId = 1;


const achievements = ref({});
const loading = ref(false);
const error = ref(null);

const fetchBarangayAchievements = async () => {
    try {
        loading.value = true;
        error.value = null;
        const response = await axios.get(`/api/BarangayAchievement.php?barangay_id=${barangayId}`);

        if (response.data.success) {
            achievements.value = response.data.data;
        } else {
            error.value = 'Failed to fetch barangays';
        }
    } catch (err) {
        error.value = 'Error connecting to the server';
        console.error('Error:', err);
    } finally {
        loading.value = false;
    }
};
fetchBarangayAchievements();

const deleteBarangayAchievement = async (achievementId) => {
  try {
    const response = await axios.delete(
      'http://localhost/youth/app/api/BarangayAchievement.php',
      {
        data: { id: achievementId }
      }
    );
    if (response.data.success) {
      console.log('Achievement deleted successfully:', response.data.message);
      // Refresh the achievements list
      await fetchBarangayAchievements();
    } else {
      console.error('Deletion failed:', response.data.error);
    }
  } catch (error) {
    console.error('Error deleting achievement:', error);
  }
};



// Function to handle edit button click
const startEditing = (year, month, achievement) => {
  editingAchievement.value = { year, month, ...achievement }; // Store achievement data
};

// Function to close editing component
const closeEditing = () => {
  editingAchievement.value = null;
};
</script>

<template>
  <v-container class="achievement-main">
    <h1>ACHIEVEMENTS</h1>

    <div class="year" v-for="year in Object.keys(achievements).sort().reverse()" :key="year">
        <v-sheet class="month" v-for="month in Object.keys(achievements[year]).sort((a, b) => 
            new Date(`${b} 1, ${year}`).getTime() - new Date(`${a} 1, ${year}`).getTime()
        )" :key="month">
            <div class="title">
                {{ `${month.toUpperCase()} - ${year}` }}
            </div>

            <div class="achievements">
                <v-card elevation="15" 
                    v-for="achievement in achievements[year][month]" 
                    :key="achievement.title" 
                    class="card"
                    @mouseover="hoverIndex = achievement.title" 
                    @mouseleave="hoverIndex = null">
                    
                    <img :src="achievement.img" alt="">
                    <article>
                        <h3>{{ achievement.title }}</h3>
                        <h5>{{ achievement.subtitle }}</h5>
                        <p>{{ achievement.info }}</p>
                    </article>
                    
                    <div class="btns" v-if="hoverIndex === achievement.title">
                        <v-btn color="teal-lighten-1" @click="startEditing(year, month, achievement)">EDIT</v-btn>
                        <v-btn color="red-lighten-1" @click="deleteBarangayAchievement(achievement.id)">DELETE</v-btn>
                    </div>
                </v-card>
            </div>

            <addBarangayAchievement 
            :year= "parseInt(year)" :month="new Date(`${month} 1, ${year}`).getMonth() + 1" 
            :barangayId="barangayId"
            @achievementAdded="fetchBarangayAchievements"
            ></addBarangayAchievement>
        </v-sheet>
    </div>

    <!-- Show Editing Component When Editing -->
    <updateBarangayAchievement 
        v-if="editingAchievement" 
        :barangayAchievement="editingAchievement"
        @close="closeEditing"
        @achievementUpdated="fetchBarangayAchievements"
        />
  </v-container>


</template>


<style scoped>
.achievement-main {
  padding: 4rem 6rem;
  display: flex;
  flex-direction: column;
  gap: 3rem;
}

h1 {
  text-align: center;
  font-size: 2rem;
  font-weight: bolder;
}

.month {
  width: fit-content;
  padding: 1rem 2rem;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  border-radius: 2rem;
  align-items: center;
  gap: 2.5rem;
  width: 100%;
}

.month .title {
  border-bottom: 4px solid #616bfc;
  font-size: 1.5rem;
  font-weight: bolder;
  padding: 1rem 0;
  text-align: center;
  width: 100%;
}

.achievements {
  width: 90%;
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  flex-wrap: wrap;
  gap: 2.5rem;
}

.achievements .card {
  width: 362px;
  padding: 2rem 2rem;
  border-radius: .5rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  position: relative;
  transition: transform 0.3s ease-in-out;
}

.achievements .card:hover {
  transform: translateY(-5px);
}

.card img{
  width: 100%;
  height: 187px;

}

article h3 {
  font: 1.25rem;
  font-weight: bold;
}

article {
  width: 100%;
}

article h4 {
  font-size: 1rem;
}

article p {
  height: 50px;
  max-height: 50px;
  font-size: .75rem;
  overflow: hidden;
}

.btns {
  display: flex;
  width: 100%;
  justify-content: space-evenly;
}

.achievements .card:hover .edit {
  opacity: 1;
  transform: translateY(0);
}

.achievements {
  display: flex;

}

.year {
  display: flex;
  flex-direction: column;
  width: 100%;
  gap: 7rem;
}
</style>





