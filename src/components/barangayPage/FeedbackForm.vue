<template>
    <div>
        <v-btn icon @click="dialog = true">
            <v-icon>mdi-message</v-icon>
        </v-btn>
     
        <v-dialog v-model="dialog" max-width="800px">
            <v-card class="d-flex justify-center items-center pa-10" style="border-radius: 1rem;">
                <v-card-title class="text-xl font-extrabold">MESSAGE FOR BARANGAY {{ barangayName.toUpperCase() }}</v-card-title>
                
                <v-card-text class="w-full">
                    <v-form ref="form">
                        <v-text-field 
                            class="w-full text-lg"
                            v-model="firstName" 
                            label="Full Name" 
                            variant="outlined"
                            required>
                        </v-text-field>

                        <v-text-field 
                            class="w-full text-lg"
                            v-model="messageTitle" 
                            label="Message Title" 
                            variant="outlined"
                            required>
                        </v-text-field>
                       
                        <v-textarea 
                            v-model="description" 
                            label="Description" 
                            auto-grow 
                            outlined>
                        </v-textarea>
                    </v-form>
                    <p v-if="isSubmitted" class="success-message">Form submitted successfully!</p>
                </v-card-text>

                <v-card-actions>
                    <v-btn color="red-lighten-1" @click="dialog = false">Close</v-btn>
                    <v-btn color="teal-lighten-1" @click="submitForm">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    props: {
        barangayName: String
    },
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

