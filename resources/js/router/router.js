import { createRouter, createWebHistory } from 'vue-router'
import { defineAsyncComponent } from 'vue'
import Loader from '../views/components/Loader.vue'
import store from '../store/store'

const routes = [{
    path: '/admin/login',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Admin/Auth/Login.vue'),
        loadingComponent: Loader,
    }),
    name: 'login',
    meta: {
        title: 'Login',
    },
}, {
    path: '/admin',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Admin/Products/Products.vue'),
        loadingComponent: Loader,
    }),
    name: 'products',
    meta: {
        title: 'Products',
        admin: true,
    },
}, {
    path: '/admin/categories',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Admin/Categories/Categories.vue'),
        loadingComponent: Loader,
    }),
    name: 'categories',
    meta: {
        title: 'Categories',
        admin: true,
    },
}, {
    path: '/admin/orders',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Admin/Orders/Orders.vue'),
        loadingComponent: Loader,
    }),
    name: 'orders',
    meta: {
        title: 'Orders',
        admin: true,
    },
}, {
    path: '/',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Shop/Products/Catalog.vue'),
        loadingComponent: Loader,
    }),
    name: 'catalog',
    meta: {
        title: 'Catalog',
    },
}, {
    path: '/products/:id',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Shop/Products/Single.vue'),
        loadingComponent: Loader,
    }),
    name: 'single-product',
    meta: {
        title: 'Product',
    },
}, {
    path: '/cart',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Shop/Cart/Cart.vue'),
        loadingComponent: Loader,
    }),
    name: 'cart',
    meta: {
        title: 'Cart',
        private: true,
    },
}, {
    path: '/checkout',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Shop/Checkout/Checkout.vue'),
        loadingComponent: Loader,
    }),
    name: 'checkout',
    meta: {
        title: 'Checkout',
        private: true,
    },
}, ]


const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from) => {
    const admin = store.getters['adminAuth/admin']

    if (to.meta.admin && !admin) {
        router.push({ name: 'login' })
        return false
    }

    const user = store.getters['shopAuth/user']

    if (to.meta.private && !user) {
        router.push({ name: 'catalog' })
        return false
    }

    document.title = `${to.meta.title}`
})

export default router