<template>
    <div>
        <AuthenticatedLayout>
            <template #header>
                <div class="py-12 min-h-screen bg-gray-50">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="overflow-hidden bg-white shadow-xl sm:rounded-2xl">
                            <div class="p-8 bg-white">
                                <div class="flex justify-end mt-4 space-x-4">
                                    <button type="button" @click="toggleJsonEditor"
                                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-green-500 rounded-md border border-transparent transition hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 disabled:opacity-25">
                                        {{ isJsonEditorVisible ? 'Edit Manually' : 'Configure JSON' }}
                                    </button>
                                </div>
                                <h1 class="mb-8 text-3xl font-bold text-gray-900">Form Builder</h1>

                                <div v-if="!isJsonEditorVisible" class="mb-6 space-y-4">
                                    <div class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm">
                                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                            <!-- Form Title -->
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Form Title
                                                </label>
                                                <div class="relative">
                                                    <input v-model="form.title" type="text"
                                                        class="px-4 py-2.5 w-full text-sm placeholder-gray-400 rounded-lg border border-gray-200 backdrop-blur-sm transition-all duration-200 bg-white/50 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                                                        placeholder="Enter form title" required />
                                                </div>
                                            </div>

                                            <!-- Method Selection -->
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Method
                                                </label>
                                                <select v-model="form.method"
                                                    class="px-4 py-2.5 w-full text-sm rounded-lg border border-gray-200 backdrop-blur-sm transition-all duration-200 bg-white/50 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                                                    required>
                                                    <option value="GET">GET</option>
                                                    <option value="POST">POST</option>
                                                    <option value="PUT">PUT</option>
                                                    <option value="DELETE">DELETE</option>
                                                </select>
                                            </div>

                                            <!-- Form Action URL -->
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Form Action
                                                </label>
                                                <div class="relative">
                                                    <input v-model="form.action" type="text"
                                                        class="px-4 py-2.5 w-full text-sm placeholder-gray-400 rounded-lg border border-gray-200 backdrop-blur-sm transition-all duration-200 bg-white/50 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                                                        placeholder="Enter url for action" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="!isJsonEditorVisible" class="grid grid-cols-12 gap-6">
                                    <!-- Field Palette -->
                                    <div class="col-span-3">
                                        <div class="space-y-4">
                                            <div v-for="field in fieldTypes" :key="field.type"
                                                class="p-4 bg-white rounded-lg shadow-sm transition-all duration-200 cursor-move hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5 hover:scale-105"
                                                draggable="true" @dragstart="onDragStart($event, field)">
                                                <div class="flex items-center space-x-3">
                                                    <div
                                                        class="flex justify-center items-center w-8 h-8 bg-blue-50 rounded-lg">

                                                        <svg v-if="field.type === 'email'"
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-envelope"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                                        </svg>

                                                        <svg v-if="field.type === 'checkbox'"
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-check2-square"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                                            <path
                                                                d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                                            <path
                                                                d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                                                        </svg>

                                                        <svg v-if="field.type === 'textarea'"
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-textarea-resize"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M0 4.5A2.5 2.5 0 0 1 2.5 2h11A2.5 2.5 0 0 1 16 4.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 11.5zM2.5 3A1.5 1.5 0 0 0 1 4.5v7A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 13.5 3zm10.854 4.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0m0 2.5a.5.5 0 0 1 0 .708l-.5.5a.5.5 0 0 1-.708-.708l.5-.5a.5.5 0 0 1 .708 0" />
                                                        </svg>

                                                        <svg v-if="field.type === 'radio'"
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-check2-circle"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                                            <path
                                                                d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                                        </svg>

                                                        <svg v-if="field.type === 'select'"
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-check-all"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z" />
                                                        </svg>

                                                        <svg v-if="field.type === 'text'"
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-card-text"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                                            <path
                                                                d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8m0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5" />
                                                        </svg>

                                                    </div>
                                                    <span class="text-sm font-medium text-gray-700">{{ field.label
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Canvas -->
                                    <div class="col-span-9">
                                        <div class="p-6 border border-dashed border-gray-300 rounded-lg min-h-[400px]"
                                            @drop="onDrop($event, form.fields.length)" @dragover.prevent
                                            @dragenter.prevent>
                                            <div v-for="(field, index) in form.fields" :key="index"
                                                class="relative mb-4 bg-white rounded-lg border border-gray-200 transition-all duration-200 hover:border-blue-200"
                                                draggable="true" @dragstart="onDragStart($event, field)"
                                                @dragover.prevent @drop="onDrop($event, index)">

                                                <!-- Simple Header with Drag Handle and Type -->
                                                <div
                                                    class="flex justify-between items-center p-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                                    <div class="flex gap-3 items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                            fill="currentColor" class="text-gray-400 cursor-move"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2m0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2m3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2m0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2m3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2m0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2m3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2m0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2m3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2m0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                                        </svg>
                                                        <span class="text-sm font-medium text-gray-600">{{ field.type
                                                            }}</span>
                                                    </div>
                                                    <div class="flex gap-2 items-center">
                                                        <button v-if="['select', 'radio'].includes(field.type)"
                                                            @click="field.showOptions = !field.showOptions"
                                                            class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100">
                                                            {{ field.showOptions ? 'Hide' : 'Edit' }} Options
                                                        </button>
                                                        <button @click="removeField(index)"
                                                            class="p-1.5 text-gray-400 rounded hover:text-red-500">
                                                            <TrashIcon class="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Form Content -->
                                                <div class="p-4">
                                                    <div class="grid gap-4">
                                                        <div class="flex gap-4 items-center">
                                                            <div class="flex-1">
                                                                <label
                                                                    class="block mb-1 text-sm font-medium text-gray-600">Field
                                                                    Name</label>
                                                                <input v-model="field.name" type="text"
                                                                    class="px-3 py-2 w-full text-sm rounded border border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-100"
                                                                    placeholder="Enter field name" required />
                                                            </div>
                                                            <div class="flex-1">
                                                                <label
                                                                    class="block mb-1 text-sm font-medium text-gray-600">Field
                                                                    Label</label>
                                                                <input v-model="field.label" type="text"
                                                                    class="px-3 py-2 w-full text-sm rounded border border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-100"
                                                                    placeholder="Enter field label" required />
                                                            </div>
                                                        </div>

                                                        <div class="flex gap-4 items-start">
                                                            <div class="flex-1">
                                                                <label
                                                                    class="block mb-1 text-sm font-medium text-gray-600">Placeholder</label>
                                                                <input v-model="field.placeholder" type="text"
                                                                    class="px-3 py-2 w-full text-sm rounded border border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-100"
                                                                    placeholder="Enter placeholder text" />
                                                            </div>
                                                            <div class="pt-6">
                                                                <label class="inline-flex items-center">
                                                                    <input v-model="field.is_required" type="checkbox"
                                                                        class="w-4 h-4 text-blue-500 rounded border-gray-300 focus:ring-blue-200" />
                                                                    <span
                                                                        class="ml-2 text-sm text-gray-600">Required</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- Options Section -->
                                                        <div v-if="['select', 'radio'].includes(field.type) && field.showOptions"
                                                            class="pt-4 mt-2 border-t border-gray-100">
                                                            <div v-for="(option, optionIndex) in field.options"
                                                                :key="optionIndex" class="flex gap-2 items-center mb-2">
                                                                <input v-model="option.value" type="text"
                                                                    class="flex-1 px-3 py-1.5 text-sm rounded border border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-100"
                                                                    placeholder="Option value" />
                                                                <button @click="field.options.splice(optionIndex, 1)"
                                                                    class="p-1.5 text-gray-400 rounded hover:text-red-500">
                                                                    <TrashIcon class="w-4 h-4" />
                                                                </button>
                                                            </div>
                                                            <button @click="field.options.push({ value: '' })"
                                                                class="inline-flex items-center px-3 py-1.5 mt-2 text-sm text-blue-600 bg-blue-50 rounded hover:bg-blue-100">
                                                                <PlusIcon class="mr-1.5 w-3 h-3" />
                                                                Add Option
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="flex justify-end mt-6 space-x-4">
                                    <button type="button" @click="saveForm"
                                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-blue-500 rounded-md border border-transparent transition hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25">
                                        Save Form
                                    </button>
                                </div>

                                <div v-if="isJsonEditorVisible" class="mt-4">
                                    <textarea v-model="jsonConfig" class="p-4 w-full bg-gray-100 rounded"
                                        rows="20"></textarea>
                                    <div class="flex justify-end mt-4 space-x-4">
                                        <button @click="resetJsonConfig"
                                            class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Reset</button>
                                    </div>
                                    <div v-if="jsonError" class="mt-4 text-red-500">{{ jsonError }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
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

const getFieldComponent = (type: string) => {
    switch (type) {
        case 'text':
        case 'email':
            return 'TextInput';
        case 'textarea':
            return 'Textarea';
        case 'select':
            return 'Select';
        case 'checkbox':
            return 'Checkbox';
        case 'radio':
            return 'Radio';
        default:
            return 'TextInput';
    }
};

const onDragStart = (event: DragEvent, field: { type: string } | FormField) => {
    if ('name' in field) {
        // This is a FormField being reordered
        event.dataTransfer?.setData('fieldIndex', form.value.fields.indexOf(field).toString());
        event.dataTransfer?.setData('action', 'reorder');
    } else {
        // This is a field type being added
        event.dataTransfer?.setData('fieldType', field.type);
        event.dataTransfer?.setData('action', 'add');
    }
};

const updateFieldOrders = () => {
    form.value.fields.forEach((field, index) => {
        field.order = index + 1;
    });
};

const onDrop = (event: DragEvent, targetIndex: number) => {
    const action = event.dataTransfer?.getData('action');

    if (action === 'reorder') {
        const sourceIndex = parseInt(event.dataTransfer?.getData('fieldIndex') || '-1');
        if (sourceIndex >= 0 && sourceIndex !== targetIndex) {
            const [movedField] = form.value.fields.splice(sourceIndex, 1);
            form.value.fields.splice(targetIndex, 0, movedField);
            updateFieldOrders(); // Update order after reordering
        }
    } else if (action === 'add') {
        const fieldType = event.dataTransfer?.getData('fieldType');
        if (fieldType) {
            addField(fieldType);
            updateFieldOrders(); // Update order after adding
        }
    }
};

const addField = (type: string) => {
    const newField: FormField = {
        type,
        name: `field_${form.value.fields.length + 1}`,
        label: 'New Field',
        placeholder: '',
        is_required: false,
        options: (type === 'select' || type === 'radio') ? [] : undefined,
        order: form.value.fields.length + 1,
        showOptions: type === 'select' || type === 'radio'
    };
    form.value.fields.push(newField);
    updateFieldOrders();
};

const removeField = (index: number) => {
    form.value.fields.splice(index, 1);
    updateFieldOrders(); // Update order after removing
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
