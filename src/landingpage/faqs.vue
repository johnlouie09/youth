<template>
    <v-container max-width="900px">
        <div class="gradient-text">
            <h1>Frequently Asked Questions</h1>
        </div>
        <v-expansion-panels>
            <v-expansion-panel
                v-for="i in 3"
                :key="i"
                class="custom-cardss faq-item"
                style="border-radius: 10px"
            >
                <v-expansion-panel-title class="faq-title">
                    Item {{ i }}
                </v-expansion-panel-title>
                <v-expansion-panel-text class="faq-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
    </v-container>
</template>

<style scoped>
.faq-title {
    font-size: 1.5rem;
    font-weight: bold;
    background: transparent;
    transition: all 0.3s ease-in-out;
}

.custom-cardss {
    transition: all 0.3s ease-in-out;
}

/* Hover effect for title */
.custom-cardss:hover .faq-title,
:deep(.v-expansion-panel--active) .faq-title {
    background-image: linear-gradient(45deg, #3772FF 10%, #DF2935 20%, #FDCA40 35%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Hover effect and active state for the entire expansion panel */
.custom-cardss:hover,
:deep(.v-expansion-panel--active) {
    background: linear-gradient(45deg, rgba(55, 114, 255, 0.2), rgba(223, 41, 53, 0.2), rgba(253, 202, 64, 0.2));
    transform: scale(1.02);
    border-radius: 10px;
}
</style>
