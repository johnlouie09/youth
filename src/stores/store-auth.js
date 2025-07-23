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
        },
        getBarangaySlug(state) {
            return state.user.barangay.slug;
        }
    },

    mutations: {
        setUser(state, payload) {
            state.user = payload;
        }
    }
};