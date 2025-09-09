<template>
  <Head title="Koleksi Buku" />
  
  <PublicLayout>
    <!-- Header Section -->
    <section class="bg-dark-900 text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Koleksi Buku Cerita</h1>
        <p class="text-gray-300 text-lg">
          Jelajahi {{ books.total }} cerita menarik untuk anak-anak
        </p>
      </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Search and Filters -->
      <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <!-- Search -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Buku</label>
            <input v-model="searchForm.search"
                   @input="search"
                   type="text" 
                   placeholder="Cari judul, pengarang, atau sinopsis..."
                   class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
          </div>
          
          <!-- Category Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select v-model="searchForm.category" 
                    @change="search"
                    class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
              <option value="">Semua Kategori</option>
              <option v-for="category in categories" 
                      :key="category.id" 
                      :value="category.slug">
                {{ category.name }} ({{ category.books_count }})
              </option>
            </select>
          </div>
          
          <!-- Age Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Usia Anak</label>
            <select v-model="searchForm.age" 
                    @change="search"
                    class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
              <option value="">Semua Usia</option>
              <option value="3">3 tahun</option>
              <option value="4">4 tahun</option>
              <option value="5">5 tahun</option>
              <option value="6">6 tahun</option>
              <option value="7">7 tahun</option>
              <option value="8">8 tahun</option>
              <option value="9">9+ tahun</option>
            </select>
          </div>
        </div>
        
        <!-- Active Filters -->
        <div v-if="hasActiveFilters" class="mt-4 flex flex-wrap gap-2">
          <span class="text-sm text-gray-600">Filter aktif:</span>
          <span v-if="filters.search" 
                class="inline-flex items-center px-2 py-1 bg-primary-100 text-primary-700 text-xs font-medium rounded">
            "{{ filters.search }}"
            <button @click="clearFilter('search')" class="ml-1 text-primary-500 hover:text-primary-700">×</button>
          </span>
          <span v-if="filters.category" 
                class="inline-flex items-center px-2 py-1 bg-primary-100 text-primary-700 text-xs font-medium rounded">
            {{ getCategoryName(filters.category) }}
            <button @click="clearFilter('category')" class="ml-1 text-primary-500 hover:text-primary-700">×</button>
          </span>
          <span v-if="filters.age" 
                class="inline-flex items-center px-2 py-1 bg-primary-100 text-primary-700 text-xs font-medium rounded">
            Usia {{ filters.age }} tahun
            <button @click="clearFilter('age')" class="ml-1 text-primary-500 hover:text-primary-700">×</button>
          </span>
          <button @click="clearAllFilters" 
                  class="text-xs text-gray-500 hover:text-gray-700 underline">
            Hapus semua filter
          </button>
        </div>
      </div>

      <!-- Books Grid -->
      <div v-if="books.data.length > 0">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
          <div v-for="book in books.data" :key="book.id" 
               class="card hover:shadow-lg transition-shadow duration-300">
            <div class="aspect-w-3 aspect-h-4">
              <img :src="book.cover || '/images/default-book-cover.jpg'" 
                   :alt="book.judul"
                   class="w-full h-48 object-cover">
            </div>
            <div class="p-4">
              <div class="flex items-center text-sm text-gray-500 mb-2">
                <span class="bg-primary-100 text-primary-700 px-2 py-1 rounded text-xs font-medium">
                  {{ book.category.name }}
                </span>
                <span class="mx-2">•</span>
                <span>{{ book.views }} views</span>
              </div>
              <h3 class="text-lg font-semibold text-dark-900 mb-2 line-clamp-2">
                {{ book.judul }}
              </h3>
              <p class="text-gray-600 text-sm mb-2">oleh {{ book.pengarang }}</p>
              <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                {{ book.sinopsis }}
              </p>
              <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500">
                  Usia {{ book.age_min }}-{{ book.age_max }} tahun
                </span>
                <Link :href="route('books.show', book.id)" 
                      class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                  Baca →
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="books.last_page > 1" class="flex justify-center">
          <nav class="flex items-center space-x-1">
            <Link v-if="books.prev_page_url" 
                  :href="books.prev_page_url"
                  class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md">
              ← Sebelumnya
            </Link>
            
            <template v-for="page in paginationPages" :key="page">
              <Link v-if="page !== '...'" 
                    :href="getPageUrl(page)"
                    :class="{
                      'bg-primary-500 text-white': page === books.current_page,
                      'text-gray-500 hover:text-gray-700 hover:bg-gray-100': page !== books.current_page
                    }"
                    class="px-3 py-2 text-sm font-medium rounded-md">
                {{ page }}
              </Link>
              <span v-else class="px-3 py-2 text-sm text-gray-400">...</span>
            </template>
            
            <Link v-if="books.next_page_url" 
                  :href="books.next_page_url"
                  class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md">
              Selanjutnya →
            </Link>
          </nav>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-12">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <span class="text-4xl text-gray-400">📚</span>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada buku yang ditemukan</h3>
        <p class="text-gray-600 mb-4">
          Coba ubah filter pencarian atau kata kunci Anda
        </p>
        <button @click="clearAllFilters" class="btn-primary">
          Hapus Semua Filter
        </button>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { computed, reactive, watch } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import { debounce } from 'lodash'

const props = defineProps({
  books: Object,
  categories: Array,
  filters: Object,
})

const searchForm = reactive({
  search: props.filters.search || '',
  category: props.filters.category || '',
  age: props.filters.age || '',
})

const hasActiveFilters = computed(() => {
  return props.filters.search || props.filters.category || props.filters.age
})

const paginationPages = computed(() => {
  const pages = []
  const current = props.books.current_page
  const last = props.books.last_page
  
  if (last <= 7) {
    for (let i = 1; i <= last; i++) {
      pages.push(i)
    }
  } else {
    if (current <= 4) {
      for (let i = 1; i <= 5; i++) pages.push(i)
      pages.push('...')
      pages.push(last)
    } else if (current >= last - 3) {
      pages.push(1)
      pages.push('...')
      for (let i = last - 4; i <= last; i++) pages.push(i)
    } else {
      pages.push(1)
      pages.push('...')
      for (let i = current - 1; i <= current + 1; i++) pages.push(i)
      pages.push('...')
      pages.push(last)
    }
  }
  
  return pages
})

const search = debounce(() => {
  router.get(route('books.index'), searchForm, {
    preserveState: true,
    replace: true,
  })
}, 300)

const clearFilter = (filterName) => {
  searchForm[filterName] = ''
  search()
}

const clearAllFilters = () => {
  searchForm.search = ''
  searchForm.category = ''
  searchForm.age = ''
  search()
}

const getCategoryName = (slug) => {
  const category = props.categories.find(cat => cat.slug === slug)
  return category ? category.name : slug
}

const getPageUrl = (page) => {
  const url = new URL(props.books.path)
  const params = new URLSearchParams({
    page: page,
    ...props.filters
  })
  return `${url.pathname}?${params.toString()}`
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.aspect-w-3 {
  position: relative;
  padding-bottom: calc(4 / 3 * 100%);
}

.aspect-h-4 img {
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}
</style>
