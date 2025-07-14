import axios from 'axios'
import router from './router/router'
import store from './store/store'

window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

window.axios.interceptors.response.use(response => {
    return response
}, async err => {
    if (
        err.response &&
        err.response.status == 419 ||
        (err.response.status == 401 &&
            (err.config.url != '/login' || err.config.url != '/admin/login'))
    ) {
        if (router.currentRoute.value.path.match(/^\/admin/)) {
            store.commit('adminAuth/LOGOUT_ADMIN')
            router.push({ name: 'login' })
        } else {
            store.commit('shopAuth/LOGOUT')
        }

        return Promise.reject(err)
    }

    return Promise.reject(err)
})