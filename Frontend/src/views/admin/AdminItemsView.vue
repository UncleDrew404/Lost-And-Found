<script setup>
import { onMounted, ref } from 'vue'
import DataTable from '@/components/DataTable.vue'
import { itemService } from '@/services/itemService'

const items = ref([])
const isLoading = ref(false)
const errorMessage = ref('')

const columns = [
  { key: 'image_path', label: 'Image' },
  { key: 'title', label: 'Title' },
  //   { key: 'description', label: 'Description' },
  { key: 'type', label: 'Type' },
  { key: 'status', label: 'Status' },
  { key: 'category', label: 'Category' },
  { key: 'location', label: 'Location' },
  { key: 'date_occured', label: 'Date' },
  { key: 'user', label: 'Reporter' },
  { key: '', label: 'Action' },
]

async function fetchItems() {
  isLoading.value = true
  errorMessage.value = ''

  try {
    const response = await itemService.getItems()
    items.value = response.data.data.data || []
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Failed to load items.'
  } finally {
    isLoading.value = false
  }
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
        {{ row.user?.profile?.first_name || 'Unknown reporter' }}
      </template>

      <template #date_occured="{ value }">
        {{ new Date(value).toLocaleDateString() }}
      </template>
    </DataTable>
  </section>
</template>