<template>
  <Head title="Beranda" />
  
  <PublicLayout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-500 to-primary-600 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Buku Cerita
          </h1>
          <p class="text-xl md:text-2xl mb-8 text-primary-100">
            Koleksi cerita anak digital yang menginspirasi
          </p>
          <p class="text-lg mb-8 text-primary-100 max-w-2xl mx-auto">
            Temukan ribuan cerita menarik untuk anak-anak, dibuat khusus dengan teknologi AI Google Gemini 
            untuk mengembangkan imajinasi dan minat baca si kecil.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <Link :href="route('books.index')" 
                  class="bg-white text-primary-600 hover:bg-gray-100 font-semibold py-4 px-8 rounded-lg transition-colors duration-200">
              Jelajahi Koleksi Buku
            </Link>
            <Link :href="route('guide')" 
                  class="bg-primary-700 hover:bg-primary-800 text-white font-semibold py-4 px-8 rounded-lg transition-colors duration-200">
              Pelajari Cara Membuat
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Books Section -->
    <section v-if="featuredBooks.length > 0" class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-dark-900 mb-4">Buku Populer</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Buku-buku cerita yang paling disukai oleh anak-anak dan orang tua
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="book in featuredBooks" :key="book.id" class="card hover:shadow-lg transition-shadow duration-300">
            <div class="aspect-w-3 aspect-h-4">
              <img :src="book.cover || '/images/default-book-cover.jpg'" 
                   :alt="book.judul"
                   class="w-full h-48 object-cover">
            </div>
            <div class="p-6">
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
      </div>
    </section>

    <!-- Categories Section -->
    <section v-if="categories.length > 0" class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-dark-900 mb-4">Kategori Cerita</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Temukan cerita berdasarkan kategori yang disukai anak Anda
          </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
          <Link v-for="category in categories" 
                :key="category.id"
                :href="route('books.index', { category: category.slug })"
                class="card text-center p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">📚</span>
            </div>
            <h3 class="font-semibold text-dark-900 mb-2">{{ category.name }}</h3>
            <p class="text-sm text-gray-600 mb-2">{{ category.description }}</p>
            <span class="text-xs text-primary-600 font-medium">
              {{ category.books_count }} buku
            </span>
          </Link>
        </div>
      </div>
    </section>

    <!-- Recent Books Section -->
    <section v-if="recentBooks.length > 0" class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
          <div>
            <h2 class="text-3xl font-bold text-dark-900 mb-4">Buku Terbaru</h2>
            <p class="text-gray-600 max-w-2xl">
              Koleksi cerita terbaru yang baru saja ditambahkan
            </p>
          </div>
          <Link :href="route('books.index')" 
                class="mt-6 md:mt-0 btn-outline">
            Lihat Semua Buku
          </Link>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div v-for="book in recentBooks" :key="book.id" class="card hover:shadow-lg transition-shadow duration-300">
            <div class="aspect-w-3 aspect-h-4">
              <img :src="book.cover || '/images/default-book-cover.jpg'" 
                   :alt="book.judul"
                   class="w-full h-40 object-cover">
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-dark-900 mb-1 text-sm line-clamp-2">
                {{ book.judul }}
              </h3>
              <p class="text-gray-600 text-xs mb-2">{{ book.pengarang }}</p>
              <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500">
                  {{ book.age_min }}-{{ book.age_max }}th
                </span>
                <Link :href="route('books.show', book.id)" 
                      class="text-primary-600 hover:text-primary-700 font-medium text-xs">
                  Baca
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-dark-900 text-white">
      <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-4">Punya Cerita Sendiri?</h2>
        <p class="text-lg mb-8 text-gray-300">
          Bagikan cerita karya Anda dengan komunitas. Upload cerita buatan Google Gemini dan 
          bantu anak-anak lain menemukan cerita menarik.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Link v-if="$page.props.auth.user" 
                :href="route('books.create')" 
                class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
            Upload Cerita
          </Link>
          <Link v-else 
                :href="route('register')" 
                class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
            Daftar Sekarang
          </Link>
          <Link :href="route('guide')" 
                class="border border-gray-600 hover:border-gray-500 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
            Pelajari Caranya
          </Link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

defineProps({
  featuredBooks: Array,
  recentBooks: Array,
  categories: Array,
})
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
