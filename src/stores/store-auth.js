export default {
    namespaced: true,

    state: {
        user: null
    },

    getters: {
        getUser(state) {
            return state.user;
        },
        getBarangayId(state) {
            return state.user.barangay.id;
        },
        getBarangayName(state) {
            return state.user.barangay.name;
        }
    },

    mutations: {
        setUser(state, payload) {
            state.user = payload;
        }
    }
};