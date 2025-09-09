<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Daftar - Buku Cerita" />
    
    <PublicLayout>
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        Bergabung dengan Buku Cerita
                    </h1>
                    <p class="text-xl text-gray-600">
                        Buat akun untuk mulai membaca dan berbagi cerita anak
                    </p>
                </div>
            </div>
        </div>

        <!-- Register Form Section -->
        <div class="py-16 bg-white">
            <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Logo/Icon -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full shadow-lg mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
                </div>

                <!-- Register Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                autofocus
                                autocomplete="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Masukkan nama lengkap Anda"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                autocomplete="username"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Masukkan email Anda"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Minimal 8 karakter"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Ulangi password Anda"
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <!-- Terms and Privacy Policy -->
                        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="flex items-start">
                            <input
                                id="terms"
                                v-model="form.terms"
                                type="checkbox"
                                required
                                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded mt-1"
                            />
                            <div class="ml-3">
                                <label for="terms" class="text-sm text-gray-700">
                                    Saya menyetujui 
                                    <Link :href="route('terms.show')" 
                                          target="_blank" 
                                          class="text-orange-600 hover:text-orange-700 font-medium">
                                        Syarat & Ketentuan
                                    </Link>
                                    dan 
                                    <Link :href="route('policy.show')" 
                                          target="_blank" 
                                          class="text-orange-600 hover:text-orange-700 font-medium">
                                        Kebijakan Privasi
                                    </Link>
                                </label>
                                <InputError class="mt-2" :message="form.errors.terms" />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full btn-primary-gradient py-3 text-base font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="form.processing" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                            <span v-else>Daftar</span>
                        </button>

                        <!-- Link to Login -->
                        <div class="text-center">
                            <div class="text-sm text-gray-600">
                                Sudah punya akun?
                                <Link :href="route('login')" 
                                      class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-200">
                                    Masuk sekarang
                                </Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
