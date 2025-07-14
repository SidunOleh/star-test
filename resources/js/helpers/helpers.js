import { Modal } from 'ant-design-vue'

function confirmPopup(callback, title) {
    Modal.confirm({
        title: title,
        okText: 'Yes',
        cancelText: 'No',
        onOk: callback,
    })
}

function formatPrice(price) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(price)
}

function formatDate(date, withTime = true) {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }

    if (withTime) {
        options.hour = '2-digit'
        options.minute = '2-digit'
    }

    return new Date(date).toLocaleString('en-US', options)
}

export {
    confirmPopup,
    formatPrice,
    formatDate,
}