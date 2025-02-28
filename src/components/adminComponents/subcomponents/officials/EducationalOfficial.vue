<script setup>
    import { ref } from 'vue';
    import AddEducation from './InputForms/AddEducation.vue';
    const educationalBackgrounds = ref([
    { university: "Ateneo de Ngga University", degree: "Bachelor of Public Administration (BPA)", years: "2020 - 2024", icon: "/public/ADNU.png"},
    { university: "University of the Philippines", degree: "BS Computer Science", years: "2018 - 2022", icon: "/public/ADNU.png" },
    { university: "De La Salle Univdfersity", degree: "BA Communication Arts", years: "2019 - 2023", icon: "/public/ADNU.png" },
    { university: "Ateneo de Naga University", degree: "Bachelor of Public Administration (BPA)", years: "2020 - 2024", icon: "/public/ADNU.png" },
    { university: "University of the Philippines", degree: "BS Computer Science", years: "2018 - 2022", icon: "/public/ADNU.png" },
    { university: "De La Salle University", degree: "BA Communication Arts", years: "2019 - 2023", icon: "/public/ADNU.png" },
    { university: "Ateneo de Naga University", degree: "Bachelor of Public Administration (BPA)", years: "2020 - 2024", icon: "/public/ADNU.png" },
    { university: "University of the Philippines", degree: "BS Computer Science", years: "2018 - 2022", icon: "/public/ADNU.png" },
    { university: "De La Salle University", degree: "BA Communication Arts", years: "2019 - 2023", icon: "/public/ADNU.png" },
    ]);

    const hoverIndex = ref(null);

</script>

<template>
    <v-card class="educational-section" elevation="5">
        <!-- Title with Icon -->
        <v-card-title class="title d-flex align-center justify-center" >
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
                    <h2>{{ item.university }}</h2>
                    <p>{{ item.degree }}</p>
                    <h3>{{ item.years }}</h3>
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

        <AddEducation></AddEducation>
    </v-card>



</template>

<style scoped>
.educational-section {
    display: flex;
    flex-direction: column;

    justify-content: center;
    width: 75%;
    border-radius: 1rem;
    padding: 2rem 0;
    gap: 3rem;
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
    border: 1px solid rgb(151, 151, 151);
    min-width: 450px;
}


.educational-cards section article h2 {
    font-size: 1.25rem;
    font-weight: bold;
}

.educational-cards section article p {
    font-size: .9rem;
}

.educational-cards section article h3 {
    font-size: .7rem;
    font-weight: bold;
}

/* Actions Positioned to Bottom Right */
.educational-card-actions {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 0.75rem;
  border-radius: 8px;
  height: 100%;
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