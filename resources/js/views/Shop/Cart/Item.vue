<template>
    <a-list-item style="padding: 10px 0;">
        <a-list-item-meta>
            <template #title>
                {{ item.product.name }} x {{ item.quantity }}, <b>{{ formatPrice(item.product.price * item.quantity) }}</b>
            </template>
        </a-list-item-meta>

        <template #actions>
            <a-spin :spinning="loading && loadingId == item.id">
                <a-flex :gap="5">
                    <a-flex :gap="5">
                        <a-button 
                            style="width: 25px;" 
                            size="small"
                            :disabled="item.quantity == 1"
                            @click="modifyQuantity(item.quantity-1)">
                            -
                        </a-button>
                        <a-input
                            style="width: 60px; text-align: center ;"
                            placeholder="К-сть"
                            readonly
                            size="small"
                            v-model:value="item.quantity"/>
                        <a-button 
                            style="width: 25px;" 
                            size="small"
                            @click="modifyQuantity(item.quantity+1)">
                            +
                        </a-button>
                    </a-flex>
                    <a-button
                        danger
                        type="text"
                        size="small"
                        @click="removeFromCart()">
                        X
                    </a-button>
                </a-flex>
            </a-spin>
        </template>
    </a-list-item>
</template>

<script>
import { formatPrice, } from '../../../helpers/helpers'
import { mapActions, mapGetters, } from 'vuex'

export default {
    props: [
        'item',
    ],
    computed: {
        ...mapGetters('cart', ['loading', 'loadingId',]),
    },
    methods: {
        formatPrice,
        ...mapActions('cart', ['changeQuantity', 'deleteCartItem',]),
        async modifyQuantity(quantity) {
            await this.changeQuantity({cartItemId: this.item.id, quantity})
        },
        async removeFromCart() {
            await this.deleteCartItem(this.item.id)
        },
    },
}
</script>