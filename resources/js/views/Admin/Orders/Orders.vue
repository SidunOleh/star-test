<template>

    <a-table
        :columns="columns"
        :dataSource="data.data"
        :pagination="{
            pageSize: query.perPage, 
            total: data.meta?.total, 
            onChange: (page, size) => query.perPage = size
        }"
        :bordered="true"
        :loading="loading"
        @change="changeQuery">

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'client'">
                {{ record.client.email }}
            </template>

            <template v-if="column.key === 'order_items'">
                {{ record.order_items.map(orderItem => `${orderItem.name} x ${orderItem.quantity}`).join(', ') }}
            </template>

            <template v-if="column.key === 'total_amount'">
                {{ formatPrice(record.total_amount) }}
            </template>

            <template v-if="column.key === 'status'">
                <a-tag>
                    {{ record.status }}
                </a-tag>
            </template>

            <template v-if="column.key === 'created_at'">
                {{ formatDate(record.created_at) }}
            </template>

        </template>

    </a-table>

</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../../api/admin/orders'
import { formatDate, formatPrice } from '../../../helpers/helpers'

export default {
    data() {
        return {
            columns: [
                {
                    title: 'Client',
                    key: 'client',
                },
                {
                    title: 'Order items',
                    key: 'order_items',
                },
                {
                    title: 'Total',
                    key: 'total_amount',
                    sorter: true,
                },
                {
                    title: 'Status',
                    key: 'status',
                },
                {
                    title: 'Created at',
                    key: 'created_at',
                    sorter: true,
                },
            ],
            data: {},
            query: {
                page: 1,
                perPage: 15,
                orderBy: 'created_at',
                order: 'DESC',
                filters: {},
            },
            loading: false,
        }
    },
    methods: {
        formatPrice,
        formatDate,
        async updateData() {
            try {
                this.loading = true
                this.data = await api.fetch(this.query) 
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        changeQuery(pagination, filters, sorter) {
            this.query.page = pagination.current
    
            this.query.filters = filters

            if (sorter.columnKey) {
                this.query.orderBy = sorter.columnKey
            }
            
            if (sorter.order) {
                this.query.order = sorter.order
                    .replace('ascend', 'ASC')
                    .replace('descend', 'DESC')
            }
        },
    },
    watch: {
        query: {
            handler() {
               this.updateData()
            },
            deep: true,
        },
    },
    mounted() {
       this.updateData()
    },
}
</script>
