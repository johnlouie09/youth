<template>
    <v-container max-width="900px">
        <div class="gradient-text">
            <h1>Frequently Asked Questions</h1>
        </div>
        <!-- <v-expansion-panels>
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
        </v-expansion-panels> -->
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-title class="faq-title">
                    What is YOUTH Platform?
                </v-expansion-panel-title>
                <v-divider></v-divider>
                <v-expansion-panel-text class="faq-text">
                    The YOUTH Platform (Youth-Oriented Unified Transparency Hub) is an online system design to enhance transparency and engagement between SK officials and the youth in selected barangays of Iriga CIty. It provides information about SK keader, their advocacies, platforms, and accomplishments, helping young citizens make informed decisions and actively participate in local governance.
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-title class="faq-title">
                    What is Sangguaniang Kabataan?
                </v-expansion-panel-title>
                <v-divider></v-divider>
                <v-expansion-panel-text class="faq-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-title class="faq-title">
                    What is SK Reform Act of 2015?
                </v-expansion-panel-title>
                <v-divider></v-divider>
                <v-expansion-panel-text class="faq-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-title class="faq-title">
                    What is NYC?
                </v-expansion-panel-title>
                <v-divider></v-divider>
                <v-expansion-panel-text class="faq-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-title class="faq-title">
                    What is LYDO?
                </v-expansion-panel-title>
                <v-divider></v-divider>
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
