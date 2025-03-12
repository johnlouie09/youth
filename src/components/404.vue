<template>
    <div class="not-found">

      <div style="margin-top: 200px;"> <router-link to="/">Go back to Home</router-link></div>
    </div>
</template>

<script>

</script>

<style scoped>
.not-found {
    height: 100vh; /* Full viewport height */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: url('/404.jpg') no-repeat center center/cover;
    color: white; /* Ensure text is visible */
}

h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

a {
    font-size: 1.2rem;
    color: #fff;
    background: rgba(0, 0, 0, 0.6);
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s ease;
}

a:hover {
    background: rgb(110, 11, 231);
}
</style>
