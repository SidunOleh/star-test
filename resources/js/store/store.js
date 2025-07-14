import { createStore } from 'vuex'
import adminAuth from './modules/admin/auth'
import shopAuth from './modules/shop/auth'
import cart from './modules/shop/cart'

const store = createStore({
    modules: {
        adminAuth,
        shopAuth,
        cart,
    },
})

export default store