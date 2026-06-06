<script setup>
import { onMounted, ref } from 'vue'
import { itemService } from '@/services/itemService'

import DataTable from '@/components/DataTable.vue'
import Pagination from '@/components/Pagination.vue'

const items = ref([])
const isLoading = ref(false)
const errorMessage = ref('')

const currentPage = ref(1)
const perPage = ref(10)

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
})

const columns = [
  { key: 'image_path', label: 'Images' },
  { key: 'title', label: 'Title' },
  { key: 'category', label: 'Category' },
  { key: 'location', label: 'Location' },
  { key: 'date_occured', label: 'Date' },
  { key: 'type', label: 'Type' },
  { key: 'status', label: 'Status' },
  { key: 'user', label: 'Reporter' },
  { key: '', label: 'Action' },
]

async function fetchItems(page = currentPage.value, limit = perPage.value) {
  isLoading.value = true
  errorMessage.value = ''

  try {
    currentPage.value = page
    perPage.value = limit

    const response = await itemService.getItems({
      page: currentPage.value,
      per_page: perPage.value,
    })

    items.value = response.data.data.data || []

    pagination.value = response.data.data.meta || {
      current_page: currentPage.value,
      last_page: 1,
      per_page: perPage.value,
      total: 0,
    }
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Failed to load items.'
  } finally {
    isLoading.value = false
  }
}

function handlePageChange({ page, perPage }) {
  fetchItems(page, perPage)
}

onMounted(fetchItems)
</script>

<template>
  <section>
    <!-- <pre class="text-sm text-slate-600">{{ items }}</pre> -->
    <p v-if="errorMessage" class="mb-4 text-sm text-red-600">
      {{ errorMessage }}
    </p>

    <DataTable
      :columns="columns"
      :rows="items"
      :is-loading="isLoading"
      empty-text="No items found."
    >
      <template #type="{ value }">
        <span class="capitalize">{{ value }}</span>
      </template>

      <template #status="{ value }">
        <span class="capitalize">{{ value }}</span>
      </template>

      <template #category="{ row }">
        {{ row.category?.name || 'Uncategorized' }}
      </template>

      <template #user="{ row }">
        {{ row.user?.profile?.full_name || 'Unknown reporter' }}
      </template>

      <template #date_occured="{ value }">
        {{ new Date(value).toLocaleDateString() }}
      </template>
    </DataTable>

    <Pagination
      :current-page="pagination.current_page"
      :per-page="pagination.per_page"
      :total-records="pagination.total"
      :disabled="isLoading"
      @page-change="handlePageChange"
    />
  </section>
</template>