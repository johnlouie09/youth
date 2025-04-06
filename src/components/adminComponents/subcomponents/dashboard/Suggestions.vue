<template>
    <v-container fluid class="pa-0">
        <v-card class="pa-9 pb-4">
            <h2 class="py-5 text-center text-2xl font-weight-bold">YOUTH MESSAGES NOTIFICATIONS</h2>

            <v-tabs v-model="tab" grow>
                <v-tab>UNREAD</v-tab>
                <v-tab>ALL</v-tab>
            </v-tabs>

            <v-container class="overflow-y-scroll h-[400px]">
                <v-list>
                    <v-list-item v-for="n in 10" :key="n" class="mb-3 rounded">
                        <v-list-item-title class="font-weight-bold">{{ messages.title }}</v-list-item-title>
                        <v-list-item-subtitle>{{ messages.description }}</v-list-item-subtitle>
                        <span class="text-right text-caption font-weight-bold">{{ messages.time }}</span>
                    </v-list-item>
                </v-list>
            </v-container>
        </v-card>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            tab: 0,
            messages: {
                title: "Youth Skills Development Program",
                description: "Implement monthly workshops on practical skills such as basic coding, graphic design, entrepreneurship, and financial literacy. This will help equip ...",
                time: "1 hr ago"
            }
        };
    }
};
</script>

<style scoped>
/* Make scrollbar small */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

/* Scrollbar track (background) */
::-webkit-scrollbar-track {
    background: #1e1e1e;
    border-radius: 10px;
}

/* Scrollbar thumb (draggable part) */
::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 10px;
}

/* Scrollbar thumb on hover */
::-webkit-scrollbar-thumb:hover {
    background: #888;
}

.v-list-item {
    padding: 16px;
}
</style>