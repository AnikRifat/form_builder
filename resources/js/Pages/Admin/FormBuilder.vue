<template>
    <div class="min-h-screen bg-gray-50">
        <AuthenticatedLayout>
            <template #header>
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">Form Builder</h1>
                    <div class="flex space-x-4">
                        <button type="button" @click="toggleJsonEditor"
                            class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-black rounded-lg shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            {{ isJsonEditorVisible ? 'Visual Editor' : 'JSON Editor' }}
                        </button>
                    </div>
                </div>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Form Configuration Section -->
                    <div v-if="!isJsonEditorVisible" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Form Title -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Form Title</label>
                                <input v-model="form.title" type="text"
                                    class="w-full px-4 py-2.5 text-gray-900 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Enter form title" />
                            </div>

                            <!-- Method Selection -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">HTTP Method</label>
                                <select v-model="form.method"
                                    class="w-full px-4 py-2.5 text-gray-900 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="GET">GET</option>
                                    <option value="POST">POST</option>
                                    <option value="PUT">PUT</option>
                                    <option value="DELETE">DELETE</option>
                                </select>
                            </div>

                            <!-- Form Action -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Form Action</label>
                                <input v-model="form.action" type="text"
                                    class="w-full px-4 py-2.5 text-gray-900 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Enter form action URL" />
                            </div>
                        </div>
                    </div>

                    <!-- Main Builder Section -->
                    <div class="grid grid-cols-12 gap-8">
                        <!-- Field Types Palette -->
                        <div class="col-span-12 md:col-span-3">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Field Types</h2>
                                <div class="space-y-3">
                                    <div v-for="field in fieldTypes" :key="field.type"
                                        :class="[
                                            'p-4 bg-white rounded-lg border-2 shadow-sm cursor-move transition-all duration-200',
                                            {
                                                'border-blue-200 hover:border-blue-500': field.type === 'text' || field.type === 'email' || field.type === 'radio',
                                                'border-green-200 hover:border-green-500': field.type === 'textarea' || field.type === 'checkbox',
                                                'border-black border-opacity-20 hover:border-black': field.type === 'select'
                                            }
                                        ]"
                                        draggable="true"
                                        @dragstart="onDragStart($event, field)"
                                        @dragend="onDragEnd">
                                        <div class="flex items-center space-x-3">
                                            <div :class="[
                                                'flex items-center justify-center w-10 h-10 rounded-lg',
                                                {
                                                    'bg-blue-50 text-blue-600': field.type === 'text' || field.type === 'email' || field.type === 'radio',
                                                    'bg-green-50 text-green-600': field.type === 'textarea' || field.type === 'checkbox',
                                                    'bg-black bg-opacity-5 text-black': field.type === 'select'
                                                }
                                            ]">
                                                <!-- Field Type Icons -->
                                                <svg v-if="field.type === 'text'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                                </svg>
                                                <svg v-if="field.type === 'email'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                </svg>
                                                <svg v-if="field.type === 'textarea'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm2-1h10a1 1 0 011 1v10a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" clip-rule="evenodd" />
                                                </svg>
                                                <svg v-if="field.type === 'select'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                <svg v-if="field.type === 'radio'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <svg v-if="field.type === 'checkbox'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="flex items-center space-x-2">
                                                    <h3 class="text-sm font-medium text-gray-900">{{ field.label }}</h3>
                                                    <span :class="[
                                                        'px-2 py-1 text-xs font-medium rounded-full',
                                                        {
                                                            'bg-blue-100 text-blue-700': field.type === 'text' || field.type === 'email',
                                                            'bg-green-100 text-green-700': field.type === 'textarea' || field.type === 'checkbox',
                                                            'bg-gray-100 text-gray-700': field.type === 'select',
                                                            'bg-blue-100 text-blue-700': field.type === 'radio'
                                                        }
                                                    ]">
                                                        {{ field.type }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500">Drag to add</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Preview -->
                        <div class="col-span-12 md:col-span-9">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Form Preview</h2>
                                <div class="space-y-4">
                                    <div class="form-fields-container space-y-4">
                                        <div v-for="(field, index) in form.fields" :key="field.id"
                                            :class="[
                                                'form-field p-6 bg-white rounded-lg border-2 shadow-sm transition-all duration-200',
                                                {
                                                    'border-blue-100 hover:border-blue-300': field.type === 'text' || field.type === 'email',
                                                    'border-green-100 hover:border-green-300': field.type === 'textarea',
                                                    'border-black border-opacity-10 hover:border-opacity-30': field.type === 'select',
                                                    'border-blue-100 hover:border-blue-300': field.type === 'radio',
                                                    'border-green-100 hover:border-green-300': field.type === 'checkbox'
                                                }
                                            ]"
                                            draggable="true"
                                            @dragstart="onDragStart($event, field)"
                                            @dragend="onDragEnd"
                                            @dragover.prevent="onDragOver($event, index)"
                                            @drop="onDrop($event, index)">
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex items-center space-x-3">
                                                    <!-- Drag Handle -->
                                                    <div class="cursor-move text-gray-400 hover:text-gray-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-8a2 2 0 1 0-.001-4.001A2 2 0 0 0 13 6zm0 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <h3 class="text-sm font-medium text-gray-900">{{ field.label }}</h3>
                                                        <span :class="[
                                                            'px-2 py-1 text-xs font-medium rounded-full',
                                                            {
                                                                'bg-blue-100 text-blue-700': field.type === 'text' || field.type === 'email',
                                                                'bg-green-100 text-green-700': field.type === 'textarea' || field.type === 'checkbox',
                                                                'bg-gray-100 text-gray-700': field.type === 'select',
                                                                'bg-blue-100 text-blue-700': field.type === 'radio'
                                                            }
                                                        ]">
                                                            {{ field.type }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <button @click="removeField(index)"
                                                        class="p-2 text-gray-400 hover:text-red-500 rounded-lg hover:bg-red-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Field Options -->
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-center space-x-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" v-model="field.is_required"
                                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                                        <span class="ml-2 text-sm text-gray-600">Required</span>
                                                    </label>
                                                </div>

                                                <input v-model="field.placeholder"
                                                    class="w-full px-4 py-2 text-sm border-2 border-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Placeholder text" />

                                                <!-- Options for select/radio/checkbox -->
                                                <div v-if="['select', 'radio', 'checkbox'].includes(field.type)" class="space-y-2">
                                                    <div v-for="(option, optionIndex) in field.options" :key="optionIndex"
                                                        class="flex items-center space-x-2">
                                                        <input v-model="option.value"
                                                            class="flex-1 px-4 py-2 text-sm border-2 border-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                            placeholder="Option value" />
                                                        <button @click="field.options.splice(optionIndex, 1)"
                                                            class="p-2 text-gray-400 hover:text-red-500 rounded-lg hover:bg-red-50">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <button @click="field.options.push({ value: '' })"
                                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 01-1 1h-3a1 1 0 110-2h3V8a1 1 0 011-1V6a1 1 0 110-2h-3a1 1 0 010-2h3V5z" clip-rule="evenodd" />
                                                        </svg>
                                                        Add Option
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Empty State -->
                                        <div v-if="!form.fields.length"
                                            class="p-12 text-center border-2 border-dashed border-gray-300 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No fields added</h3>
                                            <p class="mt-1 text-sm text-gray-500">Drag fields from the palette to start building your form</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 flex justify-end">
                        <button @click="saveForm"
                            class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Save Form
                        </button>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup lang="ts">
import { ref, defineProps, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TrashIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { Form, FormField } from '@/types/form';

interface Props {
    form: Form;
}

const props = defineProps<Props>();

const fieldTypes = [
    { type: 'text', label: 'Text Input' },
    { type: 'email', label: 'Email Input' },
    { type: 'textarea', label: 'Text Area' },
    { type: 'select', label: 'Select Box' },
    { type: 'checkbox', label: 'Checkbox' },
    { type: 'radio', label: 'Radio Button' },
];

const form = ref<Form>(props.form);

// Initialize form fields if empty
if (!form.value.fields) {
    form.value.fields = [];
}

watch(() => props.form, (newForm) => {
    form.value = newForm || {
        title: '',
        description: '',
        method: '',
        action: '',
        is_active: true,
        fields: []
    };

    // Ensure fields array exists
    form.value.fields = form.value.fields || [];

    // Initialize showOptions for each field
    form.value.fields.forEach(field => {
        field.showOptions = Boolean(field.options?.length);
    });
}, { immediate: true });

const isJsonEditorVisible = ref(false);

const toggleJsonEditor = () => {
    isJsonEditorVisible.value = !isJsonEditorVisible.value;
    if (isJsonEditorVisible.value) {
        showJsonConfig();
    }
};

const jsonConfig = ref('');
const jsonError = ref('');

const showJsonConfig = () => {
    const { id, created_at, updated_at, deleted_at, ...formWithoutTimestamps } = form.value;
    const fieldsWithoutTimestamps = formWithoutTimestamps.fields.map(field => {
        const { id, created_at, updated_at, deleted_at, form_id, ...fieldWithoutTimestamps } = field;
        return fieldWithoutTimestamps;
    });
    jsonConfig.value = JSON.stringify({ ...formWithoutTimestamps, fields: fieldsWithoutTimestamps }, null, 2);
};

const resetJsonConfig = () => {
    showJsonConfig();
};

watch(jsonConfig, (newJson) => {
    try {
        const newForm = JSON.parse(newJson);
        form.value = {
            ...newForm,
            id: form.value.id,
            created_at: form.value.created_at,
            updated_at: form.value.updated_at,
        };
        form.value.fields = form.value.fields.map((field, index) => ({
            ...field,
            id: newForm.fields[index]?.id || field.id,
        }));
        jsonError.value = '';
    } catch (error) {
        jsonError.value = 'Invalid JSON configuration';
    }
});

const draggedField = ref(null);
const draggedIndex = ref(-1);

const onDragStart = (event: DragEvent, field: { type: string } | FormField) => {
    if ('name' in field) {
        // Reordering existing field
        draggedField.value = field;
        draggedIndex.value = form.value.fields.indexOf(field);
        event.dataTransfer?.setData('action', 'reorder');
    } else {
        // Adding new field
        draggedField.value = { type: field.type };
        draggedIndex.value = -1;
        event.dataTransfer?.setData('action', 'add');
    }
};

const updateFieldOrders = () => {
    form.value.fields.forEach((field, index) => {
        field.order = index + 1;
    });
};

const createNewField = (type: string): FormField => {
    return {
        type,
        name: `field_${Date.now()}`,
        label: `New ${type.charAt(0).toUpperCase() + type.slice(1)} Field`,
        placeholder: '',
        is_required: false,
        options: (type === 'select' || type === 'radio') ? [{ value: 'Option 1' }] : undefined,
        order: form.value.fields.length + 1,
        showOptions: type === 'select' || type === 'radio'
    };
};

const onDrop = (event: DragEvent, targetIndex: number) => {
    event.preventDefault();
    const action = event.dataTransfer?.getData('action');

    if (!draggedField.value) return;

    if (action === 'reorder' && draggedIndex.value !== -1) {
        // Remove the field from its original position
        form.value.fields.splice(draggedIndex.value, 1);

        // Adjust target index if needed
        const adjustedIndex = targetIndex > draggedIndex.value ? targetIndex - 1 : targetIndex;

        // Insert the field at the new position
        form.value.fields.splice(adjustedIndex, 0, draggedField.value);
    } else if (action === 'add' && draggedField.value.type) {
        const newField = createNewField(draggedField.value.type);
        form.value.fields.splice(targetIndex, 0, newField);
    }

    // Reset drag state
    draggedField.value = null;
    draggedIndex.value = -1;

    // Update field orders
    updateFieldOrders();
};

const onDragEnd = () => {
    draggedField.value = null;
    draggedIndex.value = -1;
};

const onDragOver = (event: DragEvent) => {
    event.preventDefault();
};

const removeField = (index: number) => {
    form.value.fields.splice(index, 1);
    updateFieldOrders();
};

const saveForm = async () => {
    if (!form.value.title) {
        alert('Please enter a form title');
        return;
    }

    // Sanitize and validate field names
    for (const field of form.value.fields) {
        field.name = sanitizeFieldName(field.name);
        if (!field.name || !/^[a-zA-Z_][a-zA-Z0-9_]*$/.test(field.name)) {
            alert(`Invalid field name: ${field.name}. Field names must start with a letter or underscore and contain only letters, numbers, and underscores.`);
            return;
        }
    }

    // Check for duplicate field names
    const fieldNames = new Set();
    for (const field of form.value.fields) {
        if (fieldNames.has(field.name)) {
            alert(`Duplicate field name: ${field.name}. Field names must be unique.`);
            return;
        }
        fieldNames.add(field.name);
    }

    try {
        const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
        const url = form.value.id
            ? route('forms.update', { form: form.value.id })
            : route('forms.store');

        await router[form.value.id ? 'put' : 'post'](url, {
            ...form.value,
            fields: form.value.fields.map(field => ({
                ...field
            }))
        }, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
    } catch (error) {
        console.error('Error saving form:', error);
    }
};

const sanitizeFieldName = (fieldName: string): string => {
    return fieldName.replace(/[^a-zA-Z0-9_]/g, '_');
};
</script>

<style scoped>
/* Drag and drop styling */
[draggable="true"] {
    cursor: move;
}

.dragging {
    opacity: 0.5;
}

/* Transitions */
.transition-all {
    transition: all 0.2s ease-in-out;
}

/* Hover effects */
.hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Input focus styles */
input:focus, select:focus {
    outline: none;
    border-color: #3B82F6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Field type-specific styles */
.field-text, .field-email {
    @apply border-blue-200;
}

.field-textarea, .field-checkbox {
    @apply border-green-200;
}

.field-select {
    @apply border-black border-opacity-20;
}

/* Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.field-enter-active {
    animation: slideIn 0.3s ease-out;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #666;
}

/* Drag and drop styles */
.form-field {
    cursor: move;
    user-select: none;
}

.form-field.dragging {
    opacity: 0.5;
    background: #f8fafc;
    border: 2px dashed #94a3b8;
}

.form-fields-container {
    min-height: 100px;
}

/* Drag handle hover effect */
.cursor-move {
    transition: all 0.2s ease;
}

.cursor-move:hover {
    transform: scale(1.1);
}
</style>
