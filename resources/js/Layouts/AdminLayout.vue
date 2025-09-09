<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Admin Navigation -->
    <nav class="bg-gradient-to-r from-purple-600 to-purple-700 shadow-lg border-b-2 border-purple-300 sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Admin Logo -->
          <div class="flex-shrink-0 flex items-center">
            <Link :href="route('admin.dashboard')" class="flex items-center space-x-3 group">
              <!-- Admin Icon -->
              <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg shadow-md group-hover:shadow-lg transition-all duration-200">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="flex flex-col">
                <span class="text-xl font-bold text-white">
                  Admin Panel
                </span>
                <span class="text-xs text-purple-200">
                  Buku Cerita
                </span>
              </div>
            </Link>
          </div>
          
          <!-- Admin Navigation Links -->
          <div class="flex items-center space-x-6">
            <!-- Menu Items -->
            <div class="hidden md:flex items-center space-x-4">
              <Link :href="route('admin.dashboard')" 
                    :class="$page.component === 'Admin/Dashboard' ? 'admin-navbar-link-active' : 'admin-navbar-link'">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                </svg>
                Dashboard
              </Link>
              <Link :href="route('admin.books')" 
                    :class="$page.component === 'Admin/Books' ? 'admin-navbar-link-active' : 'admin-navbar-link'">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
                Kelola Buku
              </Link>
              <Link :href="route('admin.categories')" 
                    :class="$page.component === 'Admin/Categories' ? 'admin-navbar-link-active' : 'admin-navbar-link'">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                </svg>
                Kategori
              </Link>
            </div>

            <!-- User Info & Actions -->
            <div class="flex items-center space-x-3">
              <!-- Back to Site -->
              <Link :href="route('home')" class="admin-btn-outline">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                </svg>
                Kembali ke Site
              </Link>
              
              <!-- Admin Profile -->
              <div class="flex items-center space-x-2 bg-purple-100 px-3 py-2 rounded-lg">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                  <span class="text-white text-sm font-medium">
                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                  </span>
                </div>
                <span class="text-sm font-medium text-purple-800">
                  {{ $page.props.auth.user.name }}
                </span>
              </div>
              
              <!-- Logout -->
              <Link :href="route('logout')" method="post" class="admin-btn-danger">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                </svg>
                Keluar
              </Link>
            </div>
          </div>

          <!-- Mobile menu button -->
          <div class="flex items-center md:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="inline-flex items-center justify-center p-2 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 text-white hover:from-purple-600 hover:to-purple-700 shadow-md transition-all duration-200">
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" 
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" 
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" class="md:hidden bg-purple-700 border-t-2 border-purple-300 shadow-lg">
        <div class="px-4 pt-4 pb-6 space-y-3">
          <!-- Navigation Links -->
          <Link :href="route('admin.dashboard')" 
                :class="$page.component === 'Admin/Dashboard' ? 'admin-mobile-link-active' : 'admin-mobile-link'">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
            </svg>
            Dashboard
          </Link>
          <Link :href="route('admin.books')" 
                :class="$page.component === 'Admin/Books' ? 'admin-mobile-link-active' : 'admin-mobile-link'">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
            </svg>
            Kelola Buku
          </Link>
          <Link :href="route('admin.categories')" 
                :class="$page.component === 'Admin/Categories' ? 'admin-mobile-link-active' : 'admin-mobile-link'">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
            </svg>
            Kategori
          </Link>

          <!-- Divider -->
          <hr class="border-purple-500">

          <!-- Actions -->
          <Link :href="route('home')" class="admin-mobile-btn-outline">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
            </svg>
            Kembali ke Site
          </Link>
          
          <div class="flex items-center space-x-3 bg-purple-600 p-3 rounded-lg">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-300 to-purple-500 rounded-full flex items-center justify-center">
              <span class="text-purple-900 text-lg font-semibold">
                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
              </span>
            </div>
            <span class="text-base font-medium text-white">
              {{ $page.props.auth.user.name }}
            </span>
          </div>
          
          <Link :href="route('logout')" method="post" class="admin-mobile-btn-danger">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
            </svg>
            Keluar
          </Link>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <div v-if="$page.props.flash?.message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded-lg shadow-sm">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ $page.props.flash.message }}
      </div>
    </div>

    <!-- Error Messages -->
    <div v-if="$page.props.errors?.message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded-lg shadow-sm">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        {{ $page.props.errors.message }}
      </div>
    </div>

    <!-- Main Content -->
    <main class="py-8">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-purple-800 to-purple-900 text-white">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <p class="text-purple-200">&copy; 2025 Buku Cerita Admin Panel. Kelola dengan ❤️</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const mobileMenuOpen = ref(false)
</script>
