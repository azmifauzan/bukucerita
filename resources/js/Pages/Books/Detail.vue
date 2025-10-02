<template>
  <Head>
    <title>{{ book.judul }} - Cerita Anak Digital</title>
    <meta name="description" :content="`Baca cerita '${book.judul}' oleh ${book.pengarang}. ${book.sinopsis.substring(0, 150)}... Cerita interaktif untuk anak usia ${book.age_min}-${book.age_max} tahun.`">
    <meta name="keywords" :content="`${book.judul}, ${book.pengarang}, cerita anak ${book.category.name.toLowerCase()}, buku digital anak, ${book.age_min}-${book.age_max} tahun`">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="book">
    <meta property="og:title" :content="`${book.judul} - Cerita Anak Digital | Buku Cerita`">
    <meta property="og:description" :content="`Baca cerita '${book.judul}' oleh ${book.pengarang}. Cerita interaktif untuk anak usia ${book.age_min}-${book.age_max} tahun dengan teknologi AI.`">
    <meta property="og:image" :content="book.cover || '/images/default-book-cover.jpg'">
    <meta property="og:url" :content="route('books.show', book.slug)">
    <meta property="book:author" :content="book.pengarang">
    <meta property="book:genre" :content="book.category.name">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" :content="`${book.judul} - Cerita Anak Digital`">
    <meta name="twitter:description" :content="`Cerita '${book.judul}' oleh ${book.pengarang} untuk anak usia ${book.age_min}-${book.age_max} tahun.`">
    <meta name="twitter:image" :content="book.cover || '/images/default-book-cover.jpg'">
  </Head>
  
  <PublicLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Breadcrumb -->
      <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center">
            <Link :href="route('home')" 
                  class="text-gray-500 hover:text-gray-700"
                  title="Kembali ke Beranda Buku Cerita">
              Beranda
            </Link>
          </li>
          <li>
            <div class="flex items-center">
              <span class="text-gray-400 mx-1">/</span>
              <Link :href="route('books.index')" 
                    class="text-gray-500 hover:text-gray-700"
                    title="Lihat Semua Koleksi Buku Cerita">
                Koleksi Buku
              </Link>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <span class="text-gray-400 mx-1">/</span>
              <span class="text-gray-500">{{ book.judul }}</span>
            </div>
          </li>
        </ol>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Book Cover and Details -->
        <div class="lg:col-span-1">
          <div class="card sticky top-8">
            <div class="aspect-w-3 aspect-h-4 mb-4">
              <img :src="book.cover || '/images/default-book-cover.jpg'" 
                   :alt="`Cover buku cerita ${book.judul} oleh ${book.pengarang} - ${book.category.name} untuk usia ${book.age_min}-${book.age_max} tahun`"
                   class="w-full h-64 object-cover rounded-lg">
            </div>
            
            <div class="p-6 pt-0">
              <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                <span class="px-2 py-1 bg-primary-100 text-primary-700 rounded-full">
                  {{ book.category.name }}
                </span>
              </div>
              
              <h1 class="text-2xl font-bold text-dark-900 mb-2">{{ book.judul }}</h1>
              <h2 class="text-gray-600 mb-4">oleh {{ book.pengarang }}</h2>
              
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
              <h3 class="text-xl font-bold text-dark-900 mb-4">Sinopsis</h3>
              <p class="text-gray-700 leading-relaxed">{{ book.sinopsis }}</p>
            </div>
          </div>

          <!-- Gemini Story Access -->
          <div id="gemini-story-embed" class="card mb-8">
            <div class="p-6">
              <h3 class="text-xl font-bold text-dark-900 mb-4">Cerita Interaktif</h3>
              <p class="text-gray-600 mb-4">
                Cerita ini dibuat menggunakan Google Gemini AI. Klik tombol di bawah untuk membaca cerita lengkap.
              </p>
              
              <div class="flex flex-col sm:flex-row gap-4 items-center justify-between p-4 bg-gradient-to-r from-primary-50 to-blue-50 rounded-lg border border-primary-200">
                <div class="flex items-center space-x-3">
                  <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
                    <!-- Google / Gemini logo (inline SVG) -->
                    <svg class="w-8 h-8" viewBox="0 0 48 48" role="img" aria-label="Google logo" xmlns="http://www.w3.org/2000/svg">
                      <path fill="#4285F4" d="M24 9.5c3.9 0 7 1.3 9.3 3.5l7-7C36.9 2.6 30.9 0 24 0 14.8 0 6.9 4.6 2.6 11.4l8.5 6.6C13.9 13.1 18.5 9.5 24 9.5z"/>
                      <path fill="#34A853" d="M46.9 24.5c0-1.6-.1-3.1-.4-4.6H24v8.7h12.8c-.6 3.3-2.6 6.1-5.6 7.9l8.6 6.7c5-4.6 7.1-11.5 7.1-19.7z"/>
                      <path fill="#FBBC05" d="M10.9 28.1c-.6-1.9-.6-3.9 0-5.8L2.4 15.7C.9 18.7 0 21.9 0 25.2s.9 6.5 2.4 9.5l8.5-6.6z"/>
                      <path fill="#EA4335" d="M24 48c6.9 0 12.9-2.6 17.4-6.9l-8.6-6.7C31.1 34.7 27.9 36 24 36 18.5 36 13.9 32.4 11 28.1l-8.5 6.6C6.9 43.4 14.8 48 24 48z"/>
                    </svg>
                  </div>
                  <div>
                    <h3 class="font-medium text-gray-900">Baca dengan Google Gemini</h3>
                    <p class="text-sm text-gray-600">Pengalaman membaca interaktif dengan AI</p>
                  </div>
                </div>
                
                <a :href="book.link" 
                   target="_blank"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 whitespace-nowrap shadow-lg">
                  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                  </svg>
                  📖 Baca Cerita di Gemini
                </a>
              </div>
              
              <div class="mt-3 text-xs text-gray-500 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Cerita akan terbuka di tab baru. Gunakan akun Google untuk pengalaman terbaik.
              </div>
            </div>
          </div>

          <!-- YouTube Video -->
          <div v-if="book.youtube_link" class="card mb-8">
            <div class="p-6">
              <h2 class="text-xl font-bold text-dark-900 mb-4">Video Pendukung</h2>
              <p class="text-gray-600 mb-4">
                Tonton video yang terkait dengan cerita ini untuk pengalaman yang lebih menarik.
              </p>
              
              <div class="relative overflow-hidden rounded-lg bg-black">
                <div class="aspect-w-16 aspect-h-9">
                  <iframe
                    :src="getYouTubeEmbedUrl(book.youtube_link)"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    loading="lazy"
                  ></iframe>
                </div>
              </div>
              
              <div class="mt-3 flex items-center justify-between text-sm text-gray-500">
                <span>YouTube Video</span>
                <a :href="book.youtube_link" 
                   target="_blank"
                   class="text-primary-600 hover:text-primary-700 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                  </svg>
                  Tonton di YouTube
                </a>
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
                  <Link :href="route('books.show', relatedBook.slug)">
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
import { computed, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'

const props = defineProps({
  book: Object,
  relatedBooks: Array,
})

// Add structured data for SEO
onMounted(() => {
  const structuredData = {
    "@context": "https://schema.org",
    "@type": "Book",
    "name": props.book.judul,
    "author": {
      "@type": "Person",
      "name": props.book.pengarang
    },
    "description": props.book.sinopsis,
    "genre": props.book.category.name,
    "bookFormat": "EBook",
    "inLanguage": "id-ID",
    "audience": {
      "@type": "Audience",
      "audienceType": "Children",
      "suggestedMinAge": props.book.age_min,
      "suggestedMaxAge": props.book.age_max
    },
    "publisher": {
      "@type": "Organization",
      "name": "Buku Cerita"
    },
    "url": window.location.href,
    "image": props.book.cover || '/images/default-book-cover.jpg',
    "interactionStatistic": {
      "@type": "InteractionCounter",
      "interactionType": "https://schema.org/ReadAction",
      "userInteractionCount": props.book.views
    },
    "isAccessibleForFree": true,
    "potentialAction": {
      "@type": "ReadAction",
      "target": window.location.href
    }
  }
  
  const script = document.createElement('script')
  script.type = 'application/ld+json'
  script.textContent = JSON.stringify(structuredData)
  document.head.appendChild(script)
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

const getYouTubeEmbedUrl = (url) => {
  if (!url) return ''
  
  // Extract video ID from various YouTube URL formats
  let videoId = ''
  
  if (url.includes('watch?v=')) {
    videoId = url.split('watch?v=')[1].split('&')[0]
  } else if (url.includes('youtu.be/')) {
    videoId = url.split('youtu.be/')[1].split('?')[0]
  } else if (url.includes('embed/')) {
    videoId = url.split('embed/')[1].split('?')[0]
  }
  
  return `https://www.youtube.com/embed/${videoId}?rel=0&modestbranding=1`
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

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.aspect-w-3 {
  position: relative;
  padding-bottom: calc(4 / 3 * 100%);
}

.aspect-w-16 {
  position: relative;
  padding-bottom: calc(9 / 16 * 100%);
}

.aspect-h-4 img,
.aspect-h-9 iframe {
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}
</style>