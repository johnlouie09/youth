// store/modules/viewOfficial.js
export default {
    namespaced: true,
    state: {
      official: {},
      opendialog: false
    },
    getters: {
      // Returns the complete official object.
      getViewOfficial(state) {
        return state.official;
      },
      // Returns whether the dialog is open.
      getViewOfficialOpenDialog(state) {
        return state.opendialog;
      }
    },
    mutations: {
      // Updates the entire official object.
      setViewOfficial(state, payload) {
        state.official = payload;
      },
      // Updates the open dialog state.
      setViewOfficialOpenDialog(state, payload) {
        state.opendialog = payload;
      },
      // Updates the personal information.
      setViewOfficialPersonalInfo(state, payload) {
        state.official.personalInfo = payload;
      }
    }
  };
  