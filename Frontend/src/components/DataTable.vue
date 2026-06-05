<script setup>
defineProps({
  columns: {
    type: Array,
    required: true,
  },
  rows: {
    type: Array,
    required: true,
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
  emptyText: {
    type: String,
    default: 'No records found.',
  },
})
</script>

<template>
  <div class="overflow-hidden rounded-md border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
      <thead class="bg-[#00281B] text-white">
        <tr>
          <th
            v-for="column in columns"
            :key="column.key"
            class="px-4 py-3"
          >
            {{ column.label }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-if="isLoading">
          <td
            :colspan="columns.length"
            class="px-4 py-6 text-center text-slate-600"
          >
            Loading...
          </td>
        </tr>

        <tr v-else-if="rows.length === 0">
          <td
            :colspan="columns.length"
            class="px-4 py-6 text-center text-slate-600"
          >
            {{ emptyText }}
          </td>
        </tr>

        <tr
          v-for="row in rows"
          v-else
          :key="row.id"
          class="border-t border-slate-200"
        >
          <td
            v-for="column in columns"
            :key="column.key"
            class="px-4 py-3 text-slate-600"
          >
            <slot
              :name="column.key"
              :row="row"
              :value="row[column.key]"
            >
              {{ row[column.key] || 'N/A' }}
            </slot>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>