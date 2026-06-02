<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import AdminLayout from '@/Layout/AdminLayout.vue'

const router = useRouter()
const authStore = useAuthStore()

const isLoggingOut = ref(false)

async function handleLogout() {
  isLoggingOut.value = true

  try {
    await authStore.logout()
    router.push({ name: 'admin-login' })
  } finally {
    isLoggingOut.value = false
  }
}
</script>

<template>
    <AdminLayout>
        <main class="flex min-h-screen items-center justify-center bg-slate-50 px-4">
            <section class="w-full max-w-md rounded-lg bg-white p-8">
                <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">Admin Dashboard</h1>
                    <p class="mt-1 text-sm text-slate-600">Welcome to the admin dashboard.</p>
                </div>
                </div>
            </section>
        </main>
    </AdminLayout>
</template>