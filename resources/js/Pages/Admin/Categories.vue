<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Kelola Kategori</h1>
        <p class="text-gray-600">Tambah, edit, atau hapus kategori buku</p>
      </div>

      <!-- Add Category Form -->
      <div class="admin-card mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Kategori Baru</h3>
        <form @submit.prevent="submitCategory" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="category-name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Kategori *
              </label>
              <input
                v-model="categoryForm.name"
                type="text"
                id="category-name"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                placeholder="Masukkan nama kategori"
              />
            </div>
            <div>
              <label for="category-description" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi
              </label>
              <input
                v-model="categoryForm.description"
                type="text"
                id="category-description"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                placeholder="Deskripsi kategori (opsional)"
              />
            </div>
          </div>
          <div class="flex justify-end">
            <button
              type="button"
              @click="resetForm"
              class="mr-3 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200"
            >
              Reset
            </button>
            <button
              type="submit"
              :disabled="processing"
              class="px-6 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-medium rounded-lg shadow-md hover:from-purple-600 hover:to-purple-700 hover:shadow-lg transition-all duration-200 disabled:opacity-50"
            >
              <span v-if="processing">Menyimpan...</span>
              <span v-else-if="editingCategory">Update Kategori</span>
              <span v-else>Tambah Kategori</span>
            </button>
          </div>
        </form>
      </div>

      <!-- Categories List -->
      <div class="admin-card">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-900">Daftar Kategori</h3>
          <div class="text-sm text-gray-600">
            Total: {{ categories.total }} kategori
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Kategori
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Deskripsi
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Jumlah Buku
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="category in categories.data" :key="category.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ category.name }}</div>
                      <div class="text-sm text-gray-500">{{ category.slug }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900 max-w-xs truncate">
                    {{ category.description || '-' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ category.books_count }} buku
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end space-x-2">
                    <button
                      @click="editCategory(category)"
                      class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200"
                    >
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                      </svg>
                      Edit
                    </button>
                    <button
                      @click="deleteCategory(category)"
                      :disabled="category.books_count > 0"
                      :class="category.books_count > 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600'"
                      class="inline-flex items-center px-3 py-1 text-white text-xs font-medium rounded transition-colors duration-200"
                      :title="category.books_count > 0 ? 'Tidak dapat menghapus kategori yang masih memiliki buku' : 'Hapus kategori'"
                    >
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                      </svg>
                      Hapus
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="categories.data.length > 0" class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-4">
          <div class="flex flex-1 justify-between sm:hidden">
            <Link
              v-if="categories.prev_page_url"
              :href="categories.prev_page_url"
              class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Previous
            </Link>
            <Link
              v-if="categories.next_page_url"
              :href="categories.next_page_url"
              class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Next
            </Link>
          </div>
          <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ categories.from }}</span> to <span class="font-medium">{{ categories.to }}</span> of
                <span class="font-medium">{{ categories.total }}</span> results
              </p>
            </div>
            <div>
              <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                <Link
                  v-if="categories.prev_page_url"
                  :href="categories.prev_page_url"
                  class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                >
                  <span class="sr-only">Previous</span>
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                  </svg>
                </Link>

                <span
                  v-for="page in categories.links.slice(1, -1)"
                  :key="page.label"
                >
                  <Link
                    v-if="page.url"
                    :href="page.url"
                    :class="page.active ? 'relative z-10 inline-flex items-center bg-purple-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600' : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0'"
                  >
                    {{ page.label }}
                  </Link>
                  <span
                    v-else
                    class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0"
                  >
                    {{ page.label }}
                  </span>
                </span>

                <Link
                  v-if="categories.next_page_url"
                  :href="categories.next_page_url"
                  class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                >
                  <span class="sr-only">Next</span>
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                  </svg>
                </Link>
              </nav>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kategori</h3>
          <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan kategori pertama.</p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  categories: Object
})

const processing = ref(false)
const editingCategory = ref(null)

const categoryForm = reactive({
  name: '',
  description: ''
})

const submitCategory = () => {
  processing.value = true
  
  if (editingCategory.value) {
    // Update existing category
    router.put(route('admin.categories.update', editingCategory.value.id), categoryForm, {
      onSuccess: () => {
        resetForm()
      },
      onFinish: () => {
        processing.value = false
      }
    })
  } else {
    // Create new category
    router.post(route('admin.categories.store'), categoryForm, {
      onSuccess: () => {
        resetForm()
      },
      onFinish: () => {
        processing.value = false
      }
    })
  }
}

const editCategory = (category) => {
  editingCategory.value = category
  categoryForm.name = category.name
  categoryForm.description = category.description || ''
  
  // Scroll to form
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

const deleteCategory = (category) => {
  if (category.books_count > 0) {
    alert('Tidak dapat menghapus kategori yang masih memiliki buku!')
    return
  }

  if (confirm(`Apakah Anda yakin ingin menghapus kategori "${category.name}"?`)) {
    router.delete(route('admin.categories.destroy', category.id), {
      onSuccess: () => {
        // Success handled by flash message
      }
    })
  }
}

const resetForm = () => {
  categoryForm.name = ''
  categoryForm.description = ''
  editingCategory.value = null
}
</script>
