<template>
    <v-dialog v-model="isDialogOpen" max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline">TANGINA nYOOOOO</span>
            </v-card-title>
            <v-card-text>
                <p>ILABYUUUUUUUUUU.</p>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue" text @click="closeDialog">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data() {
        return {
            isDialogOpen: false,
        };
    },
    methods: {
        openDialog() {
            this.isDialogOpen = true;
        },
        closeDialog() {
            this.isDialogOpen = false;
        },
    },
};
</script>
