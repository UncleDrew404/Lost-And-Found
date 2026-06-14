<script setup>
import { computed } from 'vue'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
  currentPage: {
    type: Number,
    default: 1,
  },
  perPage: {
    type: Number,
    default: 10,
  },
  totalRecords: {
    type: Number,
    default: 0,
  },
  rowsPerPageOptions: {
    type: Array,
    default: () => [10, 20, 50],
  },
  disabled: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['page-change'])

const lastPage = computed(() => {
  return Math.max(Math.ceil(props.totalRecords / props.perPage), 1)
})

const firstRecord = computed(() => {
  if (props.totalRecords === 0) {
    return 0
  }

  return (props.currentPage - 1) * props.perPage + 1
})

const lastRecord = computed(() => {
  return Math.min(props.currentPage * props.perPage, props.totalRecords)
})

const visiblePages = computed(() => {
  const pages = []
  const start = Math.max(props.currentPage - 2, 1)
  const end = Math.min(start + 4, lastPage.value)

  for (let page = start; page <= end; page++) {
    pages.push(page)
  }

  return pages
})

function goToPage(page) {
  if (props.disabled || page < 1 || page > lastPage.value || page === props.currentPage) {
    return
  }

  emit('page-change', {
    page,
    perPage: props.perPage,
  })
}

function changePerPage(event) {
  emit('page-change', {
    page: 1,
    perPage: Number(event.target.value),
  })
}
</script>

<template>
  <div
    class="mt-4 flex flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between"
  >
    <p class="text-sm text-slate-600">
      <span v-if="totalRecords > 0">
        Showing
        <span class="font-semibold text-slate-900">{{ firstRecord }}</span>
        -
        <span class="font-semibold text-slate-900">{{ lastRecord }}</span>
        of
        <span class="font-semibold text-slate-900">{{ totalRecords }}</span>
      </span>

      <span v-else>No records found</span>
    </p>

    <div class="flex flex-wrap items-center gap-2">
      <select
        class="h-9 rounded-md border border-slate-300 bg-white px-2 text-sm text-slate-700 outline-none focus:border-[#850038] focus:ring-2 focus:ring-[#850038]/20"
        :value="perPage"
        :disabled="disabled"
        @change="changePerPage"
      >
        <option
          v-for="option in rowsPerPageOptions"
          :key="option"
          :value="option"
        >
          {{ option }} per page
        </option>
      </select>

      <button
        type="button"
        class="h-9 rounded-md border border-slate-300 px-2 text-sm text-slate-700 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50"
        :disabled="disabled || currentPage <= 1"
        @click="goToPage(currentPage - 1)"
      >
        <ChevronLeft class="h-6 w-6" />
      </button>

      <button
        v-for="page in visiblePages"
        :key="page"
        type="button"
        class="h-9 min-w-9 rounded-md cursor-pointer px-3 text-sm font-medium"
        :class="
          page === currentPage
            ? 'border-[#00281B] bg-[#850038] text-white'
            : ' text-slate-700 hover:bg-slate-100'
        "
        :disabled="disabled"
        @click="goToPage(page)"
      >
        {{ page }}
      </button>

      <button
        type="button"
        class="h-9 rounded-md border border-slate-300 px-2 text-sm text-slate-700 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50"
        :disabled="disabled || currentPage >= lastPage"
        @click="goToPage(currentPage + 1)"
      >
        <ChevronRight class="h-6 w-6" />
      </button>
    </div>
  </div>
</template>