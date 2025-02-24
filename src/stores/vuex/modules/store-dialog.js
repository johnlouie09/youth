/*
|--------------------------------------------------------------------------
| VUEX MODULE: dialog
|--------------------------------------------------------------------------
| Dialog global data and methods
*/

/** SUBMODULE IMPORTS */
import message from './dialogs/store-dialog-message.js';
import confirm from './dialogs/store-dialog-confirm.js';
import toast   from './dialogs/store-dialog-toast.js';

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
        message,
        confirm,
        toast
    },


    /**
     * STATE
     * Stores module-specific data.
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
};
