<script setup>
    import { ref } from 'vue';
    // Personal information data (Pre-filled but editable)
    defineProps({
        personalInfo: Object
    });

</script>

<template>
    <!-- Personal Information Section -->
    <v-card class="personal-info" elevation="5">
        <!-- Title with Icon -->
        <v-card-title class="title d-flex align-center justify-center">
            <v-icon class="me-2" size="30">mdi-account-circle</v-icon>
            <h2 class="mb-0">Personal Information</h2>
        </v-card-title>

        <!-- Form -->
        <v-card-text class="form-content">
            <v-form>
                <v-text-field v-model="personalInfo.name" label="Full Name" variant="outlined" clearable></v-text-field>     
                <v-text-field v-model="personalInfo.email" label="Email" variant="outlined" type="email" clearable></v-text-field>                   
                <v-text-field v-model="personalInfo.birthday" label="Birthday" variant="outlined" type="date"></v-text-field>
                <v-btn color="primary" block class="mt-4">Save Changes</v-btn>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<style scoped>
/* Personal Info Card */
.personal-info {
    width: 60%;
    border-radius: 1rem;
    padding: 1.5rem;
}

/* Title Section */
.title {
    text-align: center;
    padding: 1rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Form Spacing */
.form-content {
    padding-top: 1.5rem;
    width: 70%;
    margin: 0 auto;
}
</style>