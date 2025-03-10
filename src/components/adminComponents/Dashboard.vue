<script setup>
import DashboardCards from './subcomponents/dashboard/DashboardCards.vue';
import Analytics from './subcomponents/dashboard/Analytics.vue';
import Suggestions from './subcomponents/dashboard/Suggestions.vue';
import { reactive } from 'vue';
import $ from 'jquery';

const data = reactive({
    cardsData: [
        {
            type: 'officials',
            title: 'OFFICIALS',
            icon: 'mdi-account-group',  // Changed to MDI icon
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
            icon: 'mdi-trophy', // Changed to MDI icon
            details: {
                date: new Date(2025, 1),
                quantity: 64
            }
        },
        {
            type: 'announcements',
            title: 'ANNOUNCEMENTS',
            icon: 'mdi-bullhorn', // Changed to MDI icon
            details: {
                date: new Date(2025, 7),
                quantity: 98
            }
        }
    ]
});

/// TEST /// DELETE THIS LATER
// api base url
const api_base = (import.meta.env.DEV ? 'http://localhost/youth' : '/youth') + '/app/api.php';

// test data state
const testData = reactive({
    skOfficial: null,
});

// test login method
const testLogin = () => {
    $.ajax({
        type: 'POST', xhrFields: { withCredentials: true },
        url : `${api_base}?e=sk-official&a=login`,
        data: {
            identifier: 'dessa',
            password  : '123456',
            remember  : false
        },
        success: (response) => {
            const skOfficial = response?.data?.sk_official;
            if (skOfficial) {
                testData.skOfficial = skOfficial;
            }
        },
        error: (error) => {
            console.error("Login error: ", error);
        },
        complete: (xhr) => {
            // do additional processing here after success or error
        }
    });
};

// test get session
const testGetSession = () => {
    $.ajax({
        type: 'GET', xhrFields: { withCredentials: true },
        url : `${api_base}?e=sk-official&a=session`,
        data: {

        },
        success: (response) => {
            const skOfficial = response?.data?.sk_official;
            if (skOfficial) {
                testData.skOfficial = skOfficial;
            }
        },
        error: (error) => {
            console.error("Get session error: ", error);
        },
        complete: (xhr) => {
            // do additional processing here after success or error
        }
    });
}

// test logout method
const testLogout = () => {
    if (testData.skOfficial) {
        $.ajax({
            type: 'POST', xhrFields: { withCredentials: true },
            url : `${api_base}?e=sk-official&a=logout`,
            data: {
                username: testData.skOfficial.username,
            },
            success: (response) => {
                testData.skOfficial = null;
            },
            error: (error) => {
                console.error("Logout error: ", error);
            },
            complete: (xhr) => {
                // do additional processing here after success or error
            }
        });
    }
}

testGetSession();
/// TEST /// DELETE THIS LATER
</script>

<template>
    <v-container class="dashboard-main" fluid>
        <!-- // TEST // DELETE LATER -->
        <h1>Test Area</h1>
        <div class="d-flex flex-column align-center ga-3">
            <div v-if="testData.skOfficial">
                <p>Logged In SKOfficial:</p>
                <pre>{{ testData.skOfficial }}</pre>
            </div>
            <div class="d-flex align-center ga-3">
                <v-btn @click="testLogin" color="success">Test Login</v-btn>
                <!--<v-btn @click="testGetSession" color="primary">Test Get Session</v-btn>-->
                <v-btn @click="testLogout" v-if="testData.skOfficial" color="error">Test Logout</v-btn>
            </div>
        </div>
        <!-- // TEST // DELETE LATER -->


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
