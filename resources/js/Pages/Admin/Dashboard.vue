<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Admin</h1>
        <p class="text-gray-600">Selamat datang di panel admin Buku Cerita</p>
      </div>

      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Books -->
        <div class="admin-stat-card">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="w-8 h-8 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-purple-200 truncate">Total Buku</dt>
                <dd class="text-3xl font-bold text-white">{{ stats.total_books }}</dd>
              </dl>
            </div>
          </div>
        </div>

        <!-- Pending Books -->
        <div class="admin-stat-card bg-gradient-to-br from-orange-500 to-orange-600">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="w-8 h-8 text-orange-200" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-orange-200 truncate">Menunggu Persetujuan</dt>
                <dd class="text-3xl font-bold text-white">{{ stats.pending_books }}</dd>
              </dl>
            </div>
          </div>
        </div>

        <!-- Total Categories -->
        <div class="admin-stat-card bg-gradient-to-br from-green-500 to-green-600">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="w-8 h-8 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-green-200 truncate">Total Kategori</dt>
                <dd class="text-3xl font-bold text-white">{{ stats.total_categories }}</dd>
              </dl>
            </div>
          </div>
        </div>

        <!-- Total Users -->
        <div class="admin-stat-card bg-gradient-to-br from-blue-500 to-blue-600">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="w-8 h-8 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
              </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-blue-200 truncate">Total User</dt>
                <dd class="text-3xl font-bold text-white">{{ stats.total_users }}</dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Pending Books -->
        <div class="admin-card">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Buku Menunggu Persetujuan</h3>
            <Link :href="route('admin.books')" class="text-orange-600 hover:text-orange-700 font-medium">
              Lihat Semua →
            </Link>
          </div>
          
          <div v-if="pendingBooks.length > 0" class="space-y-3">
            <div v-for="book in pendingBooks" :key="book.id" 
                 class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
              <div class="flex-1">
                <p class="font-medium text-gray-900">{{ book.judul }}</p>
                <p class="text-sm text-gray-600">oleh {{ book.user.name }}</p>
              </div>
              <div class="flex space-x-2">
                <button @click="approveBook(book.id)" 
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200">
                  Setujui
                </button>
                <button @click="rejectBook(book.id)" 
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200">
                  Tolak
                </button>
              </div>
            </div>
          </div>
          
          <div v-else class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p>Tidak ada buku yang menunggu persetujuan</p>
          </div>
        </div>

        <!-- System Info -->
        <div class="admin-card">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Sistem</h3>
          </div>
          
          <div class="space-y-4">
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
              <span class="text-sm text-gray-600">Buku Disetujui</span>
              <span class="text-sm font-semibold text-green-600">{{ stats.approved_books }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
              <span class="text-sm text-gray-600">Buku Menunggu</span>
              <span class="text-sm font-semibold text-orange-600">{{ stats.pending_books }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
              <span class="text-sm text-gray-600">Total Kategori</span>
              <span class="text-sm font-semibold text-blue-600">{{ stats.total_categories }}</span>
            </div>
            <div class="flex items-center justify-between py-2">
              <span class="text-sm text-gray-600">Total User</span>
              <span class="text-sm font-semibold text-purple-600">{{ stats.total_users }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Admin Settings Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Change Password Card -->
        <ChangePasswordCard />
        
        <!-- Admin Profile Settings -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
          <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-lg shadow-lg">
                  <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-gray-900">Profil Admin</h3>
                  <p class="text-sm text-gray-600">Kelola informasi profil admin</p>
                </div>
              </div>
              <Link :href="route('profile.show')" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-medium transition-all duration-200 flex items-center text-sm">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                </svg>
                Edit Profil
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <Link :href="route('admin.books')" class="admin-card hover:shadow-xl group">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h4 class="text-lg font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">
                Kelola Buku
              </h4>
              <p class="text-sm text-gray-600">Setujui atau tolak buku yang diunggah</p>
            </div>
          </div>
        </Link>

        <Link :href="route('admin.categories')" class="admin-card hover:shadow-xl group">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h4 class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                Kelola Kategori
              </h4>
              <p class="text-sm text-gray-600">Tambah, edit, atau hapus kategori</p>
            </div>
          </div>
        </Link>

        <Link :href="route('home')" class="admin-card hover:shadow-xl group">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                Lihat Website
              </h4>
              <p class="text-sm text-gray-600">Kembali ke halaman utama</p>
            </div>
          </div>
        </Link>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ChangePasswordCard from '@/Components/ChangePasswordCard.vue'

const props = defineProps({
  stats: Object,
  pendingBooks: Array
})

const approveBook = (bookId) => {
  router.post(route('admin.books.approve', bookId), {}, {
    onSuccess: () => {
      // Refresh page data or update reactive state
    }
  })
}

const rejectBook = (bookId) => {
  router.post(route('admin.books.reject', bookId), {}, {
    onSuccess: () => {
      // Refresh page data or update reactive state
    }
  })
}


</script>
