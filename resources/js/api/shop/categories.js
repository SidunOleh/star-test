export default {
    async all() {
        const res = await axios.get('/api/categories/all')

        return res.data
    },
}