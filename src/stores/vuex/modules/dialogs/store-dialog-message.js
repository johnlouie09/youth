/*
|--------------------------------------------------------------------------
| VUEX MODULE: dialog-message
|--------------------------------------------------------------------------
| DialogMessage global data and methods
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
        opened : false,
        title  : 'Message',
        message: 'Operation completed successfully.',
        ok     : { text: 'OK', loading: false, callback: null }
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
            return state;
        }
    },


    /**
     * MUTATIONS
     * Modify the state synchronously.
     */
    mutations: {
        /**
         * Shows the message dialog with dynamic data.
         * @param {Object} state
         * @param {Object} payload
         */
        show(state, payload) {
            // destructure payload
            const {
                title   = 'Message',
                message = 'Operation completed successfully.',
                color   = 'primary',
                okText  = 'OK',
                onOk = null
            } = payload;

            // modify module state
            state.opened      = true;
            state.title       = title;
            state.message     = message;
            state.color       = color;
            state.ok.text     = okText;
            state.ok.callback = onOk;
            state.ok.loading  = false;
        },

        /**
         * Hides the message dialog.
         * @param {Object} state
         */
        hide(state) {
            state.opened     = false;
            state.ok.loading = false;
        },

        /**
         * Sets loading state for OK button.
         * @param {Object} state
         * @param {boolean} isLoading
         */
        setLoadingOk(state, isLoading) {
            state.ok.loading = isLoading;
        }
    },


    /**
     * ACTIONS
     * Perform asynchronous operations that commit mutations.
     */
    actions: {
        /**
         * Handles OK action.
         * @async
         * @param {Object} context
         * @param {Object} context.state
         * @param {Function} context.commit
         * @returns {Promise<void>}
         */
        async ok({ state, commit }) {
            if (state.ok.callback) {
                commit('setLoadingOk', true);
                try {
                    await state.ok.callback();
                }
                catch (error) {
                    console.error('Error in OK callback:', error);
                }
                commit('setLoadingOk', false);
            }
            commit('hide');
        }
    }
};
