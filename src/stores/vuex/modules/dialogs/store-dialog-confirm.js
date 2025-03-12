/*
|--------------------------------------------------------------------------
| VUEX MODULE: dialog-confirm
|--------------------------------------------------------------------------
| DialogConfirm global data and methods
*/

export default {
    /**
     * NAMESPACE
     * Encapsulates the module to avoid naming conflicts.
     */
    namespaced: true,


    /**
     * MODULES
     * Submodules.
     */
    modules: {

    },


    /**
     * STATE
     * Stores module-specific data.
     */
    state: {
        opened: false,
        title : 'Confirm',
        color : 'primary',
        prompt: 'Are you sure you want to proceed?',
        yes   : { text: 'Yes', loading: false, callback: null },
        no    : { text: 'No' , loading: false, callback: null }
    },


    /**
     * GETTERS
     * Retrieve and compute derived state values.
     */
    getters: {
        /**
         * Gets the module state.
         */
        state(state) {
            return state
        }
    },


    /**
     * MUTATIONS
     * Modify the state synchronously.
     */
    mutations: {
        /**
         * Shows the confirm dialog with dynamic data.
         * @param {Object} state
         * @param {Object} payload
         */
        show(state, payload) {
            // destructure payload
            const {
                title    = 'Confirm',
                prompt   = 'Are you sure you want to proceed?',
                color    = 'default',
                yesText  = 'Yes',
                noText   = 'No',
                onConfirm = null,
                onCancel  = null
            } = payload;

            // modify module state
            state.opened       = true;
            state.title        = title;
            state.prompt       = prompt;
            state.color        = color;
            state.yes.text     = yesText;
            state.no.text      = noText;
            state.yes.callback = onConfirm;
            state.no.callback  = onCancel;
            state.yes.loading  = false;
            state.no.loading   = false;
        },

        /**
         * Hides the confirm dialog.
         * @param {Object} state
         */
        hide(state) {
            state.opened      = false;
            state.yes.loading = false;
            state.no.loading  = false;
        },

        /**
         * Sets loading state for YES button.
         * @param {Object} state
         * @param {boolean} isLoading
         */
        setLoadingYes(state, isLoading) {
            state.yes.loading = isLoading;
        },

        /**
         * Sets loading state for NO button.
         * @param {Object} state
         * @param {boolean} isLoading
         */
        setLoadingNo(state, isLoading) {
            state.no.loading = isLoading;
        }
    },


    /**
     * ACTIONS
     * Perform asynchronous operations that commit mutations.
     */
    actions: {
        /**
         * Handles confirm (YES) action.
         * @async
         * @param {Object} context
         * @param {Object} context.state
         * @param {Function} context.commit
         * @returns {Promise<void>}
         */
        async confirm({ state, commit }) {
            if (state.yes.callback) {
                commit('setLoadingYes', true);
                try {
                    await state.yes.callback();
                }
                catch (error) {
                    console.error('Error in confirm (YES) callback:', error);
                }
                commit('setLoadingYes', false);
                commit('hide');
            }
        },

        /**
         * Handles cancel (NO) action.
         * @async
         * @param {Object} context
         * @param {Object} context.state
         * @param {Function} context.commit
         * @returns {Promise<void>}
         */
        async cancel({ state, commit }) {
            if (state.no.callback) {
                commit('setLoadingNo', true);
                try {
                    await state.no.callback();
                }
                catch (error) {
                    console.error('Error in cancel (NO) callback:', error);
                }
                commit('setLoadingNo', false);
                commit('hide');
            }
            else {
                commit('hide');
            }
        }
    }
};
