<template>
    <PublicLayout>
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        Upload Buku Cerita
                    </h1>
                    <p class="text-xl text-gray-600">
                        Bagikan cerita anak favorit Anda dengan pengguna lain
                    </p>
                </div>
            </div>
        </div>

        <!-- Upload Form Section -->
        <div class="py-16 bg-white">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Upload Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h2 class="ml-4 text-2xl font-bold text-gray-900">Upload Buku Baru</h2>
                    </div>

                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="flex items-center text-orange-600">
                                <div class="flex items-center justify-center w-8 h-8 bg-orange-600 rounded-full">
                                    <span class="text-white text-sm font-bold">1</span>
                                </div>
                                <span class="ml-2 text-sm font-medium">Informasi Buku</span>
                            </div>
                            <div class="flex-1 h-1 mx-4 bg-gray-200 rounded">
                                <div class="h-full bg-orange-600 rounded w-full"></div>
                            </div>
                            <div class="flex items-center text-gray-400">
                                <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                                    <span class="text-gray-600 text-sm font-bold">2</span>
                                </div>
                                <span class="ml-2 text-sm font-medium">Review & Submit</span>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="submitForm" class="space-y-6">
                        <!-- Book Title -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Buku *
                            </label>
                            <input
                                id="judul"
                                v-model="form.judul"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Masukkan judul buku cerita"
                            />
                            <InputError class="mt-2" :message="form.errors.judul" />
                        </div>

                        <!-- Author -->
                        <div>
                            <label for="pengarang" class="block text-sm font-medium text-gray-700 mb-2">
                                Pengarang *
                            </label>
                            <input
                                id="pengarang"
                                v-model="form.pengarang"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Nama pengarang buku"
                            />
                            <InputError class="mt-2" :message="form.errors.pengarang" />
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori *
                            </label>
                            <select
                                id="category_id"
                                v-model="form.category_id"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                            >
                                <option value="">Pilih kategori buku</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.category_id" />
                        </div>

                        <!-- Age Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="age_min" class="block text-sm font-medium text-gray-700 mb-2">
                                    Usia Minimum *
                                </label>
                                <input
                                    id="age_min"
                                    v-model.number="form.age_min"
                                    type="number"
                                    min="1"
                                    max="18"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                    placeholder="3"
                                />
                                <InputError class="mt-2" :message="form.errors.age_min" />
                            </div>
                            <div>
                                <label for="age_max" class="block text-sm font-medium text-gray-700 mb-2">
                                    Usia Maximum *
                                </label>
                                <input
                                    id="age_max"
                                    v-model.number="form.age_max"
                                    type="number"
                                    min="1"
                                    max="18"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                    placeholder="12"
                                />
                                <InputError class="mt-2" :message="form.errors.age_max" />
                            </div>
                        </div>

                        <!-- Synopsis -->
                        <div>
                            <label for="sinopsis" class="block text-sm font-medium text-gray-700 mb-2">
                                Sinopsis *
                            </label>
                            <textarea
                                id="sinopsis"
                                v-model="form.sinopsis"
                                rows="4"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Ceritakan tentang isi buku ini..."
                            ></textarea>
                            <InputError class="mt-2" :message="form.errors.sinopsis" />
                        </div>

                        <!-- Book Link -->
                        <div>
                            <label for="link" class="block text-sm font-medium text-gray-700 mb-2">
                                Link Buku Online *
                            </label>
                            <input
                                id="link"
                                v-model="form.link"
                                type="url"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="https://example.com/book.pdf"
                            />
                            <p class="mt-1 text-sm text-gray-500">
                                Link ke file PDF atau halaman buku online yang bisa diakses publik
                            </p>
                            <InputError class="mt-2" :message="form.errors.link" />
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <label for="cover" class="block text-sm font-medium text-gray-700 mb-2">
                                Link Gambar Cover
                            </label>
                            <input
                                id="cover"
                                v-model="form.cover"
                                type="url"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="https://example.com/cover.jpg (opsional)"
                            />
                            <p class="mt-1 text-sm text-gray-500">
                                Link gambar cover buku (opsional). Jika tidak diisi, akan menggunakan cover default.
                            </p>
                            <InputError class="mt-2" :message="form.errors.cover" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <Link :href="route('dashboard')" class="btn-outline">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                                Kembali
                            </Link>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="btn-primary-gradient disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span v-if="form.processing" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Mengupload...
                                </span>
                                <span v-else class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Upload Buku
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Guidelines -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">Panduan Upload Buku</h3>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Pastikan buku yang diupload adalah cerita anak yang sesuai untuk umur target</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Link buku harus dapat diakses publik (Google Drive, Dropbox, atau hosting lainnya)</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Buku akan direview oleh admin sebelum ditampilkan di website</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Pastikan Anda memiliki hak untuk membagikan buku tersebut</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
    categories: Array
})

const form = useForm({
    judul: '',
    pengarang: '',
    sinopsis: '',
    category_id: '',
    link: '',
    cover: '',
    age_min: 3,
    age_max: 12
})

const submitForm = () => {
    form.post(route('books.store'), {
        onSuccess: () => {
            // Success will redirect automatically
        }
    })
}
</script>
