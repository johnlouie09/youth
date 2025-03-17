import { createStore } from 'vuex';

// MODULES
import auth from './store-auth.js';

export default createStore({
  modules: {
    auth
  },
  state: {
    app: {},
    activeBarangay: null,
    editOfficial: null
  },
  getters: {
    base(state) {
      return import.meta.env.BASE_URL;
    },

    getActiveBarangay(state) {
        return state.activeBarangay;
    },

    getEditOfficial(state) {
      return state.editOfficial;
  }
  },
  mutations: {
    setActiveBarangay(state, payload) {
      state.activeBarangay = payload;
    },

    setEditOfficial(state, payload) {
      state.editOfficial = payload;
    }
  }
});
