import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { authService } from '@/services/authService'

export const useAuthStore = defineStore('auth', () => {

    const user = ref(JSON.parse(localStorage.getItem('user') || 'null'))
    const token = ref(localStorage.getItem('token') || null)

    const isAuthenticated = computed(() => !!token.value)

    const roles = computed(() => user.value?.roles || [])

    const primaryRole = computed(() => roles.value[0] || null)

    const isAdmin = computed(() => roles.value.includes('admin'))
    const isStaff = computed(() => roles.value.includes('staff'))
    const isStudent = computed(() => roles.value.includes('student'))

    function hasRole(role) {
        return roles.value.includes(role)
    }

    function setAuth(userData, tokenValue) {
        user.value = userData
        token.value = tokenValue
        localStorage.setItem('user', JSON.stringify(userData))
        localStorage.setItem('token', tokenValue)
    }

    function clearAuth() {
        user.value = null
        token.value = null
        localStorage.removeItem('user')
        localStorage.removeItem('token')
    }

    async function login(credentials, expectedRole = null) {
        const response = await authService.login(credentials)
        const userData = response.data.data.user
        const tokenValue = response.data.data.token

        const userRoles = userData.roles || []

        if (expectedRole && !userRoles.includes(expectedRole)) {
            clearAuth()

            throw new Error(`Please use the ${userRoles[0] || 'correct'} login page.`)
        }

        setAuth(userData, tokenValue)

        return response.data
    }

    async function register(data) {
        const response = await authService.register(data)
        setAuth(response.data.data.user, response.data.data.token)
        return response.data
    }

    async function logout() {
        try {
            await authService.logout()
        } finally {
            clearAuth()
        }
    }

    async function fetchUser() {
        const response = await authService.getUser()
        user.value = response.data.data
        localStorage.setItem('user', JSON.stringify(response.data.data))
        return response.data
    }

    return {
        user,
        token,
        isAuthenticated,
        setAuth,
        clearAuth,
        login,
        register,
        logout,
        fetchUser,
    }
})