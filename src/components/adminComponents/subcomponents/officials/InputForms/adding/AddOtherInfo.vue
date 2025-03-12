<template>
    <v-dialog v-model="dialog" max-width="600px" class="other-info-dialog">
        <template v-slot:activator="{ on, attrs }">
            <v-btn class="add-oi-button" v-bind="attrs" @click="dialog = true">
                <v-icon>mdi-plus-circle-outline</v-icon>
                <span class="ml-4">ADD NEW OTHER INFORMATION</span>
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="text-h5 d-flex justify-center">
                NEW OTHER INFORMATION
            </v-card-title>
            <v-card-text>
                <v-form ref="form">
                    <v-text-field v-model="newInfo.title" label="Title" required></v-text-field>

                    <!-- File Upload for Icon -->
                    <v-file-input
                        label="Upload Icon"
                        accept="image/*"
                        @change="handleFileUpload"
                        show-size
                        required
                    ></v-file-input>

                    <!-- Preview Uploaded Icon -->
                    <div v-if="newInfo.icon" class="icon-preview">
                        <v-img :src="newInfo.icon" contain max-height="100" max-width="100"></v-img>
                    </div>

                    <v-combobox
                        v-model="newInfo.details"
                        label="Details (Enter multiple)"
                        multiple
                        chips
                        required
                    ></v-combobox>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn color="grey" @click="dialog = false">Cancel</v-btn>
                <v-btn color="primary" @click="submitForm">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            newInfo: {
                title: '',
                icon: '', // Store image URL here
                details: []
            }
        };
    },
    methods: {
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.newInfo.icon = URL.createObjectURL(file);
            }
        },
        submitForm() {
            if (this.newInfo.title && this.newInfo.details.length && this.newInfo.icon) {
                this.$emit("add-info", { ...this.newInfo });
                this.newInfo = { title: '', icon: '', details: [] };
                this.dialog = false;
            }
        }
    }
};
</script>

<style scoped>
.add-oi-button {
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1.5rem;
    margin: auto;
    font-size: 0.7rem;
}

.other-info-dialog .v-card {
    padding: 2rem;
    border-radius: 1rem;
}

.icon-preview {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}
</style>
