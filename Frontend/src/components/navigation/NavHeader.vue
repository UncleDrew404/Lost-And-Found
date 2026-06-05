<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  loginRouteName: {
    type: String,
    required: true,
  },
})

const router = useRouter()
const authStore = useAuthStore()
const isLoggingOut = ref(false)

async function handleLogout() {
  isLoggingOut.value = true

  try {
    await authStore.logout()
  } finally {
    isLoggingOut.value = false
    router.push({ name: props.loginRouteName })
  }
}
</script>

<template>
  <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6">
    <h1 class="text-lg font-bold text-[#000000]">{{ title }}</h1>

    <button
      type="button"
      :disabled="isLoggingOut"
      class="rounded-md bg-slate-900 px-3 py-2 cursor-pointer text-sm font-medium text-white disabled:opacity-60"
      @click="handleLogout"
    >
      {{ isLoggingOut ? 'Logging out...' : 'Logout' }}
    </button>
  </header>
</template>