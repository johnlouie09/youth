<template>
    <div class="hero-container">
        <div class="content">
            <div><img src="/Group.svg"></div>
            <h1>YOUTH ORIENTED UNIFIED TRANSPARENCY HUB</h1>
            <h2>IRIGA CITY</h2>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HeroSection'
}
</script>

<style scoped>
.hero-container {
    position: Relative;
    top: 18px;
    left: 24px;
    right: 0;
    background: linear-gradient(135deg, #1a1919 0%, #1f1d1d 100%);
    height: 150vh;
    width: 1300px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    overflow: hidden;
    border-radius: 20px;
}
.hero-container::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 75px;
    background-color: #ffffff;
    border-top-left-radius: 50% 50px;
    border-top-right-radius: 50% 50px;
}
.content {
    z-index: 1;
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.content img {
    width: 150px; /* Adjust size as needed */
    margin-bottom: 20px;
}




h1 {
    font-weight: bold;
    font-size: 2.5rem;
    background: linear-gradient(to left, #3772FF 20%, #DF2935 50%, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block; /* Ensures the gradient applies properly */
    animation: animate-gradient 2.5s linear infinite;
    letter-spacing: 0px;
    word-spacing: 0px;
    white-space: nowrap;
}

@keyframes animate-gradient {
    from {
        background-position: 200% 50%;
    }
    to {
        background-position: 0% 50%;
    }
}

h2 {
    font-weight: bold;
    font-size: 3rem;
    margin-top: 5px;
    background: linear-gradient(to left, #3772FF 20%, #DF2935 50%, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animate-gradient 2.5s linear infinite;
}
</style>
