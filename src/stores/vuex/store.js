/*
|--------------------------------------------------------------------------
| VUEX STORE
|--------------------------------------------------------------------------
| Centralized storage for the SPA
*/

import { createStore } from 'vuex';

/** MODULE IMPORTS */
import dialog from '@/stores/vuex/modules/store-dialog.js';

export default createStore({
    /**
     * MODULES
     * Organize the store into separate modules.
     */
    modules: {
        dialog
    },


    /**
     * STATE
     * Stores global data.
     */
    state: {

    },


    /**
     * GETTERS
     * Retrieve and compute derived state values.
     */
    getters: {

    },


    /**
     * MUTATIONS
     * Modify the state synchronously.
     */
    mutations: {

    },


    /**
     * ACTIONS
     * Perform asynchronous operations that commit mutations.
     */
    actions: {

    }
});
