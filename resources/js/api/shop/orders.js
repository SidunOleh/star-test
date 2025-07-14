export default {
    async create(data) {
        const res = await axios.post('/api/orders', data)

        return res.data
    },
}