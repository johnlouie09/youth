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
                class="w-[30%] min-w-[250px]  rounded-lg d-flex flex-col items-center overflow-hidden pb-10"
                @mouseover="hoverIndex = index"
                @mouseleave="hoverIndex = null"
                >
                <img :src="`/public/achievements/${achievement.img}`" alt="" class="elevation-5 w-full rounded-t-lg"></img>
                <article class="d-flex flex-col items-start w-[90%] ma-5">
                    <h3 class="uppercase text-xs font-extrabold">{{ achievement.title }}</h3>
                    <h5 class="text-[.75rem] font-medium">{{ achievement.subtitle }}</h5>
                    <h5 class="text-xs font-italic absolute bottom-0 right-0 pa-5">{{ formatDate(achievement.date) }}</h5>
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
                    @fetchAchievement="handleChildEvent(true)"
                />
                </v-card>
            </v-container>
        </div>

        <AddPersonalAchievement />
    </v-card>
</template>

<script>
import AddPersonalAchievement from './InputForms/adding/AddPersonalAchievement.vue';
import UpdatingAchievement from './InputForms/updating/UpdatingAchievement.vue';

export default {
    components: {
        AddPersonalAchievement,
        UpdatingAchievement,
    },
    props: {
        achievements: Object
    },
    data() {
        return {
            hoverIndex: null,
            editingIndex: null,
            personalAchievements: [
            ]
        };
    },
    computed: {
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
            this.editingIndex = null;
            this.$emit('fetchOfficialInfo', payload);
        }
    },
    watch : {
        achievements: {
            immediate: true,
            handler(newVal) {
                this.personalAchievements = { ...newVal }
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
    padding: .5rem;
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
