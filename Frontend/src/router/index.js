import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // {
    //   path: '/',
    //   name: 'home',
    //   component: HomeView,
    // },

  ],
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: `${to.meta.role}-login`, query: { redirect: to.fullPath } })
    return
  }

  if (to.meta.role && authStore.isAuthenticated && !authStore.hasRole(to.meta.role)) {
    next({ name: `${authStore.primaryRole}-dashboard` })
    return
  }

  if (to.meta.guest && authStore.isAuthenticated) {
    next({ name: `${authStore.primaryRole}-dashboard` })
    return
  }

  next()
})

export default router
