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

        const res = await axios.get(`/admin-api/orders?${query}`)

        return res.data
    },
}
