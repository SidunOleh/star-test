export default {
    async upload(file) {
        const data = new FormData
        data.append('image', file)

        const res = await axios.post('/admin-api/images', data)

        return res.data
    }
}