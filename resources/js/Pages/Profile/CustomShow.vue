<script setup>
import { Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <PublicLayout>
        <!-- Header Section -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">
                            Pengaturan Profil
                        </h1>
                        <p class="text-xl text-gray-600">
                            Kelola informasi akun dan keamanan Anda
                        </p>
                    </div>
                    <Link :href="route('dashboard')" class="btn-outline">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Kembali ke Dashboard
                    </Link>
                </div>
            </div>
        </div>

        <!-- Profile Settings Content -->
        <div class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Profile Information Card -->
                <div v-if="$page.props.jetstream.canUpdateProfileInformation" class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8">
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-lg shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Informasi Profil</h2>
                                <p class="text-gray-600">Perbarui informasi profil dan alamat email Anda</p>
                            </div>
                        </div>
                        <UpdateProfileInformationForm :user="$page.props.auth.user" />
                    </div>
                </div>

                <!-- Update Password Card -->
                <div v-if="$page.props.jetstream.canUpdatePassword" class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8">
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-lg shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Ubah Password</h2>
                                <p class="text-gray-600">Pastikan akun Anda menggunakan password yang kuat untuk keamanan</p>
                            </div>
                        </div>
                        <UpdatePasswordForm />
                    </div>
                </div>

                <!-- Two Factor Authentication Card -->
                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication" class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8">
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-3 rounded-lg shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-.257-.257A6 6 0 0118 8zM2 8a6 6 0 017.743 5.743L10 14l.257-.257A6 6 0 012 8zm8-4a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Autentikasi Dua Faktor</h2>
                                <p class="text-gray-600">Tambahkan keamanan ekstra pada akun Anda dengan autentikasi dua faktor</p>
                            </div>
                        </div>
                        <TwoFactorAuthenticationForm :requires-confirmation="confirmsTwoFactorAuthentication" />
                    </div>
                </div>

                <!-- Browser Sessions Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8">
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-lg shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v8a1 1 0 01-1 1h-5L9 15l-2-2H4a1 1 0 01-1-1V4zm8 7a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Sesi Browser</h2>
                                <p class="text-gray-600">Kelola dan logout sesi aktif Anda di browser atau perangkat lain</p>
                            </div>
                        </div>
                        <LogoutOtherBrowserSessionsForm :sessions="sessions" />
                    </div>
                </div>

                <!-- Delete Account Card -->
                <div v-if="$page.props.jetstream.hasAccountDeletionFeatures" class="bg-white rounded-xl shadow-lg border border-red-200">
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-red-500 to-red-600 p-3 rounded-lg shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 2a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Hapus Akun</h2>
                                <p class="text-gray-600">Hapus akun Anda secara permanen beserta semua data yang terkait</p>
                            </div>
                        </div>
                        <DeleteUserForm />
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
/* Custom styles for profile page */
.bg-white {
    background-color: white;
}
</style>