<template>
    <a-modal 
        :title="title"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <a-form layout="vertical">

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
import api from '../../../api/admin/categories'

export default {
    props: [
        'title',
        'action',
        'open',
        'item',
    ],
    data() {
        return {
            data: this.item ? {...this.item} : {
                name: '',
            },
            errors: {},
            loading: false,
        }
    },
    watch: {
        item(item) {
            if (item) {
                this.data = {...this.item}
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
            this.data.name = ''
        },  
    },
}
</script>