<script setup>
import { ref } from 'vue';

const form = ref(null);
const firstName = ref('');
const lastName = ref('');
const middleInitial = ref('');
const address = ref('');
const age = ref(null);
const description = ref('');
const isSubmitted = ref(false);
const dialog = ref(false);

const submitForm = () => {
    form.value.validate().then(valid => {
        if (!valid) return;

        const formData = {
            firstName: firstName.value,
            lastName: lastName.value,
            middleInitial: middleInitial.value,
            address: address.value,
            age: age.value,
            description: description.value,
        };

        console.log("Form submitted:", formData);
        isSubmitted.value = true;
        setTimeout(() => {
            isSubmitted.value = false;
            dialog.value = false;
        }, 2000);
    });
};
</script>

<template>
    <div>
        <v-btn @click="dialog = true">Open Form</v-btn>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title class="text-h5">User Information</v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-text-field v-model="firstName" label="First Name" required></v-text-field>
                        <v-text-field v-model="lastName" label="Last Name" required></v-text-field>
                        <v-text-field v-model="middleInitial" label="Middle Initial" maxlength="1"></v-text-field>
                        <v-text-field v-model="address" label="Address" required></v-text-field>
                        <v-text-field v-model="age" label="Age" type="number" required></v-text-field>
                        <v-textarea v-model="description" label="Description" auto-grow outlined></v-textarea>
                    </v-form>
                    <p v-if="isSubmitted" class="success-message">Form submitted successfully!</p>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="grey" @click="dialog = false">Close</v-btn>
                    <v-btn color="primary" @click="submitForm">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<style scoped>
.success-message {
    color: green;
    font-weight: bold;
    margin-top: 10px;
}
</style>
