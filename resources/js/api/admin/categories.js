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

        const res = await axios.get(`/admin-api/categories?${query}`)

        return res.data
    },
    async all() {
        const res = await axios.get('/admin-api/categories/all')

        return res.data
    },
    async create(data) {
        const res = await axios.post('/admin-api/categories', data)

        return res.data
    },
    async edit(id, data) {
        const res = await axios.post(`/admin-api/categories/${id}`, data)

        return res.data
    },
    async delete(id) {
        const res = await axios.delete(`/admin-api/categories/${id}`)

        return res.data
    },
}
