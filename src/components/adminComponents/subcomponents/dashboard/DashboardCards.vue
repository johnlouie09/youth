<script setup>
    import { reactive } from 'vue';
    defineProps({
        card: Object, // Receiving `card` prop dynamically
    });
</script>

<template>
    <div>
        <section :class="['card-title', card.type]">
            {{ card.title }}
        </section>
        <section class="card-body">
            <img :src="card.icon" alt="Icon">

            <!-- Officials Section -->
            <section v-if="card.type === 'officials'">
                <p v-for="detail in card.details" :key="detail.position">
                    <span>{{ detail.number }}</span> {{ detail.position }}
                </p>
            </section>

            <!-- Achievements Section -->
            <section class="annach" v-else-if="card.type === 'achievements'">
                <section>
                    <h4>
                        {{ card.details.date.toLocaleString('en-US', { month: 'short' }).toUpperCase() }} 
                        - {{ card.details.date.getFullYear() }}
                    </h4>                    
                    <img src="/public/adminAssets/AdminViews/small-arrow-right.svg" alt="">
                </section>
                <h2>{{ card.details.quantity }}</h2>
                <h5>TOTAL</h5>
            </section>

            <section class="annach" v-else-if="card.type === 'announcements'">
                <h4>
                    {{ card.details.date.toLocaleString('en-US', { month: 'short' }).toUpperCase() }} 
                    - {{ card.details.date.getFullYear() }}
                </h4>
                <h2>{{ card.details.quantity }}</h2>
                <h5>TOTAL</h5>
            </section>

        </section>
    </div>
</template>

<style scoped>
    div {
        height: 256px;
        background-color: #2C2C2C;
        border-radius: .5rem;
        box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);

        display: grid;
        grid-template-rows: 50px auto;
    }

    .card-title {
        display: flex;
        justify-content: center;
        align-items: center;

        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        border-radius: .5rem 0.5rem 0rem 0rem;
    }

    .officials {
        background-color: rgb(55, 114, 255, 0.7);
    }

    .achievements {
        background-color: rgba(223, 41, 53, 0.7); /* 70% opacity */
    }

    .announcements {
        background-color: rgb(253, 202, 64, 0.7); /* 70% opacity */
    }


    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 64px;

    }

    .officials .card-body section{
        display: flex;
        flex-direction: column;
        gap: 4px; /* Adjust the gap size as needed */
    }

    .card-body p span {
    font-weight: bold;
    font-size: 22px;
    }

    .annach{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .annach section {
        display: flex;
        gap: 1rem;
    }

    .annach h4 {
        font-size: 1rem;
        font-weight: 700;
        justify-content: center;
    }

    .annach h2 {
        font-size: 5rem;
        font-weight: bolder;
        line-height: 5rem;
        justify-content: center;
    }

    .annach h5 {
        font-size: .5rem;
        font-weight: bolder;
        justify-content: center;
    }

</style>