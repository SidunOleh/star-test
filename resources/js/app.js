import './bootstrap'
import { createApp } from 'vue'
import App from './views/App.vue'
import router from './router/router'
import store from './store/store'
import Antd from 'ant-design-vue'

const admin = localStorage.getItem('admin')
if (admin) {
    store.commit('adminAuth/SET_ADMIN', JSON.parse(admin))
}

const user = localStorage.getItem('user')
if (user) {
    store.commit('shopAuth/SET_USER', JSON.parse(user))
}

const app = createApp(App)
app.use(router)
app.use(store)
app.use(Antd)
app.mount('#app')