<template>

    <a-modal 
        title="Sign up"
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

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

            <a-form-item
                label="Password confirmation"
                :required="true">
                <a-input-password
                    placeholder="Reenter password"
                    v-model:value="credentials.password_confirmation"/>
            </a-form-item>

            <a-button
                :loading="loading"
                @click="handleSignUp">
                Sign up
            </a-button>
            
        </a-form>

    </a-modal>

</template>

<script>
import { message } from 'ant-design-vue'
import { mapGetters, mapActions } from 'vuex'

export default {
    props: [
        'open',
    ],
    data() {
        return {
            credentials: {
                email: null,
                password: null,
            },
        }
    },
    computed: {
        ...mapGetters('shopAuth', ['loading', 'error', 'user',]),
    },
    methods: {
        ...mapActions('shopAuth', ['signUp']),
        async handleSignUp() {
            await this.signUp(this.credentials)


            if (this.user) {
                this.$emit('update:open', false)
                this.$emit('signUp')
            }

            if (this.error) {
                message.error(this.error)
            }
        },
    },
}
</script>