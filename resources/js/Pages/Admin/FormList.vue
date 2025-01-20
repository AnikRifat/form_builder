<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Form } from '@/types/form'
import { router } from '@inertiajs/vue3'

const forms = ref<Form[]>([])

onMounted(async () => {
    const response = await fetch('/api/forms')
    forms.value = await response.json()
})

const deleteForm = (form: Form) => {
    if (confirm('Are you sure you want to delete this form?')) {
        router.delete(`/api/forms/${form.id}`)
    }
}
</script>

<template>
    <div class="p-6">
        <h1 class="mb-6 text-2xl font-bold">Forms</h1>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div v-for="form in forms" :key="form.id" class="p-4 bg-white rounded-lg shadow">
                <h2 class="text-lg font-semibold">{{ form.title }}</h2>
                <p class="mt-2 text-gray-600">{{ form.description }}</p>

                <div class="flex gap-2 mt-4">
                    <a :href="`/admin/forms/${form.id}`" class="btn-primary">
                        Edit
                    </a>
                    <button @click="deleteForm(form)" class="btn-danger">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
