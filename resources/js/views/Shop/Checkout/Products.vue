<template>
    <a-list
        item-layout="horizontal"
        :data-source="cartItems">  
        <template #header>
            <a-typography-text strong>
                    Products
                </a-typography-text>
            </template>

            <template #renderItem="{ item, index }">
                <a-list-item style="padding: 10px 0;">
            <a-list-item-meta>
                <template #title>
                    {{ item.product.name }} x {{ item.quantity }}, <b>{{ formatPrice(item.product.price * item.quantity) }}</b>
                </template>
            </a-list-item-meta>

        </a-list-item>
        </template>
    </a-list>
</template>

<script>
import { mapGetters, } from 'vuex'
import { formatPrice, } from '../../../helpers/helpers'

export default {
    computed: {
        ...mapGetters('cart', ['cartItems']),
    },
    methods: {
        formatPrice,
    },
}
</script>