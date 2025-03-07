<template>
    <v-card class="educational-section" elevation="5">
        <v-card-title class="title d-flex align-center justify-center">
            <v-icon class="me-2" size="30">mdi-account-circle</v-icon>
            <h2 class="mb-0">EDUCATIONAL BACKGROUND</h2>
        </v-card-title>

        <div class="educational-cards">
            <v-card
                v-for="(item, index) in educationalBackgrounds"
                :key="index"
                class="card"
                elevation="4"
                @mouseover="hoverIndex = index"
                @mouseleave="hoverIndex = null"
            >
                <img :src="item.icon" alt="" width="70px">
                <article>
                    <h2>{{ item.school }}</h2>
                    <p>{{ item.detail }}</p>
                    <h3>{{ item.years.start }} - {{ item.years.end }}</h3>
                </article>

                <transition name="fade">
                    <div v-if="hoverIndex === index" class="educational-card-actions">
                        <v-icon class="edit-icon" size="30" @click="editEducation(index)">mdi-pencil-circle</v-icon>
                        <v-icon class="delete-icon" size="30">mdi-delete-circle</v-icon>
                    </div>
                </transition>

                <UpdateEducational
                    v-if="editingIndex === index"
                    :education="item"
                    @close="editingIndex = null"
                />
            </v-card>
        </div>
        <AddEducation></AddEducation>
    </v-card>
</template>

<script>
import AddEducation from './InputForms/adding/AddEducation.vue';
import UpdateEducational from './InputForms/updating/UpdateEducational.vue';

export default {
    components: {
        AddEducation,
        UpdateEducational
    },
    data() {
        return {
            educationalBackgrounds: [
                { school: "Ateneo de Ngga Kindergarten", years: { start: 2005, end: 2007 }, icon: "/public/ADNU.png" },
                { school: "Ateneo de Ngga Elementary School", years: { start: 2007, end: 2013 }, icon: "/public/ADNU.png" },
                { school: "Ateneo de Ngga High School", years: { start: 2013, end: 2017 }, icon: "/public/ADNU.png" },
                { school: "Ateneo de Ngga Senior High", detail: "Computer System Servicing", years: { start: 2017, end: 2019 }, icon: "/public/ADNU.png" },
                { school: "Ateneo de Ngga University", detail: "Bachelor of Public Administration (BPA)", years: { start: 2020, end: 2024 }, icon: "/public/ADNU.png" }
            ],
            editingIndex: null,
            hoverIndex: null
        };
    },
    methods: {
        editEducation(index) {
            this.editingIndex = index;
        }
    }
};
</script>



<style scoped>
.educational-section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 75%;
    border-radius: 1rem;
    padding: 2rem 0;
    gap: 2rem;
}

.educational-cards {
    padding: 0 6rem;
    display: flex;
    align-items: center;
    align-items: flex-start;
    justify-content: space-evenly;
    gap: 2rem;
    flex-wrap: wrap;
}

.educational-cards .card {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    padding: 2.5rem 2rem;
    border-radius: .5rem;
    gap: 1.75rem;
    border: 1px solid rgb(43, 42, 42);
    min-width: 450px;
}

.educational-card-actions {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 0.75rem;
    border-radius: 8px;
    height: 100%;
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
