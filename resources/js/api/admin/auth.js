export default {
    async login(credentials) {
        await axios.get('/sanctum/csrf-cookie')

        const res = await axios.post('/admin/login', credentials)

        return res.data
    },
    async logout() {
        const res = await axios.post('/admin/logout')

        return res.data
    },
}