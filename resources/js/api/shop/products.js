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

        const res = await axios.get(`/api/products?${query}`)

        return res.data
    },
    async show(id) {
        const res = await axios.get(`/api/products/${id}`)

        return res.data
    },
    async getPriceRange() {
        const res = await axios.get('/api/products/price-range')

        return res.data
    },
}
