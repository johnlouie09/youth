<script setup>
import DashboardCards from './subcomponents/dashboard/DashboardCards.vue';
import Analytics from './subcomponents/dashboard/Analytics.vue';
import Suggestions from './subcomponents/dashboard/Suggestions.vue';
import { reactive } from 'vue';

const data = reactive({
    cardsData: [
        {
            type:'officials',
            title:'OFFICIALS',
            icon:'/public/adminAssets/AdminViews/OfficialIcon.svg',
            details: [
                {position: 'CHAIRPESON', number: 1},
                {position: 'TREASURER', number: 1},
                {position: 'SECRETARY', number: 1},
                {position: 'KAGAWADS', number: 1},
            ]
        },
        {
            type:'achievements',
            title:'ACHIEVEMENTS',
            icon:'/public/adminAssets/AdminViews/achievements-icon.svg',
            details: {
                date: new Date(2025, 1),
                quantity: 64
            }
        },
        {
            type:'announcements',
            title:'ANNOUNCEMENTS',
            icon:'/public/adminAssets/AdminViews/announcements-icon.svg',
            details: {
                date: new Date(2025, 7),
                quantity: 98
            }
        }

    ]
})
</script>

<template>
    <div class="dashboard-main">
        <div class="cards">
            <DashboardCards 
                v-for="card in data.cardsData" 
                :key="card.title" 
                :card="card"
            />
        </div>
        <div class="feats">
            <Suggestions></Suggestions>
            <div>
                <Analytics></Analytics>
                <button class="to-website">GO TO SAN FRANCISCO WEBSITE</button>
            </div>
        </div>

    </div>

</template>

<style scoped>
.dashboard-main {
    display: grid;
    grid-template-rows: auto 1fr; /* Adjusted to be flexible */
    row-gap: 58px;
    padding: 36px 72px;
}

.cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    column-gap: 60px;
}

/* Features section */
.feats {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 43px;
}


.to-website {
    background-color: black;
    height: 64px;
    width: 280px

}
</style>