<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Form Builder - Home" />
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-indigo-600">FormBuilder</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- GitHub Link -->
                        <a href="https://github.com/AnikRifat/form_builder" target="_blank" class="text-gray-600 hover:text-gray-900">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        <!-- Auth Links -->
                        <template v-if="canLogin">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="btn-primary">
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link :href="route('login')" class="btn-secondary">Log in</Link>
                                <Link v-if="canRegister" :href="route('register')" class="btn-primary">Register</Link>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="py-20 bg-gradient-to-r from-indigo-500 to-purple-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl">
                        Build Beautiful Forms
                        <span class="block text-indigo-200">Without Writing Code</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-indigo-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Create, customize, and deploy forms in minutes. Perfect for surveys, registrations, feedback, and more.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <Link :href="route('register')" class="btn-primary text-lg px-8 py-3">
                            Get Started Free
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Everything You Need to Build Amazing Forms
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Our form builder comes packed with features to help you create any type of form.
                    </p>
                </div>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center text-white mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Easy to Use</h3>
                        <p class="mt-2 text-gray-600">Drag and drop interface makes form creation simple and intuitive.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center text-white mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Customizable</h3>
                        <p class="mt-2 text-gray-600">Multiple field types and styling options to match your brand.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center text-white mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Secure</h3>
                        <p class="mt-2 text-gray-600">Built with security in mind, protecting your data and your users.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-indigo-700">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    <span class="block">Ready to dive in?</span>
                    <span class="block text-indigo-200">Start building your forms today.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <Link :href="route('register')" class="btn-white">
                            Get Started
                        </Link>
                    </div>
                    <div class="ml-3 inline-flex rounded-md shadow">
                        <a href="https://github.com/AnikRifat/form_builder" class="btn-secondary">
                            View on GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
                <div class="flex justify-center space-x-6 md:order-2">
                    <a href="https://github.com/AnikRifat/form_builder" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">GitHub</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-400">
                        &copy; {{ new Date().getFullYear() }} FormBuilder. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.btn-primary {
    @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
}

.btn-secondary {
    @apply inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
}

.btn-white {
    @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
}
</style>
