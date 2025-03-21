import { createStore } from 'vuex';

// MODULES
import auth from './store-auth.js';
import viewOfficial from './store-viewOfficial.js'

export default createStore({
  modules: {
    auth,
    viewOfficial
  },
  state: {
    app: {},
    editOfficial: null,
    activeBarangay: null
  },
  getters: {
    base(state) {
      return import.meta.env.BASE_URL;
    },
    getEditOfficial(state) {
      return state.editOfficial;
    },
   },
  mutations: {
    setEditOfficial(state, payload) {
      state.editOfficial = payload;
    }
  }
});
