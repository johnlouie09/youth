<template>
    <v-dialog v-model="dialog.opened" max-width="400" :persistent="dialog.no.loading || dialog.yes.loading">
        <v-card :loading="dialog.no.loading || dialog.yes.loading">
            <!-- Title & Close Button -->
            <v-card-title class="bg-grey-lighten-4 d-flex justify-space-between align-center text-left px-4">
                <span :class="`text-${dialog.color}`" class="text-h6" v-html="dialog.title"></span>
                <v-btn
                    icon
                    variant="text"
                    :disabled="dialog.yes.loading || dialog.no.loading"
                    @click="$store.commit('dialog/confirm/hide')"
                    class="opacity-50"
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-divider/>

            <!-- Message -->
            <v-card-text class="text-left pt-5 pb-4 px-4" v-html="dialog.prompt"></v-card-text>

            <!-- Actions -->
            <v-card-actions class="pa-4 justify-end">
                <!-- NO Button-->
                <v-btn
                    variant="text"
                    :disabled="dialog.yes.loading || dialog.no.loading"
                    class="d-flex align-center"
                    @click="$store.dispatch('dialog/confirm/cancel')"
                >
                    {{ dialog.no.text }}
                </v-btn>

                <!-- YES Button-->
                <v-btn
                    variant="text"
                    :color="dialog.color"
                    :disabled="dialog.yes.loading || dialog.no.loading"
                    class="d-flex align-center"
                    @click="$store.dispatch('dialog/confirm/confirm')"
                >
                    {{ dialog.yes.text }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script>
    export default {
        /** NAME */
        name: 'DialogConfirm',


        /** COMPONENTS */
        components: {

        },


        /** PROPS */
        props: {

        },


        /** DATA */
        data() {
            return {

            };
        },


        /** COMPUTED */
        computed: {
            /**
             * @computed dialog
             * @description The confirm dialog state.
             * @returns {Object}
             */
            dialog() {
                return this.$store.getters['dialog/confirm/state'];
            }
        },


        /** WATCHERS */
        watch: {

        },


        /** METHODS */
        methods: {

        },


        /** MOUNTED */
        mounted() {
            this.$nextTick(() => {

            });
        }
    };
</script>


<style scoped>

</style>
