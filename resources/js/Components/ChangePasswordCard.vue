<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const showForm = ref(false);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showForm.value = false;
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.focus();
            }
        },
    });
};

const toggleForm = () => {
    showForm.value = !showForm.value;
    if (!showForm.value) {
        form.reset();
    }
};
</script>

<template>
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-lg shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Ganti Password</h3>
                        <p class="text-sm text-gray-600">Perbarui password untuk keamanan akun</p>
                    </div>
                </div>
                <button
                    @click="toggleForm"
                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center text-sm"
                    :class="showForm ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-primary-500 hover:bg-primary-600 text-white'"
                >
                    <svg v-if="!showForm" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    <svg v-else class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    {{ showForm ? 'Tutup' : 'Ubah Password' }}
                </button>
            </div>

            <!-- Success Message -->
            <div v-if="form.recentlySuccessful" class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Password berhasil diperbarui!
                </div>
            </div>

            <!-- Change Password Form -->
            <div v-show="showForm" class="mt-6">
                <form @submit.prevent="updatePassword" class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password Saat Ini
                        </label>
                        <input
                            id="current_password"
                            ref="currentPasswordInput"
                            v-model="form.current_password"
                            type="password"
                            class="form-input w-full"
                            autocomplete="current-password"
                            placeholder="Masukkan password saat ini"
                            required
                        />
                        <div v-if="form.errors.current_password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.current_password }}
                        </div>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password Baru
                        </label>
                        <input
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="form-input w-full"
                            autocomplete="new-password"
                            placeholder="Masukkan password baru"
                            required
                        />
                        <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password Baru
                        </label>
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="form-input w-full"
                            autocomplete="new-password"
                            placeholder="Konfirmasi password baru"
                            required
                        />
                        <div v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password_confirmation }}
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button
                            type="button"
                            @click="toggleForm"
                            class="px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-all duration-200"
                            :disabled="form.processing"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-medium transition-all duration-200 flex items-center"
                            :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                            :disabled="form.processing"
                        >
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ form.processing ? 'Mengubah...' : 'Ubah Password' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>