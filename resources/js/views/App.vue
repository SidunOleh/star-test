<template>
    <AdminApp v-if="$route.path.match(/^\/admin/)">
        <router-view/>
    </AdminApp>

    <ShopApp v-else>
        <router-view/>
    </ShopApp>
</template>

<script>
import ShopApp from './Shop/App.vue'
import AdminApp from './Admin/App.vue'

export default {
    components: {
        ShopApp,
        AdminApp,
    },
}
</script>