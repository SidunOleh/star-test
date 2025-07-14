import api from '../../../api/shop/cart'

const state = {
    items: [],
    loading: false,
    loadingId: null,
    error: null
}

const mutations = {
    SET_CART(state, items) {
        state.items = items
    },
    SET_LOADING_ID(state, value) {
        state.loadingId = value
    },
    SET_LOADING(state, value) {
        state.loading = value
    },
    SET_ERROR(state, error) {
        state.error = error
    }
}

const actions = {
    async fetchCart({ commit }) {
        commit('SET_LOADING', true)
        try {
            const data = await api.getCartItems()

            commit('SET_CART', data)
            commit('SET_ERROR', null)
        } catch (err) {
            commit('SET_ERROR', err?.response?.data?.message ?? err.message)
        } finally {
            commit('SET_LOADING', false)
        }
    },
    async addProduct({ dispatch, commit }, productId) {
        commit('SET_LOADING', true)
        try {
            await api.addProduct(productId)

            dispatch('fetchCart')
        } catch (err) {
            commit('SET_ERROR', err?.response?.data?.message ?? err.message)
        } finally {
            commit('SET_LOADING', false)
        }
    },
    async changeQuantity({ dispatch, commit }, {cartItemId, quantity}) {
        commit('SET_LOADING', true)
        commit('SET_LOADING_ID', cartItemId)
        try {
            console.log(quantity)
            await api.changeQuantity(cartItemId, quantity)
            
            dispatch('fetchCart')
        } catch (err) {
            commit('SET_ERROR', err?.response?.data?.message ?? err.message)
        } finally {
            commit('SET_LOADING', false)
            commit('SET_LOADING_ID', null)
        }
    },
    async deleteCartItem({ dispatch, commit }, cartItemId) {
        commit('SET_LOADING', true)
        commit('SET_LOADING_ID', cartItemId)
        try {
            await api.deleteCartItem(cartItemId)

            dispatch('fetchCart')
        } catch (err) {
            commit('SET_ERROR', err?.response?.data?.message ?? err.message)
        } finally {
            commit('SET_LOADING', false)
            commit('SET_LOADING_ID', null)
        }
    },
    async emptyCart({ dispatch, commit }) {
        commit('SET_CART', [])
    },
}

const getters = {
    cartItems: state => state.items,
    cartItemCount: state => state.items.reduce((sum, item) => sum + item.quantity, 0),
    cartTotal: state => state.items.reduce((total, item) => total + item.product.price * item.quantity, 0),
    loading: (state) => state.loading,
    loadingId: (state) => state.loadingId,
    error: (state) => state.error,
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
}