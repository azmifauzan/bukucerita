<template>
  <Head :title="book.judul" />
  
  <PublicLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Breadcrumb -->
      <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <Link :href="route('home')" class="text-gray-500 hover:text-gray-700">
              Beranda
            </Link>
          </li>
          <li>
            <div class="flex items-center">
              <span class="text-gray-400 mx-1">/</span>
              <Link :href="route('books.index')" class="text-gray-500 hover:text-gray-700">
                Koleksi Buku
              </Link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <span class="text-gray-400 mx-1">/</span>
              <span class="text-gray-700 font-medium">{{ book.judul }}</span>
            </div>
          </li>
        </ol>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Book Cover and Info -->
        <div class="lg:col-span-1">
          <div class="card sticky top-8">
            <!-- Cover Image -->
            <div class="aspect-w-3 aspect-h-4 mb-6">
              <img :src="book.cover || '/images/default-book-cover.jpg'" 
                   :alt="book.judul"
                   class="w-full h-80 object-cover rounded-lg">
            </div>
            
            <!-- Book Info -->
            <div class="p-6">
              <div class="mb-4">
                <span class="bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-medium">
                  {{ book.category.name }}
                </span>
              </div>
              
              <h1 class="text-2xl font-bold text-dark-900 mb-2">{{ book.judul }}</h1>
              <p class="text-gray-600 mb-4">oleh {{ book.pengarang }}</p>
              
              <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-6">
                <div>
                  <span class="block font-medium text-gray-900">Usia</span>
                  {{ book.age_min }}-{{ book.age_max }} tahun
                </div>
                <div>
                  <span class="block font-medium text-gray-900">Dibaca</span>
                  {{ book.views }} kali
                </div>
              </div>
              
              <div class="space-y-3">
                <button 
                   @click="scrollToStory"
                   class="w-full btn-primary text-center block">
                  📖 Baca Cerita Interaktif
                </button>
                
                <Link v-if="canEdit" 
                      :href="route('books.edit', book.id)" 
                      class="w-full btn-outline text-center block">
                  ✏️ Edit Buku
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Book Content -->
        <div class="lg:col-span-2">
          <!-- Synopsis -->
          <div class="card mb-8">
            <div class="p-6">
              <h2 class="text-xl font-bold text-dark-900 mb-4">Sinopsis</h2>
              <p class="text-gray-700 leading-relaxed">{{ book.sinopsis }}</p>
            </div>
          </div>

          <!-- Gemini Story Embed -->
          <div id="gemini-story-embed" class="card mb-8">
            <div class="p-6">
              <h2 class="text-xl font-bold text-dark-900 mb-4">Cerita Interaktif</h2>
              <p class="text-gray-600 mb-4">
                Baca cerita lengkap langsung di sini dengan pengalaman membaca yang interaktif dari Google Gemini Story Book.
              </p>
              
              <div class="bg-gray-50 rounded-lg overflow-hidden">
                <div class="bg-primary-50 px-4 py-3 border-b border-gray-200">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                      <span class="text-lg">📚</span>
                      <div>
                        <h3 class="font-medium text-gray-900">{{ book.judul }}</h3>
                        <p class="text-sm text-gray-600">oleh {{ book.pengarang }}</p>
                      </div>
                    </div>
                    <a :href="book.link" 
                       target="_blank"
                       class="text-sm text-primary-600 hover:text-primary-700 flex items-center">
                      <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                      </svg>
                      Buka di Tab Baru
                    </a>
                  </div>
                </div>
                
                <div class="relative">
                  <iframe 
                    :src="book.link"
                    class="w-full h-[600px] border-0"
                    title="Gemini Story Book"
                    loading="lazy"
                    sandbox="allow-scripts allow-same-origin allow-popups allow-forms"
                  ></iframe>
                </div>
              </div>
            </div>
          </div>

          <!-- Author Info -->
          <div class="card mb-8">
            <div class="p-6">
              <h2 class="text-xl font-bold text-dark-900 mb-4">Tentang Penulis</h2>
              <div class="flex items-center">
                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mr-4">
                  <span class="text-lg font-medium text-primary-600">
                    {{ book.user.name.charAt(0).toUpperCase() }}
                  </span>
                </div>
                <div>
                  <h3 class="font-medium text-gray-900">{{ book.user.name }}</h3>
                  <p class="text-sm text-gray-600">Kontributor Buku Cerita</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Related Books -->
          <div v-if="relatedBooks.length > 0" class="card">
            <div class="p-6">
              <h2 class="text-xl font-bold text-dark-900 mb-6">Buku Serupa</h2>
              <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div v-for="relatedBook in relatedBooks" :key="relatedBook.id" 
                     class="group">
                  <Link :href="route('books.show', relatedBook.id)">
                    <div class="aspect-w-3 aspect-h-4 mb-2">
                      <img :src="relatedBook.cover || '/images/default-book-cover.jpg'" 
                           :alt="relatedBook.judul"
                           class="w-full h-32 object-cover rounded-lg group-hover:scale-105 transition-transform duration-200">
                    </div>
                    <h3 class="font-medium text-sm text-dark-900 group-hover:text-primary-600 line-clamp-2">
                      {{ relatedBook.judul }}
                    </h3>
                    <p class="text-xs text-gray-600">{{ relatedBook.pengarang }}</p>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

const props = defineProps({
  book: Object,
  relatedBooks: Array,
})

const canEdit = computed(() => {
  return window.Laravel?.user && props.book.user_id === window.Laravel.user.id
})

const scrollToStory = () => {
  const storyElement = document.querySelector('#gemini-story-embed')
  if (storyElement) {
    storyElement.scrollIntoView({ 
      behavior: 'smooth',
      block: 'start'
    })
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
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
