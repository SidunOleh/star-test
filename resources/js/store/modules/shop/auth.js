import api from '../../../api/shop/auth'

const state = {
    user: null,
    loading: false,
    error: null,
}

const mutations = {
    SET_USER(state, user) {
        state.user = user
        localStorage.setItem('user', JSON.stringify(user))
    },
    SET_LOADING(state, status) {
        state.loading = status;
    },
    SET_ERROR(state, error) {
        state.error = error;
    },
    LOGOUT(state) {
        state.user = null
        localStorage.removeItem('user')
    },
}

const actions = {
    async login({ commit }, credentials) {
        commit('SET_LOADING', true)
        commit('SET_ERROR', null)
        
        try {
            const user = await api.login(credentials)

            commit('SET_USER', user)
        } catch (err) {
            commit('SET_ERROR', err?.response?.data?.message ?? err.message)
        } finally {
            commit('SET_LOADING', false)
        }
    },
    async signUp({ commit }, credentials) {
        commit('SET_LOADING', true)
        commit('SET_ERROR', null)

        try {
            const user = await api.signUp(credentials)

            commit('SET_USER', user)
        } catch (err) {
            commit('SET_ERROR', err?.response?.data?.message ?? err.message)
        } finally {
            commit('SET_LOADING', false)
        }
    },
    async logout({ commit }) {
        await api.logout()

        commit('LOGOUT')
    }
}

const getters = {
    user: (state) => state.user,
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