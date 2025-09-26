<script setup>
import { Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ChangePasswordCard from '@/Components/ChangePasswordCard.vue';
</script>

<template>
    <PublicLayout>
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        Selamat Datang, {{ $page.props.auth.user.name }}!
                    </h1>
                    <p class="text-xl text-gray-600">
                        Kelola koleksi buku dan terus berbagi cerita menarik
                    </p>
                </div>
            </div>
        </div>

        <!-- User Dashboard Content -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <!-- Upload Book -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-200 group">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="ml-4 text-lg font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">
                                Upload Buku Baru
                            </h3>
                        </div>
                        <p class="text-gray-600 mb-4">Bagikan cerita anak favorit Anda dengan pengguna lain</p>
                        <Link :href="route('books.create')" class="btn-primary-gradient inline-flex">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Upload
                        </Link>
                    </div>

                    <!-- My Books -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-200 group">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                            </div>
                            <h3 class="ml-4 text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                Buku Saya
                            </h3>
                        </div>
                        <p class="text-gray-600 mb-4">Kelola buku yang telah Anda upload</p>
                        <Link :href="route('books.index')" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            Lihat Koleksi
                        </Link>
                    </div>

                    <!-- Browse Books -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-200 group">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="ml-4 text-lg font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                                Jelajahi Buku
                            </h3>
                        </div>
                        <p class="text-gray-600 mb-4">Temukan cerita anak menarik dari pengguna lain</p>
                        <Link :href="route('books.index')" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                            Jelajahi
                        </Link>
                    </div>
                </div>

                <!-- Account Settings Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                    <!-- Change Password Card -->
                    <ChangePasswordCard />
                    
                    <!-- Profile Settings -->
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
                                        <h3 class="text-lg font-semibold text-gray-900">Profil Akun</h3>
                                        <p class="text-sm text-gray-600">Kelola informasi profil Anda</p>
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

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Aktivitas Terbaru</h2>
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                        <p>Belum ada aktivitas terbaru</p>
                        <p class="text-sm mt-2">Mulai dengan mengupload buku pertama Anda!</p>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
