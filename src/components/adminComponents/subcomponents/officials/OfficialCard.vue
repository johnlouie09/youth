<script setup>
defineProps({
    official: Object
});
</script>

<template>
    <v-card class="official-card" elevation="4">
        <v-card-title class="text-center text-h5 pb-4 border-bottom">
            {{ official.role.toUpperCase() }}
        </v-card-title>
        <v-card-text class="d-flex flex-column align-center mt-4">
            <v-img 
                src="/Sangguniang_Kabataan_logo.svg" 
                alt="SK Logo" 
                contain 
                height="100" 
                width="100"
                class="mb-4"
            ></v-img>
            <h3 class="text-h6 font-weight-medium mt-2">{{ official.name }}</h3>
            <v-btn color="primary" variant="outlined" class="mt-3" to="officials/johndoe">
                EDIT
            </v-btn>
        </v-card-text>
    </v-card>
</template>

<style scoped>
.official-card {
    width: 100%;
    min-width: 300px;
    max-width: 400px;
    padding: 16px;
    border-radius: 12px;
}

.border-bottom {
    border-bottom: 5px solid rgba(55, 114, 255, 0.6);
    padding-bottom: 1rem;
}
</style>
