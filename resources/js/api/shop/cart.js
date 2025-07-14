export default {
    async getCartItems() {
        const res = await axios.get('/api/cart')

        return res.data
    },
    async addProduct(productId) {
        const res = await axios.post('/api/cart/add-product', { product_id: productId })

        return res.data
    },
    async changeQuantity(cartItemId, quantity) {
        const res = await axios.post(`/api/cart/${cartItemId}/change-quantity`, { quantity })

        return res.data
    },
    async deleteCartItem(cartItemId) {
        const res = await axios.delete(`/api/cart/${cartItemId}`)

        return res.data
    },
}