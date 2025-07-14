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

            <template v-if="column.key === 'name'">
                {{ record.name }}
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
        title="Create category"
        action="create"
        v-model:open="create.open"
        @create="updateData"/>

    <Modal
        :title="`Edit ${edit.record?.name}`"
        action="edit"
        v-model:open="edit.open"
        :item="edit.record"
        @edit="updateData"/>

</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../../api/admin/categories'
import { confirmPopup, } from '../../../helpers/helpers'
import {
    DownOutlined,
} from '@ant-design/icons-vue'
import Modal from './Modal.vue'

export default {
    components: {
        DownOutlined,
        Modal,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Name',
                    key: 'name',
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
        }
    },
    methods: {
        confirmPopup,
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
