import {createStore} from 'vuex';
import createPersistedState from 'vuex-persistedstate';

// MODULES
import auth from './store-auth.js';


export default createStore({
    modules: {
        auth
    },
    plugins: [createPersistedState()],
    state: {
        app: {
        },
    },

    getters: {
        base(state) {
            return import.meta.env.BASE_URL;
        }
    },

    mutations: {
    },

})