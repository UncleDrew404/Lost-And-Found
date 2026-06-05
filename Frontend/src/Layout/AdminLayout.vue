<script setup>
import { computed } from 'vue'
import { useRoute, RouterView } from 'vue-router'
import {
  LayoutDashboard,
  PackageSearch,
  ClipboardCheck,
  Users,
  Tags,
  ShieldCheck,
} from 'lucide-vue-next'
import Sidebar from '@/components/navigation/Sidebar.vue'
import NavHeader from '@/components/navigation/NavHeader.vue'
import adminLogo from '@/assets/img/uplogo2.png'

const route = useRoute()

const sidebarItems = [
  { name: 'Dashboard', routeName: 'admin-dashboard', icon: LayoutDashboard },
  { name: 'Item Management', routeName: 'admin-items', icon: PackageSearch }, 
  { name: 'Claim Management', routeName: 'admin-claims', icon: ClipboardCheck },
  { name: 'User Management', routeName: 'admin-users', icon: Users },
  { name: 'Category Management', routeName: 'admin-categories', icon: Tags },
  { name: 'Role & Permissions', routeName: 'admin-roles', icon: ShieldCheck },
]

const pageTitle = computed(() => route.meta.pageTitle || 'Dashboard')

</script>

<template>
  <div class="h-screen overflow-hidden bg-slate-50 md:flex">
    <Sidebar :items="sidebarItems" :logo-src="adminLogo" logo-alt="CEC logo" />

    <div class="flex h-screen min-w-0 flex-1 flex-col overflow-hidden">
      <NavHeader :title="pageTitle" login-route-name="admin-login" />

      <main class="flex-1 overflow-y-auto bg-slate-50 px-4 py-6">
        <RouterView />
      </main>
    </div>
  </div>
</template>