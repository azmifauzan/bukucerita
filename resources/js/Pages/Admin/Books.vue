<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Kelola Buku</h1>
        <p class="text-gray-600">Setujui atau tolak buku yang diunggah oleh pengguna</p>
      </div>

      <!-- Filters -->
      <div class="admin-card mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
          <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Buku</label>
            <input
              v-model="searchForm.search"
              @input="search"
              type="text"
              id="search"
              placeholder="Cari berdasarkan judul, pengarang, atau penulis..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
            />
          </div>
          <div class="sm:w-48">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
            <select
              v-model="searchForm.status"
              @change="search"
              id="status"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
            >
              <option value="">Semua Status</option>
              <option value="pending">Menunggu Persetujuan</option>
              <option value="approved">Disetujui</option>
              <option value="rejected">Ditolak</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Books List -->
      <div class="admin-card">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Buku
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Penulis
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Kategori
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tanggal Upload
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="book in books.data" :key="book.id" class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-12">
                      <div v-if="book.cover_image" class="h-16 w-12 bg-gray-200 rounded border overflow-hidden">
                        <img :src="book.cover_image" :alt="book.judul" class="h-full w-full object-cover">
                      </div>
                      <div v-else class="h-16 w-12 bg-gradient-to-br from-orange-400 to-orange-500 rounded border flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ book.judul }}</div>
                      <div class="text-sm text-gray-500">{{ book.pengarang }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8">
                      <div class="h-8 w-8 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">
                          {{ book.user.name.charAt(0).toUpperCase() }}
                        </span>
                      </div>
                    </div>
                    <div class="ml-3">
                      <div class="text-sm font-medium text-gray-900">{{ book.user.name }}</div>
                      <div class="text-sm text-gray-500">{{ book.user.email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ book.category.name }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusClass(book.status)" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                    {{ getStatusText(book.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(book.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end space-x-2">
                    <button
                      v-if="book.status === 'pending'"
                      @click="approveBook(book.id)"
                      class="inline-flex items-center px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded transition-colors duration-200"
                    >
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                      </svg>
                      Setujui
                    </button>
                    <button
                      v-if="book.status === 'pending'"
                      @click="rejectBook(book.id)"
                      class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded transition-colors duration-200"
                    >
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                      </svg>
                      Tolak
                    </button>
                    <button
                      @click="viewBook(book)"
                      class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200"
                    >
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                      </svg>
                      Lihat
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="books.data.length > 0" class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-4">
          <div class="flex flex-1 justify-between sm:hidden">
            <Link
              v-if="books.prev_page_url"
              :href="books.prev_page_url"
              class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Previous
            </Link>
            <Link
              v-if="books.next_page_url"
              :href="books.next_page_url"
              class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Next
            </Link>
          </div>
          <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ books.from }}</span> to <span class="font-medium">{{ books.to }}</span> of
                <span class="font-medium">{{ books.total }}</span> results
              </p>
            </div>
            <div>
              <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                <Link
                  v-if="books.prev_page_url"
                  :href="books.prev_page_url"
                  class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                >
                  <span class="sr-only">Previous</span>
                  <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                  </svg>
                </Link>

                <span
                  v-for="page in books.links.slice(1, -1)"
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
                  v-if="books.next_page_url"
                  :href="books.next_page_url"
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada buku</h3>
          <p class="mt-1 text-sm text-gray-500">Belum ada buku yang sesuai dengan filter yang dipilih.</p>
        </div>
      </div>

      <!-- Book Detail Modal -->
      <div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <!-- Background overlay -->
          <div 
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            aria-hidden="true"
            @click="closeModal"
          ></div>

          <!-- Modal panel -->
          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <!-- Modal Header -->
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                  Detail Buku
                </h3>
                <button
                  @click="closeModal"
                  class="bg-white rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                  <span class="sr-only">Close</span>
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              <!-- Modal Content -->
              <div v-if="selectedBook" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Book Cover -->
                <div class="lg:col-span-1">
                  <div class="aspect-w-2 aspect-h-3 w-full max-w-xs mx-auto">
                    <div v-if="selectedBook.cover_image" class="w-full h-80 bg-gray-200 rounded-lg overflow-hidden shadow-lg">
                      <img :src="selectedBook.cover_image" :alt="selectedBook.judul" class="w-full h-full object-cover">
                    </div>
                    <div v-else class="w-full h-80 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
                      <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                      </svg>
                    </div>
                  </div>
                </div>

                <!-- Book Details -->
                <div class="lg:col-span-2 space-y-6">
                  <!-- Basic Information -->
                  <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Buku</h4>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Judul</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ selectedBook.judul }}</dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Pengarang</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ selectedBook.pengarang }}</dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                        <dd class="mt-1">
                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ selectedBook.category.name }}
                          </span>
                        </dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                          <span :class="getStatusClass(selectedBook.status)" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                            {{ getStatusText(selectedBook.status) }}
                          </span>
                        </dd>
                      </div>
                      <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Upload</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ formatDate(selectedBook.created_at) }}</dd>
                      </div>
                      <div v-if="selectedBook.updated_at !== selectedBook.created_at">
                        <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ formatDate(selectedBook.updated_at) }}</dd>
                      </div>
                    </dl>
                  </div>

                  <!-- Uploader Information -->
                  <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penulis Upload</h4>
                    <div class="flex items-center space-x-4">
                      <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center">
                          <span class="text-white text-lg font-medium">
                            {{ selectedBook.user.name.charAt(0).toUpperCase() }}
                          </span>
                        </div>
                      </div>
                      <div>
                        <div class="text-sm font-medium text-gray-900">{{ selectedBook.user.name }}</div>
                        <div class="text-sm text-gray-500">{{ selectedBook.user.email }}</div>
                      </div>
                    </div>
                  </div>

                  <!-- Sinopsis (if available) -->
                  <div v-if="selectedBook.sinopsis">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Sinopsis</h4>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ selectedBook.sinopsis }}</p>
                  </div>

                  <!-- Reading Information -->
                  <div v-if="selectedBook.link">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Akses Buku</h4>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                      <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                          <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5z"/>
                            <path d="M7.414 15.414a2 2 0 01-2.828-2.828l3-3a2 2 0 012.828 0 1 1 0 001.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 005.656 5.656l1.5-1.5a1 1 0 00-1.414-1.414l-1.5 1.5z"/>
                          </svg>
                        </div>
                        <div class="flex-1">
                          <h5 class="text-sm font-medium text-blue-900">Link Buku Tersedia</h5>
                          <p class="text-xs text-blue-700 mt-1">Pengguna telah menyediakan link untuk membaca buku ini secara online.</p>
                          <div class="mt-3">
                            <button
                              @click="openBookLink"
                              class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200"
                            >
                              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-1a1 1 0 10-2 0v1H5V7h1a1 1 0 000-2H5z"/>
                              </svg>
                              Baca Buku
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- No Link Warning -->
                  <div v-else>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Akses Buku</h4>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                      <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                          <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                          </svg>
                        </div>
                        <div class="flex-1">
                          <h5 class="text-sm font-medium text-yellow-900">Link Buku Tidak Tersedia</h5>
                          <p class="text-xs text-yellow-700 mt-1">Pengguna belum menyediakan link untuk membaca buku ini secara online.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Actions -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <div class="flex flex-wrap gap-3">
                <!-- Primary Actions (Approve/Reject) -->
                <button
                  v-if="selectedBook && selectedBook.status === 'pending'"
                  @click="approveBookFromModal"
                  class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-200"
                >
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                  </svg>
                  Setujui Buku
                </button>
                <button
                  v-if="selectedBook && selectedBook.status === 'pending'"
                  @click="rejectBookFromModal"
                  class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors duration-200"
                >
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                  </svg>
                  Tolak Buku
                </button>
                
                <!-- Secondary Actions -->
                <button
                  v-if="selectedBook && selectedBook.link"
                  @click="openBookLink"
                  class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200"
                >
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-1a1 1 0 10-2 0v1H5V7h1a1 1 0 000-2H5z"/>
                  </svg>
                  Baca Buku
                </button>
                
                <button
                  @click="closeModal"
                  class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md transition-colors duration-200"
                >
                  Tutup
                </button>
              </div>
            </div>
          </div>
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
  books: Object,
  filters: Object
})

const searchForm = reactive({
  search: props.filters.search || '',
  status: props.filters.status || ''
})

// Modal state
const showModal = ref(false)
const selectedBook = ref(null)

const search = () => {
  router.get(route('admin.books'), searchForm, {
    preserveState: true,
    replace: true
  })
}

const approveBook = (bookId) => {
  router.post(route('admin.books.approve', bookId), {}, {
    onSuccess: () => {
      // Success handled by flash message
    }
  })
}

const rejectBook = (bookId) => {
  router.post(route('admin.books.reject', bookId), {}, {
    onSuccess: () => {
      // Success handled by flash message
    }
  })
}

const viewBook = (book) => {
  selectedBook.value = book
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedBook.value = null
}

const approveBookFromModal = () => {
  if (selectedBook.value) {
    approveBook(selectedBook.value.id)
    closeModal()
  }
}

const rejectBookFromModal = () => {
  if (selectedBook.value) {
    rejectBook(selectedBook.value.id)
    closeModal()
  }
}

const openBookLink = () => {
  if (selectedBook.value && selectedBook.value.link) {
    // Ensure the link has a proper protocol
    let url = selectedBook.value.link
    if (!url.match(/^https?:\/\//)) {
      url = 'https://' + url
    }
    window.open(url, '_blank', 'noopener,noreferrer')
  }
}

const getStatusClass = (status) => {
  switch (status) {
    case 'approved':
      return 'bg-green-100 text-green-800'
    case 'rejected':
      return 'bg-red-100 text-red-800'
    case 'pending':
      return 'bg-yellow-100 text-yellow-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getStatusText = (status) => {
  switch (status) {
    case 'approved':
      return 'Disetujui'
    case 'rejected':
      return 'Ditolak'
    case 'pending':
      return 'Menunggu'
    default:
      return 'Unknown'
  }
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>
