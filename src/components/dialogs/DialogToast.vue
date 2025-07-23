<template>
    <div v-for="pos in positions" :key="pos" class="toast-container" :class="`toast-${pos}`">
        <v-slide-y-transition group>
            <v-alert
                v-for="toast in toastsByPosition(pos)"
                :key="toast.id"
                :type="toast.type"
                class="toast"
                closable
                @click:close="removeToast(toast.id)"
            >
                <div v-html="toast.title"></div>
                <div v-if="toast.message" class="toast-body" v-html="toast.message"></div>

                <div v-if="toast.timed" class="toast-progress">
                    <div :class="`toast-progress-bar bg-${toast.type}`" :style="{ animationDuration: `${Math.min(toast.duration, 10000) / 1000}s` }"></div>
                </div>
            </v-alert>
        </v-slide-y-transition>
    </div>
</template>


<script>
    export default {
        /** NAME */
        name: '',


        /** COMPONENTS */
        components: {

        },


        /** PROPS */
        props: {

        },


        /** DATA */
        data() {
            return {
                positions: [
                    'top',
                    'bottom',
                    'top-left',
                    'top-right',
                    'bottom-left',
                    'bottom-right'
                ]
            };
        },


        /** COMPUTED */
        computed: {
            /**
             * @computed toasts
             * @description The toasts state.
             * @returns {Array}
             */
            toasts() {
                return this.$store.getters['dialog/toast/toasts'];
            }
        },


        /** WATCHERS */
        watch: {
            
        },


        /** METHODS */
        methods: {
            /**
             * @method toastsByPosition
             * @description Filters and returns all toasts that match a specific position.
             * @param {string} position
             * @returns {Array}
             */
            toastsByPosition(position) {
                return this.toasts.filter(toast => toast.position === position);
            },

            /**
             * @method removeToast
             * @description Removes a toast notification by its unique ID.
             * @param {number} id
             */
            removeToast(id) {
                this.$store.commit('dialog/toast/remove', id);
            }
        },


        /** MOUNTED */
        mounted() {
            this.$nextTick(() => {

            });
        },

    };
</script>


<style>
    @keyframes toastCountdown {
        from {
            width: 0;
        }
        to {
            width: 100%;
        }
    }
</style>


<style scoped>
    .toast-container {
        position: fixed;
        z-index: 2147483647;
        max-width: 350px;
    }

    .toast-top {
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
    }

    .toast-bottom {
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
    }

    .toast-top-left {
        top: 20px;
        left: 20px;
    }

    .toast-top-right {
        top: 20px;
        right: 20px;
    }

    .toast-bottom-left {
        bottom: 20px;
        left: 20px;
    }

    .toast-bottom-right {
        bottom: 20px;
        right: 20px;
    }

    .toast {
        margin-bottom: 10px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background-color: rgba(255, 255, 255, 0.3);
        overflow: hidden;
    }

    .toast-progress-bar {
        height: 100%;
        width: 0;
        animation-name: toastCountdown;
        animation-timing-function: linear;
        animation-fill-mode: forwards;
    }

    .toast-body {
        font-size: 0.85rem;
        margin-top: 5px;
        color: inherit;
    }
</style>
