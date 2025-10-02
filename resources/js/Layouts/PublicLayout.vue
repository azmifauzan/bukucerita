<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-white to-orange-50 shadow-lg border-b-2 border-orange-200 sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex-shrink-0 flex items-center">
            <Link :href="route('home')" class="flex items-center space-x-3 group">
              <!-- Book Icon -->
              <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg shadow-md group-hover:shadow-lg transition-all duration-200">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
              </div>
              <span class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">
                Buku Cerita
              </span>
            </Link>
          </div>
          
          <!-- Navigation Links - Moved to Right -->
          <div class="flex items-center space-x-6">
            <!-- Menu Items -->
            <div class="hidden md:flex items-center space-x-4">
              <Link :href="route('home')" 
                    :class="$page.component === 'Home' ? 'navbar-link-active' : 'navbar-link'">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Beranda
              </Link>
              <Link :href="route('books.index')" 
                    :class="$page.component.startsWith('Books/Collection') ? 'navbar-link-active' : 'navbar-link'">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                </svg>
                Koleksi Buku
              </Link>
              <Link :href="route('guide')" 
                    :class="$page.component === 'Guide' ? 'navbar-link-active' : 'navbar-link'">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
                Panduan
              </Link>
            </div>

            <!-- Auth Links -->
            <div class="flex items-center space-x-3">
              <template v-if="$page.props.auth?.user">
                <Link :href="route('books.create')" class="btn-primary-gradient">
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                  </svg>
                  Upload Buku
                </Link>
                
                <div class="flex items-center space-x-2 bg-orange-100 px-3 py-2 rounded-lg">
                  <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-medium">
                      {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                    </span>
                  </div>
                  <span class="text-sm font-medium text-gray-800">
                    {{ $page.props.auth.user.name }}
                  </span>
                </div>
                
                <!-- Admin Link -->
                <Link v-if="$page.props.auth.user?.email === 'admin@bukucerita.my.id'" 
                      :href="route('admin.dashboard')" 
                      class="btn-admin">
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                  </svg>
                  Admin
                </Link>
                
                <Link :href="route('logout')" method="post" class="btn-logout">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                  </svg>
                  Keluar
                </Link>
              </template>
              
              <template v-else>
                <Link :href="route('login')" class="btn-outline">
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"/>
                  </svg>
                  Masuk
                </Link>
                <Link :href="route('register')" class="btn-primary-gradient">
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                  </svg>
                  Daftar
                </Link>
              </template>
            </div>
          </div>

          <!-- Mobile menu button -->
          <div class="flex items-center md:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="inline-flex items-center justify-center p-2 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 text-white hover:from-orange-600 hover:to-orange-700 shadow-md transition-all duration-200">
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
      <div :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" class="md:hidden bg-white border-t-2 border-orange-200 shadow-lg">
        <div class="px-4 pt-4 pb-6 space-y-3">
          <!-- Navigation Links -->
          <Link :href="route('home')" 
                :class="$page.component === 'Home' ? 'mobile-link-active' : 'mobile-link'">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
            </svg>
            Beranda
          </Link>
          <Link :href="route('books.index')" 
                :class="$page.component.startsWith('Books/Collection') ? 'mobile-link-active' : 'mobile-link'">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
            </svg>
            Koleksi Buku
          </Link>
          <Link :href="route('guide')" 
                :class="$page.component === 'Guide' ? 'mobile-link-active' : 'mobile-link'">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            </svg>
            Panduan
          </Link>

          <!-- Divider -->
          <hr class="border-orange-200">

          <!-- Auth Links -->
          <template v-if="$page.props.auth?.user">
            <Link :href="route('books.create')" class="mobile-btn-primary">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
              </svg>
              Upload Buku
            </Link>
            
            <div class="flex items-center space-x-3 bg-orange-50 p-3 rounded-lg">
              <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center">
                <span class="text-white text-lg font-semibold">
                  {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                </span>
              </div>
              <span class="text-base font-medium text-gray-800">
                {{ $page.props.auth.user.name }}
              </span>
            </div>
            
            <Link v-if="$page.props.auth.user?.email === 'admin@bukucerita.my.id'" 
                  :href="route('admin.dashboard')" 
                  class="mobile-btn-admin">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
              </svg>
              Admin
            </Link>
            
            <Link :href="route('logout')" method="post" class="mobile-btn-logout">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
              </svg>
              Keluar
            </Link>
          </template>
          
          <template v-else>
            <Link :href="route('login')" class="mobile-btn-outline">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"/>
              </svg>
              Masuk
            </Link>
            <Link :href="route('register')" class="mobile-btn-primary">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
              </svg>
              Daftar
            </Link>
          </template>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <div v-if="$page.props.flash?.message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded">
      {{ $page.props.flash?.message }}
    </div>

    <!-- Main Content -->
    <main>
      <slot />
    </main>

    <!-- Visual Separator -->
    <div class="relative">
      <!-- Gradient Divider -->
      <div class="h-1 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600"></div>
      
      <!-- Decorative Wave -->
      <div class="absolute inset-0 overflow-hidden">
        <svg class="absolute bottom-0 left-0 w-full h-6 text-orange-500 transform" 
             fill="currentColor" viewBox="0 0 1200 120" preserveAspectRatio="none">
          <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 20px 20px;"></div>
      </div>
      
      <!-- Orange accent at top -->
      <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600"></div>
      
      <div class="relative max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="col-span-1 md:col-span-2">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-3 mb-6">
              <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
              </div>
              <h3 class="text-3xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                Buku Cerita
              </h3>
            </div>
            
            <p class="text-gray-300 text-lg leading-relaxed mb-6 max-w-2xl">
              Platform koleksi cerita anak digital yang dihasilkan oleh AI Google Gemini. 
              Menyediakan cerita berkualitas untuk mengembangkan minat baca anak-anak Indonesia.
            </p>
            
            <!-- Features -->
            <div class="flex flex-wrap gap-4">
              <div class="flex items-center space-x-2 bg-gray-800 px-4 py-2 rounded-full">
                <svg class="w-4 h-4 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm text-gray-300">Cerita Berkualitas</span>
              </div>
              <div class="flex items-center space-x-2 bg-gray-800 px-4 py-2 rounded-full">
                <svg class="w-4 h-4 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm text-gray-300">Gratis untuk Semua</span>
              </div>
            </div>
          </div>
          
          <div class="col-span-1">
            <h4 class="text-xl font-semibold mb-6 text-orange-400">Navigasi</h4>
            <ul class="space-y-3">
              <li>
                <Link :href="route('home')" 
                      class="flex items-center space-x-2 text-gray-300 hover:text-orange-400 transition-colors duration-200 group">
                  <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                  </svg>
                  <span>Beranda</span>
                </Link>
              </li>
              <li>
                <Link :href="route('books.index')" 
                      class="flex items-center space-x-2 text-gray-300 hover:text-orange-400 transition-colors duration-200 group">
                  <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                  </svg>
                  <span>Koleksi Buku</span>
                </Link>
              </li>
              <li>
                <Link :href="route('guide')" 
                      class="flex items-center space-x-2 text-gray-300 hover:text-orange-400 transition-colors duration-200 group">
                  <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                  </svg>
                  <span>Panduan</span>
                </Link>
              </li>
            </ul>
          </div>
        </div>
        
        <!-- Bottom Section -->
        <div class="mt-12 pt-8 border-t border-gray-700">
          <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="text-center md:text-left">
              <p class="text-gray-400 text-sm">
                &copy; 2025 Buku Cerita. Dibuat dengan 
                <span class="text-red-400 animate-pulse">❤️</span> 
                untuk anak-anak Indonesia.
              </p>
            </div>
            
            <!-- Powered by -->
            <div class="flex items-center space-x-2 text-sm text-gray-500">
              <span>Powered by</span>
              <div class="flex items-center space-x-1 bg-gray-800 px-2 py-1 rounded">
                <svg class="w-4 h-4 text-blue-400" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 2L2 7V10C2 16 6 20.5 12 22C18 20.5 22 16 22 10V7L12 2Z"/>
                </svg>
                <span class="text-blue-400 font-medium">Google Gemini AI</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Decorative elements -->
      <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-tl from-orange-600/20 to-transparent rounded-full transform translate-x-16 translate-y-16"></div>
      <div class="absolute top-1/2 left-0 w-24 h-24 bg-gradient-to-br from-orange-500/10 to-transparent rounded-full transform -translate-x-12"></div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const mobileMenuOpen = ref(false)
</script>
