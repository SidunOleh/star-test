<template>
  <a-card hoverable>
    <template #cover>
        <a-image 
            style="height: 200px; object-fit: cover;"
            :src="data.image"/>
    </template>
    <a-card-meta>
        <template #title>
            <router-link :to="{name: 'single-product', params: {id: data.id}}">
                {{ data.name }}
            </router-link>
        </template>
        <template #description>
            {{ formatPrice(data.price) }}
        </template>
    </a-card-meta>
  </a-card>
</template>

<script>
import { formatPrice, } from '../../../helpers/helpers'

export default {
    props: [
        'data',
    ],
    methods: {
        formatPrice,
    },
}
</script>