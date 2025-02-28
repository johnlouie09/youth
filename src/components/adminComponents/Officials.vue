<script setup>
import { ref } from "vue";
import OfficialCard from "./subcomponents/officials/OfficialCard.vue"

const officials = ref([
    { role: "Chairperson", name: "Juan Dela Cruz" },
    { role: "Secretary", name: "Maria Santos" },
    { role: "Treasurer", name: "Carlos Mendoza" },
    { role: "Kagawad", name: "Ana Reyes" },
    { role: "Kagawad", name: "Jose Lopez" },
    { role: "Kagawad", name: "Elena Garcia" },
    { role: "Kagawad", name: "Miguel Torres" },
    { role: "Kagawad", name: "Rosa Fernandez" }
]);


</script>

<template>
    <v-container class="officials-main">
        <OfficialCard v-for="(official, index) in officials" :key="index" :official="official" />
    </v-container>
</template>

<style scoped>
.officials-main {
    padding: 4rem 7rem;
    padding-bottom: 1.5rem;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    gap: 4rem;

}

h1 {
    font-weight: bold;
}
</style>
