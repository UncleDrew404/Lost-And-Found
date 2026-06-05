<script setup>
defineProps({
  title: {
    type: String,
    required: true,
  },
  items: {
    type: Array,
    required: true,
  },
  logoAlt: {
    type: String,
    default: 'Admin logo',
  },
  logoSrc: {
    type: String,
    default: 'CEC logo',
  },
})
</script>

<template>
  <aside
    class="hidden h-screen w-full max-w-xs border-r border-[slate-200] bg-[#850038] text-white md:block"
  >
    <div class="flex justify-center px-6 py-8">
      <img :src="logoSrc" :alt="logoAlt" class="h-20 w-auto object-contain" />
    </div>

    <nav class="space-y-4 px-3">
      <RouterLink
        v-for="item in items"
        :key="item.name"
        :to="{ name: item.routeName }"
        class="flex gap-2 rounded-md px-4 py-4 text-md text-[#FFFFFF]"
        active-class="bg-slate-50 text-black"
      >
        <component :is="item.icon" class="h-5 w-5 shrink-0" />
        {{ item.name }}
      </RouterLink>
    </nav>
  </aside>
</template>