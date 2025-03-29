<template>
    <v-container class="dashboard-main" fluid>
        <!-- Cards Section -->
        <v-container class="cards" justify="center">
                <DashboardCards :card="dashBoardData.skOfficialCount" />
                <DashboardCards :card="dashBoardData.skOfficialCount" />
                <DashboardCards :card="dashBoardData.skOfficialCount" />
        </v-container>

        <!-- Features Section -->
        <!-- <v-row class="feats" justify="space-between">
       
            <v-col cols="12" md="5">
                <Suggestions />
            </v-col>

            <v-col cols="12" md="7">
                <v-card class="pa-4">
                    <Analytics />
                </v-card>
            </v-col>
        </v-row> -->

        <v-btn
            class="d-flex items-center justify-center w-auto px-15 py-10 text-lg"
            color="black"
            height="64"
        >
            GO TO {{ this.$store.getters['auth/getBarangayName'] }} WEBSITE
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
            dashBoardData: {
                    skOfficialCount: {
                        type: 'officials',
                        title: 'OFFICIALS',
                        icon: 'mdi-account-group',
                        details: []
                    },

                    achievementReport: {
                        type: 'achievements',
                        title: 'ACHIEVEMENTS',
                        icon: 'mdi-trophy',
                        details: {
                            date: new Date(2025, 1),
                            quantity: 64
                        }
                    },
                    announcementReport: {
                        type: 'announcements',
                        title: 'ANNOUNCEMENTS',
                        icon: 'mdi-bullhorn',
                        details: {
                            date: new Date(2025, 7),
                            quantity: 98
                        }
                    }
            },
            api_base: (import.meta.env.DEV ? 'http://localhost/youth' : '/youth') + '/app/api.php',
            testData: {
                skOfficial: null
            }
        };
    },
    methods: {
        async getDashboardData() {
            const api_base = 'http://localhost/youth/app/api.php';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            await $.ajax({
                url: `${api_base}?e=barangay&a=barangay-dashboard`,
                type: 'POST',
                xhrFields: {
                withCredentials: true
                },
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                data: {
                    barangaySlug: this.$route.params.barangaySlug,
                },
                success: (data) => {
                    this.dashBoardData.skOfficialCount.details = data.data.SkOfficialCount
                },

                error: (jqXHR, textStatus, errorThrown) => {
                    console.error("Error:", textStatus, errorThrown);
                    let errorMsg = "An error occurred while processing your request.";
                    if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                        errorMsg = jqXHR.responseJSON.message;
                    } else if (jqXHR.responseText) {
                        errorMsg = jqXHR.responseText;
                    }
                    this.requestError = errorMsg;
                    },
                complete: () => {
                    this.loading = false;
                }
            });
        }
    },
    computed: {
        barangayName() {
            return this.$store.getters['auth/getBarangayName'];
        }
    },
    created() {
        this.getDashboardData();
    }
};
</script>




<style scoped>
.dashboard-main {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    height: 100vh;
    padding: 4rem;
    gap: 2rem;
}

.cards {
    display: flex;
    justify-content: space-evenly;
    flex-wrap: wrap;
    gap: 4rem;
    width: 100%;
}

.feats {
    width: 100%;
}
</style>
