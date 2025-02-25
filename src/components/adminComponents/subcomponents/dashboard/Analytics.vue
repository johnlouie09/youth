<script setup>
</script>

<template>
    <div class="analytics-box">
        <nav>
            <ul>
                <li class="active">DAILY</li>
                <li>MONTHLY</li>
                <li>YEARLY</li>
            </ul>
        </nav>

        <section>

        </section>
    </div>
</template>

<style scoped>
    .analytics-box {
        font-family: 'Inter', sans-serif;

        height: 75%;
        width: 100%;
        
        background-color: #2C2C2C;
        border: 1px solid #373737;
        border-radius: .5rem;
        box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);

        padding: 1.5rem 3rem;

        display: flex;
        gap: 1.5rem;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
    }

    nav {
        width: 90%;
    }

    ul {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 4rem;
        width: 100%;

    }

    ul li {
        width: 100%;
        padding: .5rem 1rem;
        border-bottom: 4px solid #3F3F3F;
        font-weight: bold;

        text-align: center;

        font-size: 1.25rem;
    }
    
    .active {
        border-bottom: 4px solid #3772FF;

    }

    .analytics-box section {
        width: 100%;
        height: 100%;
        background-color: black;
    }




</style>