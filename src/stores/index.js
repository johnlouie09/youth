import {createStore} from 'vuex';

// MODULES
import auth from './store-auth.js';


export default createStore({
    modules: {
        auth
    },
    state: {
        app: {
        },
        activeBarangay: null,
    },

    getters: {
        base(state) {
            return import.meta.env.BASE_URL;
        }
    },

    mutations: {
        setActiveBarangay(state, payload) {
            state.activeBarangay = payload;
        }
    },

})


