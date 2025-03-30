<template>
    <v-container class="dashboard-main" fluid>
        <!-- Cards Section -->
        <v-container class="cards" justify="center">
                <DashboardCards :card="dashBoardData.skOfficialCount" />
                <DashboardCards :card="dashBoardData.achievementReport" />
                <DashboardCards :card="dashBoardData.announcementReport" />
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

        <!-- Go to Barangay Website Button -->
        <v-btn
        class="d-flex items-center justify-center w-auto px-15 py-10 text-lg"
        color="black"
        height="64"
        @click="openBarangayWebsite"
        >
            GO TO {{ barangayName }} WEBSITE
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
                        details: {}
                    },
                    announcementReport: {
                        type: 'announcements',
                        title: 'ANNOUNCEMENTS',
                        icon: 'mdi-bullhorn',
                        details: {}
                    }
            },
            testData: {
                skOfficial: null
            }
        };
    },
    methods: {
        async getDashboardData() {
            await $.ajax({
                url: `${this.$store.getters.api_base}?e=barangay&a=barangay-dashboard`,
                type: 'POST',
                xhrFields: {
                withCredentials: true
                },
                headers: { 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content },
                data: {
                    barangaySlug: this.$route.params.barangaySlug,
                },
                success: (data) => {
                    console.log(data);
                    this.dashBoardData.skOfficialCount.details = data.data.SkOfficialCount;
                    this.dashBoardData.achievementReport.details = data.data.reportAchievement;
                    this.dashBoardData.announcementReport.details = data.data.reportAnnouncement;
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
        },
        openBarangayWebsite() {
            // Resolve the URL using Vue Router
            // Ensure that your router configuration has a route named 'barangay-website'
            const resolvedRoute = this.$router.resolve({ name: 'barangay-landingpage', params: { slug: this.barangaySlug } });
            // Open the resolved URL in a new window
            window.open(resolvedRoute.href, '_blank');
        },
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
