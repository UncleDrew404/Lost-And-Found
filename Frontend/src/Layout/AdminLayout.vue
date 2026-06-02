<script setup>
import { RouterView } from 'vue-router'
import Sidebar from '@/components/navigation/Sidebar.vue'
import NavHeader from '@/components/navigation/NavHeader.vue'

const sidebarItems = [
  { name: 'Dashboard', routeName: 'admin-dashboard' },
]
</script>

<template>
  <div class="min-h-screen bg-slate-50 md:flex">
    <Sidebar title="Admin Panel" :items="sidebarItems" />

    <div class="min-w-0 flex-1">
      <NavHeader title="Dashboard" login-route-name="admin-login" />
    </div>
  </div>
</template>