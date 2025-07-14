<template>
    <a-layout style="min-height: 100vh;">
        <a-layout-sider 
            theme='light'
            :collapsed="true">
            <a-button 
                style="margin: 4px 0 0 4px; padding: 5px 13px;"
                type="text"
                @click="submitLogout">
                Logout
            </a-button>

            <a-menu 
                v-model:selectedKeys="selectedKeys" 
                mode="inline">
                <a-menu-item key="products">
                    <template #icon>
                        <ShopOutlined/>
                    </template>
                    <router-link :to="{name: 'products'}">
                        Products
                    </router-link>
                </a-menu-item>

                <a-menu-item key="categories">
                    <template #icon>
                        <UnorderedListOutlined/>
                    </template>
                    <router-link :to="{name: 'categories'}">
                        Categories
                    </router-link>
                </a-menu-item>

                <a-menu-item key="orders">
                    <template #icon>
                        <ShoppingCartOutlined/>
                    </template>
                    <router-link :to="{name: 'orders'}">
                        Orders
                    </router-link>
                </a-menu-item>
            </a-menu>

        </a-layout-sider>

        <a-layout-content class="content" :style="{margin: '24px 16px', padding: '24px', background: '#fff',  'border-radius': '5px',}">
            <slot></slot>
        </a-layout-content>
    </a-layout>
</template>

<script>
import {
    ShoppingCartOutlined,
    ShopOutlined,
    UnorderedListOutlined,
} from '@ant-design/icons-vue'
import { mapActions } from 'vuex'

export default {
    components: {
        ShoppingCartOutlined,
        ShopOutlined,
        UnorderedListOutlined,
    },
    data() {
        return {
            selectedKeys: [],
        }
    },
    methods: {
        ...mapActions('adminAuth', ['logout']),
        async submitLogout() {
            await this.logout()

            this.$router.push({name: 'login'})
        },
    },
    async mounted() {
        await this.$router.isReady()

        this.selectedKeys.push(this.$router.currentRoute.value.name)
    },
}
</script>
