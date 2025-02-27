<script setup>
import { ref } from 'vue';
const tab = ref(0);
const messages = ref(
    {
        title: "Youth Skills Development Program",
        description: "Implement monthly workshops on practical skills such as basic coding, graphic design, entrepreneurship, and financial literacy. This will help equip ...",
        time: "1 hr ago"
    }

);
</script>

<template>
    <v-container fluid class="pt-0">
        <v-card class="pa-9 pb-4">
            <h2 class="suggestions-title text-center font-weight-bold">YOUTH SUGGESTIONS NOTIFICATIONS</h2>
            
            <v-tabs v-model="tab" grow>
                <v-tab>UNREAD</v-tab>
                <v-tab>ALL</v-tab>
            </v-tabs>
            
            <v-container class="overflow-y-auto" style="max-height: 500px;">
                <v-list>
                    <v-list-item v-for="n of 10" class="mb-3 rounded">
                        <v-list-item-title class="font-weight-bold">{{ messages.title }}</v-list-item-title>
                        <v-list-item-subtitle>{{ messages.description}}</v-list-item-subtitle>
                        <span class="text-right text-caption font-weight-bold">{{ messages.time }}</span>
                    </v-list-item>
                </v-list>
            </v-container>
        </v-card>
    </v-container>
</template>

<style scoped>

</style>



<style scoped>
    /* Make scrollbar small */
    ::-webkit-scrollbar {
        width: 6px;  /* Set the scrollbar width */
        height: 6px; /* Set the scrollbar height (for horizontal scrollbars) */
    }

    /* Scrollbar track (background) */
    ::-webkit-scrollbar-track {
        background: #1e1e1e;  /* Dark background */
        border-radius: 10px;
    }

    /* Scrollbar thumb (draggable part) */
    ::-webkit-scrollbar-thumb {
        background: #555;  /* Gray thumb */
        border-radius: 10px;
    }

    /* Scrollbar thumb on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #888;  /* Lighter gray on hover */
    }

    .v-list-item {
    padding: 16px;

    .suggestions-title {
        padding: 3rem 2rem;
    }
}
</style>