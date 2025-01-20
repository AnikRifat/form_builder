<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { Form, FormField } from '@/types/form'
import { router } from '@inertiajs/vue3'
import { useSortable } from '@vueuse/integrations/useSortable'

const props = defineProps<{
    form?: Form
}>()

const formData = ref<Form>(props.form || {
    title: '',
    description: '',
    method: 'POST',
    action: '/submit',
    is_active: true,
    fields: []
})

const fieldTypes = [
    { value: 'text', label: 'Text Input' },
    {value: 'email', label: 'Email Input' },
    { value: 'textarea', label: 'Text Area' },
    { value: 'select', label: 'Select' },
    { value: 'checkbox', label: 'Checkbox' },
    { value: 'radio', label: 'Radio Button' }
]

const addField = () => {
    formData.value.fields.push({
        type: 'text',
        name: `field_${formData.value.fields.length + 1}`,
        label: 'New Field',
        is_required: false,
        order: formData.value.fields.length
    })
}

const removeField = (index: number) => {
    formData.value.fields.splice(index, 1)
}

const saveForm = () => {
    if (formData.value.id) {
        router.put(`/api/forms/${formData.value.id}`, formData.value)
    } else {
        router.post('/api/forms', formData.value)
    }
}

// Drag and drop functionality
const fieldsContainer = ref<HTMLElement | null>(null)
useSortable(fieldsContainer, formData.value.fields, {
    handle: '.drag-handle',
    animation: 150,
    onUpdate: (e) => {
        formData.value.fields.forEach((field, index) => {
            field.order = index
        })
    }
})
</script>

<template>
    <div class="p-6">
        <h1 class="mb-6 text-2xl font-bold">
            {{ formData.id ? 'Edit Form' : 'Create Form' }}
        </h1>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Form Settings -->
            <div class="p-4 bg-white rounded-lg shadow">
                <h2 class="mb-4 text-lg font-semibold">Form Settings</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1">Title</label>
                        <input v-model="formData.title" type="text" class="w-full input">
                    </div>

                    <div>
                        <label class="block mb-1">Description</label>
                        <textarea v-model="formData.description" class="w-full input"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1">Method</label>
                        <select v-model="formData.method" class="w-full input">
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                            <option value="PUT">PUT</option>
                            <option value="PATCH">PATCH</option>
                            <option value="DELETE">DELETE</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1">Action URL</label>
                        <input v-model="formData.action" type="text" class="w-full input">
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input v-model="formData.is_active" type="checkbox" class="mr-2">
                            Active
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Fields -->
            <div class="p-4 bg-white rounded-lg shadow">
                <h2 class="mb-4 text-lg font-semibold">Form Fields</h2>

                <div ref="fieldsContainer" class="space-y-4">
                    <div v-for="(field, index) in formData.fields" :key="index" class="p-4 rounded border">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex gap-2 items-center">
                                <button class="cursor-move drag-handle">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                                <span class="font-medium">Field {{ index + 1 }}</span>
                            </div>
                            <button @click="removeField(index)" class="text-red-500 hover:text-red-700">
                                Remove
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block mb-1">Type</label>
                                <select v-model="field.type" class="w-full input">
                                    <option v-for="type in fieldTypes" :value="type.value">
                                        {{ type.label }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1">Label</label>
                                <input v-model="field.label" type="text" class="w-full input">
                            </div>

                            <div>
                                <label class="block mb-1">Name</label>
                                <input v-model="field.name" type="text" class="w-full input">
                            </div>

                            <div>
                                <label class="block mb-1">Placeholder</label>
                                <input v-model="field.placeholder" type="text" class="w-full input">
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input v-model="field.is_required" type="checkbox" class="mr-2">
                                    Required
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button @click="addField" class="mt-4 btn-primary">
                    Add Field
                </button>
            </div>
        </div>

        <div class="mt-6">
            <button @click="saveForm" class="btn-primary">
                Save Form
            </button>
        </div>
    </div>
</template>
