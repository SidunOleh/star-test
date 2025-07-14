<template>
    <component :is="layout">
        <slot></slot>
    </component>
</template>

<script>
import AuthLayout from './Layout/Auth.vue'
import MainLayout from './Layout/Main.vue'

export default {
    components: {
        AuthLayout,
        MainLayout,
    },
    computed: {
        layout() {
            switch (this.$route.name) {
                case 'login':
                    return 'AuthLayout'  
                default:
                    return 'MainLayout'
            }
        }
    },
}
</script>