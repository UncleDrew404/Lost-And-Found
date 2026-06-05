import api from '@/lib/axios'

export const itemService = {
    getItems(params) {
        return api.get('/items', { params })
    },
}