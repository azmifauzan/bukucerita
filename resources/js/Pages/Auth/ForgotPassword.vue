<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Lupa Password - Buku Cerita" />
    
    <PublicLayout>
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        Lupa Password
                    </h1>
                    <p class="text-xl text-gray-600">
                        Kami akan mengirimkan link reset password ke email Anda
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="py-16 bg-white">
            <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Icon -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full shadow-lg mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>

                <!-- Info Text -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-800 text-center">
                        Lupa Password? Tidak masalah! Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
                    </p>
                </div>

                <!-- Success Message -->
                <div v-if="status" class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-800 text-center">
                        {{ status }}
                    </p>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email
                            </label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Masukkan email Anda"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full btn-primary-gradient py-3 text-base font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="!form.processing">Kirim Link Reset Password</span>
                            <span v-else class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mengirim...
                            </span>
                        </button>

                        <!-- Back to Login Link -->
                        <div class="text-center">
                            <Link 
                                :href="route('login')" 
                                class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-200 inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali ke halaman login
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
