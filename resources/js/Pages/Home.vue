<template>
    <Head title="Form Builder" />
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('home')" class="text-xl font-semibold text-gray-800">
                            Form Builder
                        </Link>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link v-if="!$page.props.auth.user" :href="route('login')"
                            class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900">
                            Login
                        </Link>
                        <Link v-if="!$page.props.auth.user" :href="route('register')"
                            class="px-4 py-2 text-sm text-white bg-gray-900 rounded-md hover:bg-gray-800">
                            Register
                        </Link>
                        <Link v-else :href="route('forms.index')"
                            class="px-4 py-2 text-sm text-white bg-gray-900 rounded-md hover:bg-gray-800">
                            Dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="py-16">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900">
                        Form Builder
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Create and manage custom forms with ease
                    </p>
                    <div class="flex justify-center mt-8 space-x-4">
                        <Link v-if="!$page.props.auth.user" :href="route('register')"
                            class="px-6 py-2 text-sm text-white bg-gray-900 rounded-md hover:bg-gray-800">
                            Get Started
                        </Link>
                        <Link v-else :href="route('forms.index')"
                            class="px-6 py-2 text-sm text-white bg-gray-900 rounded-md hover:bg-gray-800">
                            Dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="py-12 bg-white">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Form Creation -->
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900">Form Creation</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Build forms using drag and drop interface
                        </p>
                    </div>

                    <!-- Form Management -->
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900">Form Management</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Organize and manage your forms efficiently
                        </p>
                    </div>

                    <!-- Review forms -->
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900">Review Forms</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            review form submissions
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-500">
                        &copy; {{ new Date().getFullYear() }} Form Builder
                    </p>
                    <a href="https://github.com/AnikRifat/form_builder"
                       class="text-gray-400 hover:text-gray-600"
                       target="_blank"
                       rel="noopener noreferrer">
                        <span class="sr-only">GitHub</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>
