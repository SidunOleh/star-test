<template>

    <a-modal 
        :open="true"
        :mask="false"
        :closable="false"
        :footer="null">

        <a-form layout="vertical">

            <a-form-item
                label="E-mail"
                :required="true">
                <a-input
                    placeholder="Enter e-mail"
                    v-model:value="credentials.email"/>
            </a-form-item>

            <a-form-item
                label="Password"
                :required="true">
                <a-input-password
                    placeholder="Enter password"
                    v-model:value="credentials.password"/>
            </a-form-item>

            <a-button
                :loading="loading"
                @click="handleLogin">
                Log in
            </a-button>
            
        </a-form>

    </a-modal>

</template>

<script>
import { message } from 'ant-design-vue'
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            credentials: {
                email: null,
                password: null,
            },
        }
    },
    computed: {
        ...mapGetters('adminAuth', ['loading', 'error', 'admin',]),
    },
    methods: {
        ...mapActions('adminAuth', ['login']),
        async handleLogin() {
            await this.login(this.credentials)
            
            if (this.admin) {
                this.$router.push({name: 'products'})
            }
        },
    },
    watch: {
        error(error) {
            if (error) {
                message.error(error)
            }
        },
    },
}
</script>