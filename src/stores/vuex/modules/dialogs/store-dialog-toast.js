/*
|--------------------------------------------------------------------------
| VUEX MODULE: dialog-toast
|--------------------------------------------------------------------------
| DialogToast global data and methods
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
        toasts: [],

        defaults: {
            position: 'bottom-right',
            duration: 2500,
            type    : 'info',
            title   : 'Notification',
            message : ''
        }
    },


    /**
     * GETTERS
     * Retrieve and compute derived state values.
     */
    getters: {
        /**
         * Retrieves the list of active toast notifications.
         * @param {Object} state
         * @returns {Array}
         */
        toasts(state) {
            return state.toasts;
        }
    },


    /**
     * MUTATIONS
     * Modify the state synchronously.
     */
    mutations: {
        /**
         * Adds a new toast notification to the state.
         * @param {Object} state
         * @param {Object} payload
         */
        add(state, payload) {
            state.toasts.push(payload);
        },

        /**
         * Removes a toast notification by its unique ID.
         * @param {Object} state
         * @param {number} id
         */
        remove(state, id) {
            state.toasts = state.toasts.filter(toast => toast.id !== id);
        }
    },


    /**
     * ACTIONS
     * Perform asynchronous operations that commit mutations.
     */
    actions: {
        /**
         * Displays a toast notification.
         * @param {Object} context
         * @param {Object} context.state
         * @param {Function} context.commit
         * @param {Object} [options={}]
         * @param {string} [options.type]
         * @param {string} [options.title]
         * @param {string} [options.message]
         * @param {string} [options.position]
         * @param {number} [options.duration]
         * @param {boolean} [options.timed]
         */
        show({ commit, state }, options = {}) {
            // create unique id
            const id = Date.now();

            // destructure options
            const {
                type     = state.defaults.type,
                title    = state.defaults.title,
                message  = state.defaults.message,
                position = state.defaults.position,
                duration = state.defaults.duration,
                timed    = duration > 0
            } = options;

            // add the toast
            commit('add', { id, type, title, message, timed, duration, position });

            // set remove timeout
            if (timed) {
                setTimeout(() => {
                    commit('remove', id);
                }, duration);
            }
        },

        /**
         * Displays a success toast notification.
         * @param {Object} context
         * @param {Function} context.dispatch
         * @param {Object} [options={}]
         */
        success({ dispatch }, options = {}) {
            const { type, ...rest } = options;
            dispatch('show', {
                type: 'success',
                title: options.title || 'Success',
                message: options.message || 'Action completed.',
                ...rest
            });
        },

        /**
         * Displays an error toast notification.
         * @param {Object} context
         * @param {Function} context.dispatch
         * @param {Object} [options={}]
         */
        error({ dispatch }, options = {}) {
            const { type, ...rest } = options;
            dispatch('show', {
                type: 'error',
                title: options.title || 'Error',
                message: options.message || 'Something went wrong.',
                ...rest
            });
        },

        /**
         * Displays a warning toast notification.
         * @param {Object} context
         * @param {Function} context.dispatch
         * @param {Object} [options={}]
         */
        warning({ dispatch }, options = {}) {
            const { type, ...rest } = options;
            dispatch('show', {
                type: 'warning',
                title: options.title || 'Warning',
                message: options.message || 'Proceed with caution.',
                ...rest
            });
        },

        /**
         * Displays an info toast notification.
         * @param {Object} context
         * @param {Function} context.dispatch
         * @param {Object} [options={}]
         */
        info({ dispatch }, options = {}) {
            const { type, ...rest } = options;
            dispatch('show', {
                type: 'info',
                title: options.title || 'Info',
                message: options.message || 'Take note of this.',
                ...rest
            });
        }
    }
};
