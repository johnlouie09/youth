<script setup>
import { ref } from 'vue';

// Props
defineProps({
    card: Object, // Receiving `card` prop dynamically
});

// Selected Date (Fixed Display)
const selectedDate = ref(new Date());

// Function to format date
const formatDate = (date) => {
    return date.toLocaleString('en-US', { month: 'short' }).toUpperCase() + ' - ' + date.getFullYear();
};
</script>

<template>
    <v-container>
        <v-card class="dashboard-card" elevation="10">
            <!-- Card Title -->
            <v-card-title :class="['card-title', card.type]">
                {{ card.title }}
            </v-card-title>

            <v-card-text class="card-body">
                <v-container class="fill-height">
                    <v-row justify="center" align="center">
                        <!-- MDI ICON -->
                        <v-col cols="12" class="text-center">
                            <v-icon :icon="card.icon" size="100"></v-icon>
                        </v-col>
                    </v-row>

                    <!-- Officials Section -->
                    <v-row v-if="card.type === 'officials'" justify="center" align="center">
                        <v-col cols="12" class="d-flex justify-start align-start flex-column">
                            <p v-for="detail in card.details" :key="detail.position">
                                <span class="number me-2">{{ detail.number }}</span> <!-- Adds right margin -->
                                {{ detail.position }}
                            </p>
                        </v-col>
                    </v-row>

                    <!-- Achievements & Announcements Section -->
                    <v-row 
                        v-else-if="card.type === 'achievements' || card.type === 'announcements'" 
                        justify="center" align="center"
                    >
                        <v-col cols="12" class="d-flex flex-column align-center text-center">
                            <!-- Date Display Only (No Arrow, No Clickable Action) -->
                            <h4>{{ formatDate(selectedDate) }}</h4>

                            <!-- Quantity -->
                            <h2>{{ card.details.quantity }}</h2>
                            <h5>TOTAL</h5>
                        </v-col>
                    </v-row>

                </v-container>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<style scoped>
/* Base Card Styling */
.dashboard-card {
    height: 256px;
    background-color: var(--v-theme-surface);
    border-radius: 0.5rem;
    box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
}

/* Title Styles */
.card-title {
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    border-radius: 0.5rem 0.5rem 0 0;
    font-weight: bold;
    padding: 10px;
}

/* Dynamic Colors */
.officials {
    background-color: rgba(55, 114, 255, 0.7);
}

.achievements {
    background-color: rgba(223, 41, 53, 0.7);
}

.announcements {
    background-color: rgba(253, 202, 64, 0.7);
}

/* Card Body */
.card-body {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-grow: 1;
}

/* Officials List */
.number {
    font-weight: bold;
    font-size: 22px;
}

/* Achievements & Announcements */
h4 {
    font-size: 1rem;
    font-weight: 700;
}

h2 {
    font-size: 5rem;
    font-weight: bolder;
    line-height: 5rem;
}

h5 {
    font-size: 0.5rem;
    font-weight: bolder;
}
</style>
