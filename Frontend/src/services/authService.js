import api from '@/lib/axios'

export const authService = {
    register(data) {
        return api.post('/auth/register', data)
    },

    login(credentials) {
        return api.post('/auth/login', credentials)
    },

    logout() {
        return api.post('/auth/logout')
    },

    getUser() {
        return api.get('/auth/user')
    },
}