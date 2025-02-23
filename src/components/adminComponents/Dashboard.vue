<script setup>
import DashboardCards from './subcomponents/DashboardCards.vue';
import Analytics from './subcomponents/Analytics.vue';
import Suggestions from './subcomponents/Suggestions.vue';
</script>

<template>
    <div class="dashboard-main">
        <div class="cards">
            <DashboardCards></DashboardCards>
            <DashboardCards></DashboardCards>
            <DashboardCards></DashboardCards>
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
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Features section */
.feats {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 43px;
}

.feats div {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 16px;
}

.to-website {
    background-color: black;
    height: 64px;
    width: 280px

}
</style>