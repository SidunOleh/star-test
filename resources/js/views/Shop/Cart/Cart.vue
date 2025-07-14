<template>
    <a-list
        item-layout="horizontal"
        :data-source="cartItems">  
        <template #header>
            <a-typography-text strong>
                Cart
            </a-typography-text>
        </template>

        <template #renderItem="{ item, index }">
            <Item :item="item"/>
        </template>
    </a-list>

    <a-button
        v-if="cartItems.length"
        type="primary"
        style="margin-top: 20px;"
        @click="$router.push({name: 'checkout'})">
        Checkout
    </a-button>
</template>

<script>
import { mapGetters, } from 'vuex'
import Item from './Item.vue'

export default {
    components: {
        Item,
    },
    computed: {
        ...mapGetters('cart', ['cartItems']),
    }
}
</script>