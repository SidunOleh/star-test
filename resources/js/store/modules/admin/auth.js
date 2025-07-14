import api from '../../../api/admin/auth'

const state = {
    admin: null,
    loading: false,
    error: null,
}

const mutations = {
    SET_ADMIN(state, admin) {
        state.admin = admin
        localStorage.setItem('admin', JSON.stringify(admin))
    },
    SET_LOADING(state, status) {
        state.loading = status
    },
    SET_ERROR(state, error) {
        state.error = error
    },
    LOGOUT_ADMIN(state) {
        state.admin = null
        localStorage.removeItem('admin')
    },
}

const actions = {
    async login({ commit }, credentials) {
        commit('SET_LOADING', true)
        commit('SET_ERROR', null)

        try {
            const user = await api.login(credentials)

            commit('SET_ADMIN', user)
        } catch (err) {
            commit('SET_ERROR', err?.response?.data?.message ?? err.message)
        } finally {
            commit('SET_LOADING', false)
        }
    },
    async logout({ commit }) {
        await api.logout()

        commit('LOGOUT_ADMIN')
    }
}

const getters = {
    admin: (state) => state.admin,
    loading: (state) => state.loading,
    error: (state) => state.error,
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
}