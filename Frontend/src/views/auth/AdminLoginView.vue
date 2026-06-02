<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import LoginForm from '@/components/auth/LoginForm.vue'

const route = useRoute()

const role = computed(() => route.meta.role)

// const titles = {
//   admin: 'Admin Login',
//   staff: 'Staff Login',
//   student: 'Student Login',
// }

// const title = computed(() => titles[role.value] || 'Login')
</script>

<template>
  <main class="flex min-h-screen items-center justify-end bg-[#F7F7F7] px-8">
    <section class="w-full max-w-md rounded-lg bg-white p-8">
      <h1 class="text-2xl font-semibold text-slate-900">Admin Login</h1>
      <p class="mt-1 text-sm text-slate-600">Access the system management dashboard.</p>

      <div class="mt-6">
        <LoginForm role="admin" submit-label="Enter Admin Portal" />
      </div>
    </section>
  </main>
</template>