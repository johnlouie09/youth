<template>
    <v-container max-width="900px">
        <div class="gradient-text">
            <h1>Frequently Asked Questions</h1>
        </div>

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
                    The Sangguniang Kabataan (SK) is the youth council in every barangay in the Philippines. It serves as the governing body representing the youth in local governance and decision-making. The SK was established under Republic Act No. 7160 (Local Government Code of 1991) and later reformed by Republic Act No. 10742 (Sangguniang Kabataan Reform Act of 2015) to enhance youth participation in governance.
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
                    The National Youth Commission (NYC) is the primary government agency in the Philippines responsible for formulating policies, programs, and initiatives for youth development. It was established through Republic Act No. 8044 (Youth in Nation-Building Act) in 1995 and operates under the Office of the President of the Philippines.
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
                    The Local Youth Development Office (LYDO) is a government office established in cities and municipalities in the Philippines to oversee youth-related programs and initiatives. It works closely with the Sangguniang Kabataan (SK), youth organizations, and other stakeholders to promote youth development, empowerment, and participation in governance.
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>

        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-title class="faq-title">
                    What information about SK officials is available to the public?
                </v-expansion-panel-title>
                <v-divider></v-divider>
                <v-expansion-panel-text class="faq-text">
                    The platform displays each SK official’s name, barangay, position, advocacies, platforms, leadership experience, and notable accomplishments. However, personal contact details are kept private for security reasons.
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
<script setup lang="ts">
</script>