<template>
    <div class="hero-container elevation-10">
        <video class="background-video" id="bg-video" autoplay loop muted playsinline>
            <source src="../assets/video (2).mp4" type="video/mp4">
        </video>
        <div class="content">
            <div><img src="/Group.svg"></div>
            <h1>YOUTH ORIENTED UNIFIED TRANSPARENCY HUB</h1>
            <h2>IRIGA CITY</h2>
        </div>
    </div>
</template>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const video = document.getElementById("bg-video");
    video.play().catch(error => console.error("Autoplay failed:", error));
});


</script>

<style scoped>
.hero-container {
    position: relative;
    padding: 20px;
    height: 110vh;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    overflow: hidden;
    clip-path: ellipse(130% 95% at 50% 0%);
}

.background-video {
    filter: brightness(60%);
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

h1, h2 {
    will-change: transform, opacity;
    font-weight: bold;
    background: linear-gradient(to left, #3772FF 20%, #DF2935 50%, #FDCA40, #3772FF);
    background-size: 200% 100%;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: animate-gradient 2.5s linear infinite;
}

h1 {
    font-size: 2.5rem;
    display: inline-block; /* Ensures the gradient applies properly */
    letter-spacing: 0px;
    word-spacing: 0px;
    white-space: nowrap;
}

h2 {
    font-size: 3rem;
    margin-top: 5px;
}

@keyframes animate-gradient {
    from {
        background-position: 200% 50%;
    }
    to {
        background-position: 0% 50%;
    }
}
</style>