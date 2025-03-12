<template>
    <v-container fluid class="achievement-main pa-0 ma-0">
        <h1 class="gradient-text mb-9">Achievements</h1>
        <div class="achievements" >
            <v-card elevation="15" 
                v-for="(achievement, index) in achievements" :key="index"
                class="card"
        >
                <img :src="`achievements/${achievement.img}`" alt="" class="elevation-10">
                
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
export default {
    props: {
        achievements: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            showStates: []
        };
    },
    mounted() {
        this.showStates = this.achievements.map(() => false);
    },
    watch: {
        achievements: {
            handler(newAchievements) {
                this.showStates = newAchievements.map(() => false);
            },
            immediate: true
        }
    },
    methods: {
        toggleShow(index) {
            this.showStates[index] = !this.showStates[index];
            this.$forceUpdate();
        }
    }
};
</script>

<style scopped>
@import "../../assets/Achievements.css";
@import "../../assets/fontEffects.css";


.achievements {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    align-items: flex-start;
    gap: 3rem;
    padding: 0rem 9rem;
}

.card {
  width: 400px;
  border-radius: 0.5rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  position: relative;
  transition: transform 0.3s ease-in-out, border 0.3s ease-in-out;
  padding-bottom: 1.5rem;
  /* Optionally, add a default border style */
  border: 2px solid transparent;
}

.card:hover {
  transform: scale(1.05);
  border: 2px solid #5c5c5c; /* Change border color as needed */
}

.card img{
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
  font-size: .75rem;
}

article p {
    max-height: 90px;
    font-size: .75rem;
    overflow: hidden;
}


</style>
