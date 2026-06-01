import api from '@/lib/axios'

export const authService = {
    register(data) {
        return api.post('/register', data)
    },

    login(credentials) {
        return api.post('/login', credentials)
    },

    logout() {
        return api.post('/logout')
    },

    getUser() {
        return api.get('/user')
    },
}