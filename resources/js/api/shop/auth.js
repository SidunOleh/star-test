export default {
    async login(credentials) {
        await axios.get('/sanctum/csrf-cookie')

        const res = await axios.post('/login', credentials)

        return res.data
    },
    async signUp(credentials) {
        await axios.get('/sanctum/csrf-cookie')

        const res = await axios.post('/sign-up', credentials)

        return res.data
    },
    async logout() {
        const res = await axios.post('/logout')

        return res.data
    },
}