<template>
    <dialog-message/>
    <dialog-confirm/>
    <dialog-toast/>
</template>


<script>
    import { defineAsyncComponent } from 'vue';

    export default {
        /** NAME */
        name: 'Dialogs',


        /** COMPONENTS */
        components: {
            'dialog-message': defineAsyncComponent(() => import('@/components/dialogs/DialogMessage.vue')),
            'dialog-confirm': defineAsyncComponent(() => import('@/components/dialogs/DialogConfirm.vue')),
            'dialog-toast'  : defineAsyncComponent(() => import('@/components/dialogs/DialogToast.vue'))
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
        },

    };
</script>


<style scoped>

</style>
