import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'student-landing-page',
      component: () => import('@/views/StudentLandingPage.vue'),
    },

    // LOGINS
    {
      path: '/admin/login',
      name: 'admin-login',
      component: () => import('@/views/auth/AdminLoginView.vue'),
      meta: { guest: true, role: 'admin', title: 'Admin | Login' },
    },
    {
      path: '/staff/login',
      name: 'staff-login',
      component: () => import('@/views/auth/StaffLoginView.vue'),
      meta: { guest: true, role: 'staff', title: 'Staff |Login' },
    },
    {
      path: '/login',
      name: 'student-login',
      component: () => import('@/views/auth/StudentLoginView.vue'),
      meta: { guest: true, role: 'student', title: 'Student | Login' },
    },

    // ADMIN DASHBOARD & MANAGEMENT
    {
      path: '/admin',
      component: () => import('@/Layout/AdminLayout.vue'),
      meta: { requiresAuth: true, role: 'admin' },
      children: [
        {
          path: 'dashboard',
          name: 'admin-dashboard',
          component: () => import('@/views/admin/AdminDashboardView.vue'),
          meta: { title: 'Admin | Dashboard', pageTitle: 'Admin Dashboard' },
        },
        {
          path: 'items',
          name: 'admin-items',
          component: () => import('@/views/admin/AdminItemsView.vue'),
          meta: { title: 'Admin | Items', pageTitle: 'Item Management' },
        },
        {
          path: 'claims',
          name: 'admin-claims',
          component: () => import('@/views/admin/AdminClaimsView.vue'),
          meta: { title: 'Admin | Claims', pageTitle: 'Claims' },
        },
        {
          path: 'users',
          name: 'admin-users',
          component: () => import('@/views/admin/AdminUsersView.vue'),
          meta: { title: 'Admin | Users', pageTitle: 'Users' },
        },
        {
          path: 'categories',
          name: 'admin-categories',
          component: () => import('@/views/admin/AdminCategoriesView.vue'),
          meta: { title: 'Admin | Categories', pageTitle: 'Categories' },
        },
        {
          path: 'roles-permissions',
          name: 'admin-roles',
          component: () => import('@/views/admin/AdminRolesAndPermissionsView.vue'),
          meta: { title: 'Admin | Roles & Permissions', pageTitle: 'Roles & Permissions' },
        },
      ],
    },

    {
      path: '/staff/dashboard',
      name: 'staff-dashboard',
      component: () => import('@/views/staff/StaffDashboardView.vue'),
      meta: { requiresAuth: true, role: 'staff', title: 'Staff | Dashboard', },
    },
    {
      path: '/student/dashboard',
      name: 'student-dashboard',
      component: () => import('@/views/student/StudentDashboardView.vue'),
      meta: { requiresAuth: true, role: 'student', title: 'Student | Dashboard', },
    },

  ],
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next ({ name: `${to.meta.role}-login`, query: { redirect: to.fullPath } })
  }

  if (to.meta.role && authStore.isAuthenticated && !authStore.hasRole(to.meta.role)) {
    next ({ name: `${authStore.primaryRole}-dashboard` })
  }

  if (to.meta.guest && authStore.isAuthenticated) {
    next ({ name: `${authStore.primaryRole}-dashboard` })
  }

  next()
})

router.afterEach((to) => {
  const authStore = useAuthStore()

  const role = authStore.user?.role

  if (role && to.meta.title) {
    document.title =
      `${role.charAt(0).toUpperCase() + role.slice(1)} | ${to.meta.title}`
  } else {
    document.title = to.meta.title || 'Lost & Found System'
  }
})

export default router
