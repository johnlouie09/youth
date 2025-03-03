<script setup>
import { ref } from "vue";
import OfficialCard from "./subcomponents/officials/OfficialCard.vue"

const officials = ref([
    { id: 1, role: "Chairperson", name: "Juan Dela Cruz", img: "/Sangguniang_Kabataan_logo.svg"},
    { id: 2, role: "Secretary", name: "Maria Santos", img: "/Sangguniang_Kabataan_logo.svg"},
    { id: 3, role: "Treasurer", name: "Carlos Mendoza", img: "/Sangguniang_Kabataan_logo.svg"},
    { id: 4, role: "Kagawad", name: "Ana Reyes", img: "/Sangguniang_Kabataan_logo.svg"},
    { id: 5, role: "Kagawad", name: "Jose Lopez", img: "/Sangguniang_Kabataan_logo.svg"},
    { id: 6, role: "Kagawad", name: "Elena Garcia", img: "/Sangguniang_Kabataan_logo.svg"},
    { id: 7, role: "Kagawad", name: "Miguel Torres", img: "/Sangguniang_Kabataan_logo.svg"},
    { id: 8, role: "Kagawad", name: "Rosa Fernandez", img: "/Sangguniang_Kabataan_logo.svg"}
]);
</script>

<template>
    <v-container class="officials-main">
        <div class="title">
            <h1>BARANGAY SAN FRANCISCO SK OFFICIALS</h1>
        </div>
        <div class="cards">
            <OfficialCard v-for="(official) in officials" :key="official.id" :official="official" />
        </div>
    </v-container>
</template>

<style scoped>
.officials-main {
    padding: 4rem 7rem;
    display: flex;
    flex-direction: column;
    gap: 4rem;
}
.cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    gap: 3rem;
}

h1 {
    font-weight: bold;
}
</style>
