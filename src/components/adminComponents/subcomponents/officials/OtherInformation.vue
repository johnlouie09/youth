<template>
    <v-card class="other-information-section" elevation="10">
        <v-card-title class="title d-flex align-center justify-center">
            <v-icon class="me-2" size="30">mdi-information-outline</v-icon>
            <h2 class="mb-0">OTHER INFORMATION</h2>
        </v-card-title>

        <div class="other-info-cards">
            <v-card
                class="info-card"
                v-for="(card, index) in dummyInfo"
                :key="index"
                @mouseover="hoverIndex = index"
                @mouseleave="hoverIndex = null"
            >
                <v-card-title class="card-title">
                    {{ card.title }}
                </v-card-title>

                <v-card-text class="card-body">
                    <v-icon :icon="card.icon" size="75"></v-icon>
                    <div>
                        <ul>
                            <li class="text-left" v-for="(detail, i) in card.details" :key="i">{{ detail }}</li>
                        </ul>
                    </div>
                </v-card-text>

                <transition name="fade">
                    <div v-if="hoverIndex === index" class="educational-card-actions">
                        <v-icon class="edit-icon" size="30" @click="editInfo(index)">mdi-pencil-circle</v-icon>
                        <v-icon class="delete-icon" size="30">mdi-delete-circle</v-icon>
                    </div>
                </transition>

                <UpdatingInfo
                    v-if="editingIndex === index"
                    :info="card"
                    @close="editingIndex = null"
                />
            </v-card>
        </div>

        <add-other-info></add-other-info>
    </v-card>
</template>

<script>
import AddOtherInfo from './InputForms/adding/AddOtherInfo.vue';
import UpdatingInfo from './InputForms/updating/UpdatingInfo.vue';

export default {
    components: {
        AddOtherInfo,
        UpdatingInfo
    },
    data() {
        return {
            dummyInfo: [
                {
                    title: "My Favorite Book",
                    icon: "mdi-book-open-variant",
                    details: ["Atomic Habits by James Clear", "Deep Work by Cal Newport", "Atomic Habits by James Clear", "Deep Work by Cal Newport", "Atomic Habits by James Clear", "Deep Work by Cal Newport", "Atomic Habits by James Clear", "Deep Work by Cal Newport"]
                },
                {
                    title: "Hobbies",
                    icon: "mdi-run",
                    details: ["Running", "Cycling", "Playing Piano"]
                }
            ],
            editingIndex: null,
            hoverIndex: null
        };
    },
    methods: {
        editInfo(index) {
            this.editingIndex = index;
        }
    }
};
</script>


<style scoped>
.other-information-section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 75%;
    border-radius: 1rem;
    padding: 2rem 0;
    gap: 3rem;
}

.other-info-cards {
    padding: 0 6rem;
    display: flex;
    align-items: flex-start;
    justify-content: space-evenly;
    gap: 2rem;
    flex-wrap: wrap;
}

.info-card {
    background-color: var(--v-theme-surface);
    border-radius: 0.5rem;
    box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    position: relative;
}

.card-title {
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    border-radius: 0.5rem 0.5rem 0 0;
    font-weight: bold;
    padding: 10px;
    background-color: rgba(55, 114, 255, 0.7);
}

.card-body {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-grow: 1;
    gap: 2rem;
    padding: 3rem;
}

.educational-card-actions {
    position: absolute;
    bottom: 10px;
    right: 10px;
    display: flex;
    gap: 10px;
}

.edit-icon, .delete-icon {
    cursor: pointer;
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
