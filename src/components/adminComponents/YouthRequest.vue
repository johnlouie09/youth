<template>
    <v-container class="youth-request h-screen">
        <v-sheet class="d-flex flex-col justify-start items-center gap-5 h-screen overflow-y-auto py-5 px-5">
            <h3 class="text-2xl pa-5 gradient-text font-black">YOUTH ACCOUNT REQUESTS</h3>
            <v-card v-for="n of 20" class="w-full min-h-50 d-flex flex-col justify-center items-center gap-5 elevation-10 pa-10 px-8" style="border-radius: 1rem;">
                <div class="w-full d-flex justify-center items-center gap-3">
                    <v-avatar :image='"/OfficialImages/no-avatar.png"' size="75">
                    </v-avatar>

                    <article class="w-auto">
                        <h1>NAME: Charles Harvey Gonzaga</h1>
                        <h1>Email: harveygonzaga222@gmail.com</h1>
                    </article>
                </div>

                <v-card-actions class="actions w-[70%] d-flex justify-evenly items-center pa-0">
                    <!-- The button is hidden by default; CSS will reveal it on hover -->
                    <v-btn class="edit-btn" color="teal-lighten-1">CONFIRM</v-btn>
                    <v-btn class="delete-btn" color="red-lighten-1">REJECT</v-btn>
                </v-card-actions>
            </v-card>
        </v-sheet>
        
        <Suggestions></Suggestions>
       
        
    </v-container>
</template>

<script>
import Suggestions from './subcomponents/dashboard/Suggestions.vue';

export default {
    components: {
        Suggestions
    },
    data() {
        return {
        };
    },
    methods: {
    },
    created() {
        
    }
};
</script>

<style scoped>

.youth-request {
    height: 100vh;
    display: grid;
    grid-template-columns: 35fr 65fr;
    column-gap: 2rem;
}

</style>