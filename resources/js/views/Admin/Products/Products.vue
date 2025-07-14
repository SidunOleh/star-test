<template>

    <a-flex 
        style="margin-bottom: 10px;"
        @click="create">
        <a-button @click="create.open = true">
            Create
        </a-button>
    </a-flex>

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

            <template v-if="column.key === 'image'">
                <a-image 
                    v-if="record.image"
                    :width="100" 
                    :height="100"
                    style="object-fit: cover;"
                    :src="record.image"/>
            </template>

            <template v-if="column.key === 'name'">
                {{ record.name }}
            </template>

            <template v-if="column.key === 'description'">
                {{ record.description }}
            </template>

            <template v-if="column.key === 'price'">
                {{ formatPrice(record.price) }}
            </template>

            <template v-if="column.key === 'actions'">
                <a-dropdown>
                    <a 
                        class="ant-dropdown-link" 
                        @click.prevent>
                        Actions
                        <DownOutlined/>
                    </a>
                    <template #overlay>
                        <a-menu>
                            <a-menu-item @click="edit.open = true; edit.record = record;">
                                <a href="javascript:;">
                                    Edit
                                </a>
                            </a-menu-item>
                            <a-menu-item 
                                danger
                                @click="confirmPopup(() => destroy(record), `Are you sure you want to delete ${record.name}?`)">
                                <a href="javascript:;">
                                    Delete
                                </a>
                            </a-menu-item>
                        </a-menu>
                    </template>
                </a-dropdown>
            </template>

        </template>

    </a-table>

    <Modal
        title="Create product"
        action="create"
        :categories="categories"
        v-model:open="create.open"
        @create="updateData"/>

    <Modal
        :title="`Edit ${edit.record?.name}`"
        action="edit"
        v-model:open="edit.open"
        :categories="categories"
        :item="edit.record"
        @edit="updateData"/>

</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../../api/admin/products'
import { confirmPopup, formatPrice, } from '../../../helpers/helpers'
import {
    DownOutlined,
} from '@ant-design/icons-vue'
import Modal from './Modal.vue'
import categoriesApi from '../../../api/admin/categories'

export default {
    components: {
        DownOutlined,
        Modal,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Image',
                    key: 'image',
                },
                {
                    title: 'Name',
                    key: 'name',
                    sorter: true,
                },
                {
                    title: 'Description',
                    key: 'description',
                },
                {
                    title: 'Price',
                    key: 'price',
                    sorter: true,
                },
                {
                    key: 'actions',
                    align: 'center',
                    width: '200px',
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
            create: {
                open: false,
            },
            edit: {
                open: false,
                record: null,
            },
            categories: [],
        }
    },
    methods: {
        confirmPopup,
        formatPrice,
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
        async destroy(record) {
            try {
                await api.delete(record.id)
                message.success('Successfully deleted.')
                this.updateData()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
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
        async fetchCategories() {
            try {
                this.categories = await categoriesApi.all() 
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
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
       this.fetchCategories()
    },
}
</script>
