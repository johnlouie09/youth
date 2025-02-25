<script setup>
</script>

<template>
    <div class="suggestions-box">
        <h2>YOUTH SUGGESTIONS NOTIFICATIONS</h2>
        <ul>
            <li class="active">UNREAD</li>
            <li>ALL</li>
        </ul>
        <div class="messages">
            <article v-for="n in 9">
                <h3>Youth Skills Development Program</h3>
                <p>Implement monthly workshops on practical skills such as basic coding, graphic design, entrepreneurship, and financial literacy. This will help equip ...........</p>
                <span>1 hr ago</span>
            </article>
        </div>
    </div>
</template>


<style scoped>
    /* Make scrollbar small */
    ::-webkit-scrollbar {
        width: 6px;  /* Set the scrollbar width */
        height: 6px; /* Set the scrollbar height (for horizontal scrollbars) */
    }

    /* Scrollbar track (background) */
    ::-webkit-scrollbar-track {
        background: #1e1e1e;  /* Dark background */
        border-radius: 10px;
    }

    /* Scrollbar thumb (draggable part) */
    ::-webkit-scrollbar-thumb {
        background: #555;  /* Gray thumb */
        border-radius: 10px;
    }

    /* Scrollbar thumb on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #888;  /* Lighter gray on hover */
    }

    .suggestions-box {
        height: 90%;
        width: 100%;

        background-color: #2C2C2C;
        border: 1px solid #373737;
        border-radius: .5rem;
        box-shadow: 0px 15px 15px 0px rgba(0, 0, 0, 0.25);
        
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;

        padding: 36px;
        padding-bottom: 16px;  
        
        gap: 24px;
    }

    h2 {
        font-weight: bolder;
        font-size: 1.25rem;
        width: 100%;
        text-align: center;
    }

    ul {
        width: 100%;
        display: flex;
        gap: 1rem;
    }

    ul li {
        padding: 12px 28px;
        border-bottom: 2px solid #3F3F3F;
        font-weight: bold;
    }

    .active {
        border-bottom: 2px solid #3772FF;
    }

    .messages {
        display: flex;
        flex-direction: column;
        gap: 10px;

        height: 500px;
        width: 100%;
        overflow-y: scroll;
    }

    .messages article{
        background-color: #202020;

        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 5px;
        

        padding: 1.5rem;
        border-radius: .5rem;

        
    }

    article h3 {
        font-size: 1.25rem;
        font-weight: bolder;
    }

    article p, article span {
        font-size: .75rem;
    }

    article span {
        width: 100%;
        text-align: right;
        font-weight: bold;
    }





</style>