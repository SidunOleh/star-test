export default {
    async fetch({ 
        page = 1,
        perPage = 15,
        orderBy = 'created_at',
        order = 'DESC',
        filters = {}
    }) {
        const query = new URLSearchParams({
            page,
            per_page: perPage,
            order_by: orderBy,
            order,
        })

        for (const field in filters) {
            filters[field]?.forEach(val => query.append(`${field}[]`, val))
        }

        const res = await axios.get(`/admin-api/products?${query}`)

        return res.data
    },
    async create(data) {
        const res = await axios.post('/admin-api/products', data)

        return res.data
    },
    async edit(id, data) {
        const res = await axios.post(`/admin-api/products/${id}`, data)

        return res.data
    },
    async delete(id) {
        const res = await axios.delete(`/admin-api/products/${id}`)

        return res.data
    },
}
