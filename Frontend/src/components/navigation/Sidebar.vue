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
})
</script>

<template>
  <aside class="hidden min-h-screen w-full max-w-xs border-r border-[slate-200] bg-[#07087A] text-white md:block">
    <div class="px-6 py-5 text-lg font-semibold">
      {{ title }}
    </div>

    <nav class="space-y-1 px-3">
      <RouterLink
        v-for="item in items"
        :key="item.name"
        :to="{ name: item.routeName }"
        class="block rounded-md px-3 py-2 text-sm text-slate-200 hover:bg-slate-800"
        active-class="bg-slate-800 text-white"
      >
        {{ item.name }}
      </RouterLink>
    </nav>
  </aside>
</template>