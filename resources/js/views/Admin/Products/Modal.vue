<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

            <a-form-item 
                label="Image"
                :required="true"
                has-feedback
                :validate-status="errors['image'] ? 'error' : ''"
                :help="errors.image">
                <Upload v-model:uploaded="data.image"/>
            </a-form-item>

            <a-form-item 
                label="Name"
                :required="true"
                has-feedback
                :validate-status="errors['name'] ? 'error' : ''"
                :help="errors.name">
                <a-input
                    placeholder="Enter name"
                    v-model:value="data.name"/>
            </a-form-item>

            <a-form-item 
                label="Description"
                :required="true"
                has-feedback
                :validate-status="errors['description'] ? 'error' : ''"
                :help="errors.description">
                <a-textarea
                    placeholder="Enter description"
                    v-model:value="data.description"/>
            </a-form-item>

            <a-form-item 
                label="Price"
                :required="true"
                has-feedback
                :validate-status="errors['price'] ? 'error' : ''"
                :help="errors.price">
                <a-input-number
                    style="width: 100%;"
                    placeholder="Enter price"
                    :min="0"
                    v-model:value="data.price"/>
            </a-form-item>

            <a-form-item
                label="Categories"
                :required="true"
                has-feedback
                :validate-status="errors['categories_ids'] ? 'error' : ''"
                :help="errors.categories_ids">
                <a-select
                    placeholder="Select categories"
                    mode="multiple"
                    :options="categoriesOptions"
                    v-model:value="data.categories_ids"/>
            </a-form-item>

            <a-button
                type="primary"   
                :loading="loading"
                @click="this[action]()">
                Save
            </a-button>

        </a-form>

    </a-modal>
</template>

<script>
import { message } from 'ant-design-vue'
import api from '../../../api/admin/products'
import Upload from '../../components/Upload.vue'

export default {
    components: {
        Upload,
    },
    props: [
        'title',
        'action',
        'open',
        'item',
        'categories',
    ],
    data() {
        return {
            data: {
                image: '',
                name: '',
                description: '',
                price: 0,
                categories_ids: [],
            },
            errors: {},
            loading: false,
        }
    },
    computed: {
        categoriesOptions() {
            return this.categories.map(category => {
                return {
                    value: category.id,
                    label: category.name,
                }
            })
        },  
    },
    watch: {
        item(item) {
            if (item) {
                this.setData()
            }
        },
    }, 
    methods: {
        async create() {
            try {
                this.loading = true
                this.errors = {}
                const data = await api.create(this.data)
                message.success('Successfully created.')
                this.$emit('create', data)
                this.$emit('update:open', false)
                this.resetForm()
            } catch (err) {
                if (err?.response?.status == 422) {
                    this.errors = err?.response?.data?.errors
                } else {
                    message.error(err?.response?.data?.message ?? err.message)
                }
            } finally {
                this.loading = false
            }
        },
        async edit() {
            try {
                this.loading = true
                this.errors = {}
                await api.edit(this.data.id, this.data)
                message.success('Successfully saved.')
                this.$emit('edit')
            } catch (err) {
                if (err?.response?.status == 422) {
                    this.errors = err?.response?.data?.errors
                } else {
                    message.error(err?.response?.data?.message ?? err.message)
                }
            } finally {
                this.loading = false
            }
        },
        resetForm() {
            this.data.image = ''
            this.data.name = ''
            this.data.description = ''
            this.data.price = 0
            this.data.categories_ids = []
        }, 
        setData() {
            this.data = {...this.item}
            this.data.categories_ids = this.data.categories.map(category => category.id)
        } 
    },
    mounted() {
        if (this.item) {
            this.setData()
        }
    },
}
</script>