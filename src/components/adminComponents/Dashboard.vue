<template>
    <v-container class="dashboard-main" fluid>
        <!-- Cards Section -->
        <v-row class="cards" justify="center">
            <v-col
                v-for="card in data.cardsData"
                :key="card.title"
                cols="12" md="4"
            >
                <DashboardCards :card="card" />
            </v-col>
        </v-row>

        <!-- Features Section -->
        <v-row class="feats" justify="space-between">
            <!-- Suggestions -->
            <v-col cols="12" md="5">
                <Suggestions />
            </v-col>

            <!-- Analytics & Button -->
            <v-col cols="12" md="7">
                <v-card class="pa-4">
                    <Analytics />
                </v-card>
            </v-col>
        </v-row>

        <v-btn
            class="to-website mt-4"
            color="black"
            height="64"
        >
            GO TO SAN FRANCISCO WEBSITE
        </v-btn>
    </v-container>
</template>

<script>
import DashboardCards from './subcomponents/dashboard/DashboardCards.vue';
import Analytics from './subcomponents/dashboard/Analytics.vue';
import Suggestions from './subcomponents/dashboard/Suggestions.vue';
import $ from 'jquery';

export default {
    components: {
        DashboardCards,
        Analytics,
        Suggestions
    },
    data() {
        return {
            data: {
                cardsData: [
                    {
                        type: 'officials',
                        title: 'OFFICIALS',
                        icon: 'mdi-account-group',
                        details: [
                            { position: 'CHAIRPERSON', number: 1 },
                            { position: 'TREASURER', number: 1 },
                            { position: 'SECRETARY', number: 1 },
                            { position: 'KAGAWADS', number: 1 },
                        ]
                    },
                    {
                        type: 'achievements',
                        title: 'ACHIEVEMENTS',
                        icon: 'mdi-trophy',
                        details: {
                            date: new Date(2025, 1),
                            quantity: 64
                        }
                    },
                    {
                        type: 'announcements',
                        title: 'ANNOUNCEMENTS',
                        icon: 'mdi-bullhorn',
                        details: {
                            date: new Date(2025, 7),
                            quantity: 98
                        }
                    }
                ]
            },
            api_base: (import.meta.env.DEV ? 'http://localhost/youth' : '/youth') + '/app/api.php',
            testData: {
                skOfficial: null
            }
        };
    },
    methods: {
    },
    created() {
    }
};
</script>




<style scoped>
.dashboard-main {
    padding: 36px 72px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}

.cards {
    width: 100%;
}

.feats {
    width: 100%;
}
</style>
