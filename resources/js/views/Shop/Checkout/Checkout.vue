<template>
    <Products/>

    <div style="margin-top: 10px; font-size: 16px;">
        Total: <b>{{ formatPrice(cartTotal) }}</b>
    </div>

    <a-textarea 
        style="margin-top: 10px;"
        placeholder="Write comment"
        :rows="8"
        v-model:value="data.comment"/>

    <a-button
        v-if="cartItems.length"
        type="primary"
        style="margin-top: 20px;"
        :loading="loading"
        @click="checkout">
        Order
    </a-button>
</template>

<script>
import { mapGetters, mapActions, } from 'vuex'
import Products from './Products.vue'
import { formatPrice, } from '../../../helpers/helpers'
import api from '../../../api/shop/orders'
import { message } from 'ant-design-vue'

export default {
    components: {
        Products,
    },
    data() {
        return {
            data: {
                comment: '',
            },
            loading: false,
        }
    },
    computed: {
        ...mapGetters('cart', ['cartItems', 'cartTotal']),
    },
    methods: {
        formatPrice,
        ...mapActions('cart', ['emptyCart']),
        async checkout() {
            try {
                this.loading = true
                await api.create(this.data)
                this.emptyCart()
                this.$router.push({name: 'catalog'})
                message.success('Order successfully created')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
}
</script>