<template>
    <a-layout>
        <a-layout-header style="padding: 0 20px;">
            <a-flex 
                :justify="'space-between'"
                :align="'center'">
                <a-menu
                    v-if="!user"
                    v-model:selectedKeys="selectedKeys"
                    theme="dark"
                    mode="horizontal"
                    style="flex-grow: 1;">
                    <a-menu-item key="catalog">
                        <router-link :to="{name: 'catalog'}">
                            Catalog
                        </router-link>
                    </a-menu-item>
                </a-menu>

                <a-menu
                    v-else
                    v-model:selectedKeys="selectedKeys"
                    theme="dark"
                    mode="horizontal"
                    style="flex-grow: 1;">
                    <a-menu-item key="catalog">
                        <router-link :to="{name: 'catalog'}">
                            Catalog
                        </router-link>
                    </a-menu-item>
                    <a-menu-item key="cart">
                        <router-link :to="{name: 'cart'}">
                            Cart <b>{{ (formatPrice(cartTotal)) }}</b>
                        </router-link>
                    </a-menu-item>
                </a-menu>

                <a-flex :gap="10">
                    <template v-if="!user">
                        <a-typography-link @click="login.open = true">
                            Log In
                        </a-typography-link>
                        
                        <a-typography-link @click="signup.open = true">
                            Sign up
                        </a-typography-link>
                    </template>

                    <template v-else>
                        <a-typography-link @click="submitLogout">
                            Log out
                        </a-typography-link>
                    </template>
                </a-flex>
            </a-flex>
        </a-layout-header>

        <a-layout-content style="padding: 20px 20px">
            <div :style="{ background: '#fff', padding: '15px', minHeight: 'calc(100vh - 105px)' }">
                <slot></slot>
            </div>
        </a-layout-content>
  </a-layout>

  <LogIn 
    v-model:open="login.open"
    @login="reloadPage"/>

  <SignUp 
    v-model:open="signup.open"
    @signUp="reloadPage"/>

</template>

<script>
import { mapActions, mapGetters, } from 'vuex'
import LogIn from './Auth/LogIn.vue'
import SignUp from './Auth/SignUp.vue'
import { formatPrice, } from '../../helpers/helpers'

export default {
    components: {
        LogIn,
        SignUp,
    },
    data() {
        return {
            selectedKeys: [],
            login: {
                open: false,
            },
            signup: {
                open: false,
            },
        }
    },
    computed: {
        ...mapGetters('shopAuth', ['user']),
        ...mapGetters('cart', ['cartTotal']),
    },
    methods: {
        ...mapActions('shopAuth', ['logout']),
        ...mapActions('cart', ['fetchCart']),
        formatPrice,
        async submitLogout() {
            await this.logout()

            this.reloadPage()
        },
        reloadPage() {
            location.reload()
        },
    },
    async mounted() {
        await this.$router.isReady()

        this.selectedKeys.push(this.$router.currentRoute.value.name)

        this.fetchCart()
    },
}
</script>