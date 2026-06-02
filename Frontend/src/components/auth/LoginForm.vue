<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const props = defineProps({
  role: {
    type: String,
    required: true,
  },
  submitLabel: {
    type: String,
    default: 'Sign in',
  },
  showForgotPassword: {
    type: Boolean,
    default: false,
  },
})

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const error = ref('')
const isLoading = ref(false)

async function submit() {
  error.value = ''
  isLoading.value = true

  try {
    await authStore.login(
      {
        email: email.value,
        password: password.value,
      },
      props.role
    )

    router.push(route.query.redirect || { name: `${props.role}-dashboard` })
  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Login failed.'
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <form class="w-full max-w-sm space-y-5" @submit.prevent="submit">
    <div
      v-if="error"
      class="rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700"
    >
      {{ error }}
    </div>

    <label class="block">
      <span class="text-sm font-medium text-slate-700">Email</span>
      <input
        v-model="email"
        type="email"
        placeholder="Email"
        required
        autocomplete="email"
        class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none focus:border-slate-700"
      />
    </label>

    <label class="block">
      <span class="text-sm font-medium text-slate-700">Password</span>
      <input
        v-model="password"
        type="password"
        placeholder="Password"
        required
        autocomplete="current-password"
        class="mt-1 mb-4 w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none focus:border-slate-700"
      />
    </label>

    <div v-if="showForgotPassword" class="flex justify-end">
      <RouterLink
        :to="{ name: 'forgot-password' }"
        class="text-sm font-medium text-slate-700 hover:text-slate-950"
      >
        Forgot password?
      </RouterLink>
    </div>

    <button
      type="submit"
      :disabled="isLoading"
      class="w-full rounded-md bg-slate-900 px-4 py-2 font-medium text-white disabled:cursor-not-allowed disabled:opacity-60"
    >
      {{ isLoading ? 'Signing in...' : props.submitLabel }}
    </button>
  </form>
</template>