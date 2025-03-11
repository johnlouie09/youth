
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
<script>
export default {
    data() {
        return {
            form: null,
            firstName: '',
            lastName: '',
            middleInitial: '',
            address: '',
            age: null,
            description: '',
            isSubmitted: false,
            dialog: false
        };
    },
    methods: {
        submitForm() {
            this.$refs.form.validate().then(valid => {
                if (!valid) return;

                const formData = {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    middleInitial: this.middleInitial,
                    address: this.address,
                    age: this.age,
                    description: this.description
                };

                console.log("Form submitted:", formData);
                this.isSubmitted = true;
                setTimeout(() => {
                    this.isSubmitted = false;
                    this.dialog = false;
                }, 2000);
            });
        }
    }
};
</script>

<style scoped>
.success-message {
    color: green;
    font-weight: bold;
    margin-top: 10px;
}
</style>
