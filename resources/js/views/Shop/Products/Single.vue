<template>
    <a-skeleton 
        v-if="!data"
        :paragraph="{ rows: 10 }"/>

    <template v-else>
        <a-typography-title :level="2">
            {{ data.name }}
        </a-typography-title>
        <a-image    
            style="height: 250px; width: 250px; object-fit: cover;"
            :src="data.image"/>
        <a-descriptions title="Product Info">
            <a-descriptions-item label="Name">
                <b>{{ data.name }}</b>
            </a-descriptions-item>
            <a-descriptions-item label="Description">
                <b>{{ data.description }}</b>
            </a-descriptions-item>
            <a-descriptions-item label="Categories">
                <b>{{ data.categories?.map(category => category.name).join(', ') }}</b>
            </a-descriptions-item>
            <a-descriptions-item label="Price">
                <b>{{ formatPrice(data.price) }}</b>
            </a-descriptions-item>
        </a-descriptions>
        <a-button
            v-if="user"
            type="primary"
            style="margin-top: 20px;"
            :loading="loading"
            @click="addToCart">
            Add to cart
        </a-button>
    </template>
</template>
  
<script>
import { message, } from 'ant-design-vue'
import { formatPrice, } from '../../../helpers/helpers'
import api from '../../../api/shop/products'
import { mapGetters, mapActions, } from 'vuex'

export default {
    data() {
        return {
            data: null,
        }
    },
    computed: {
        ...mapGetters('shopAuth', ['user']),
        ...mapGetters('cart', ['loading', 'error']),
    },
    methods: {
        ...mapActions('cart', ['addProduct']),
        formatPrice,
        async fetchData() {
            try {
                this.data = await api.show(this.$route.params.id)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async addToCart() {
            await this.addProduct(this.$route.params.id)

            if (!this.error) {
                message.success('Successfully added to cart.')
            } else {
                message.error(this.error)
            }
        },
    },
    mounted() {
        this.fetchData()
    },
}
</script>