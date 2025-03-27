import { createStore } from 'vuex';

// MODULES

import auth from './store-auth.js';
import viewOfficial from './store-viewOfficial.js';
import dialog from './vuex/modules/store-dialog.js'

export default createStore({
  modules: {
    auth,
    viewOfficial,
    dialog
  },
  state: {
    app: {},
    csrfToken: null,
    api_base: 'http://localhost/youth/app/api.php'
  },
  getters: {
    base(state) {
      return import.meta.env.BASE_URL;
    },
    api_base(state) {
      return state.api_base;
    },
    getCsrfToken(state) {
      return state.csrfToken;
    }
  },
  mutations: {
    setCsrfToken(state, token) {
      state.csrfToken = token;
    }
  }
});
