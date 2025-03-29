<template>
    <v-container class="dashboard-main" fluid>
        <!-- Cards Section -->
        <v-row class="cards" justify="center">
            <v-col
                cols="12" md="4"
            >
                <DashboardCards :card="dashBoardData.skOfficialCount" />
            </v-col>
        </v-row>

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
    created() {
        this.getDashboardData();
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
