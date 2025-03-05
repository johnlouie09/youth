<script setup>
import { ref } from 'vue';
import addBarangayAchievement from './subcomponents/achievement/inputForm/addBarangayAchievement.vue';
import updateBarangayAchievement from './subcomponents/achievement/inputForm/updateBarangayAchievement.vue';

const hoverIndex = ref(null);
const editingAchievement = ref(null); // Track the selected achievement for editing

const achievements = ref({
  2024: {
    December: [
      {
        img: "/public/ex.jpg",
        title: "Pasko sa Barangay",
        subtitle: "Paskong puno ng saya!",
        info: "A Christmas party for the community featuring food, games, and entertainment."
      },
      {
        img: "/public/ex.jpg",
        title: "Charity Gift Drive",
        subtitle: "Spreading holiday cheer!",
        info: "A volunteer event to distribute gifts to children and families in need."
      },
      {
        img: "/public/ex.jpg",
        title: "Christmas Caroling",
        subtitle: "Songs of joy and love!",
        info: "A community caroling event to spread holiday cheer."
      }
    ],
    November: [
      {
        img: "/public/ex.jpg",
        title: "Community Outreach Program",
        subtitle: "Tulong-tulong tayo!",
        info: "A volunteer event where youth groups help underprivileged communities."
      },
      {
        img: "/public/ex.jpg",
        title: "Barangay Fiesta",
        subtitle: "Sama-sama sa saya!",
        info: "A celebration of community spirit with food, games, and cultural presentations."
      },
      {
        img: "/public/ex.jpg",
        title: "Medical Mission",
        subtitle: "Health for all!",
        info: "Free medical check-ups and consultations for the community."
      }
    ],
    October: [
      {
        img: "/public/ex.jpg",
        title: "Halloween Costume Contest",
        subtitle: "Sino ang pinakanakakatakot?",
        info: "A contest for the best and scariest Halloween costumes."
      },
      {
        img: "/public/ex.jpg",
        title: "Haunted House Experience",
        subtitle: "Enter if you dare!",
        info: "A spooky haunted house event for thrill-seekers."
      },
      {
        img: "/public/ex.jpg",
        title: "Pumpkin Carving Contest",
        subtitle: "Get creative with your pumpkins!",
        info: "A fun event where participants showcase their carving skills."
      }
    ],
    September :[],
    July :[],
    June :[],
    May :[],
  },
  2025: {
    March: [
      {
        img: "/public/ex.jpg",
        title: "Music Fest",
        subtitle: "Sali na at ipakita ang talento!",
        info: "A music festival where locammunity effort to clean public spaces and promote envirmmunity effort to clean public spaces and promote envirl talents showcased their singing and instrumental skills."
      },
      {
        img: "/public/ex.jpg",
        title: "Community Art Exhibit",
        subtitle: "Art for a cause!",
        info: "A showcase of artworks created by young artists in the community."
      },
      {
        img: "/public/ex.jpg",
        title: "Basketball League Kickoff",
        subtitle: "The road to the championship begins!",
        info: "The opening event for the barangay-wide basketball league."
      }
    ],
    February: [
      {
        img: "/public/ex.jpg",
        title: "Chess Tournament",
        subtitle: "Matalino ka ba? Eh sa chess?",
        info: "Checkmate! This tournament brought out the best strategists."
      },
      {
        img: "/public/ex.jpg",
        title: "Love and Friendship Day",
        subtitle: "A celebration of love and camaraderie!",
        info: "An event featuring activities that promote friendship and community spirit."
      },
      {
        img: "/public/ex.jpg",
        title: "Clean-Up Drive",
        subtitle: "Linisin natin ang ating bayan!",
        info: "A coonmental responsibility."
      }
    ],
    January: [
      {
        img: "/public/ex.jpg",
        title: "Basketball Championship",
        subtitle: "Kung walang nilaga sana tayo nalang...",
        info: "The grand finals of the basketball tournament! The best teams clashed in an intense battle for the championship title."
      },
      {
        img: "/public/ex.jpg",
        title: "New Year’s Fitness Challenge",
        subtitle: "Start the year strong!",
        info: "A fitness event promoting health and wellness."
      },
      {
        img: "/public/ex.jpg",
        title: "Youth Leadership Seminar",
        subtitle: "Empowering future leaders!",
        info: "Workshops to build leadership and problem-solving skills among the youth."
      }
    ]
  },
});

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
                        <v-btn color="red-lighten-1">DELETE</v-btn>
                    </div>
                </v-card>
            </div>

            <addBarangayAchievement :year="year" :month="month"></addBarangayAchievement>
        </v-sheet>
    </div>

    <!-- Show Editing Component When Editing -->
    <updateBarangayAchievement 
        v-if="editingAchievement" 
        :year="editingAchievement.year" 
        :month="editingAchievement.month" 
        :barangayAchievement="editingAchievement"
        @close="closeEditing" />
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
  border-bottom: 4px solid #DAA2E8;
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


