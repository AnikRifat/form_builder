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
                                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-black rounded-md border border-transparent transition hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-200 disabled:opacity-25">
                                        {{ isJsonEditorVisible ? 'Edit Manually' : 'Configure JSON' }}
                                    </button>
                                    <Link :href="route('forms.index')"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-300 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Back to Forms
                                    </Link>
                                </div>
                                <h1 class="mb-8 text-3xl font-bold text-gray-900">Form Builder</h1>

                                <Transition name="fade" mode="out-in">
                                    <div v-if="!isJsonEditorVisible" class="mb-6 space-y-4">
                                        <div class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm">
                                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                                <!-- Form Title -->
                                                <div class="space-y-2">
                                                    <label class="block text-sm font-medium text-gray-700">Form
                                                        Title</label>
                                                    <input v-model="form.title" type="text"
                                                        class="px-4 py-2.5 w-full text-gray-900 rounded-lg border-2 border-gray-200 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        placeholder="Enter form title" />
                                                </div>

                                                <!-- Method Selection -->
                                                <div class="space-y-2">
                                                    <label class="block text-sm font-medium text-gray-700">HTTP
                                                        Method</label>
                                                    <select v-model="form.method"
                                                        class="px-4 py-2.5 w-full text-gray-900 rounded-lg border-2 border-gray-200 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                        <option value="GET">GET</option>
                                                        <option value="POST">POST</option>
                                                        <option value="PUT">PUT</option>
                                                        <option value="DELETE">DELETE</option>
                                                    </select>
                                                </div>

                                                <!-- Form Action -->
                                                <div class="space-y-2">
                                                    <label class="block text-sm font-medium text-gray-700">Form
                                                        Action</label>
                                                    <input v-model="form.action" type="text"
                                                        class="px-4 py-2.5 w-full text-gray-900 rounded-lg border-2 border-gray-200 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        placeholder="Enter form action URL" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </Transition>

                                <Transition name="fade" mode="out-in">
                                    <div v-if="!isJsonEditorVisible" class="grid grid-cols-12 gap-8">
                                        <!-- Field Types Palette -->
                                        <div class="col-span-12 md:col-span-3">
                                            <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
                                                <h2 class="mb-4 text-lg font-semibold text-gray-900">Field Types</h2>
                                                <div class="space-y-3">
                                                    <div v-for="field in fieldTypes" :key="field.type" :class="[
                                                        'p-4 bg-white rounded-lg border-2 shadow-sm cursor-move transition-all duration-200 form-field',
                                                    ]" :data-type="field.type" draggable="true"
                                                        @dragstart="onDragStart($event, { type: field.type, label: field.label })"
                                                        @dragend="onDragEnd">
                                                        <div class="flex items-center space-x-3">
                                                            <div
                                                                class="flex justify-center items-center w-10 h-10 rounded-lg field-icon">
                                                                <!-- Field Type Icons -->
                                                                <svg v-if="field.type === 'text'"
                                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path
                                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                                                </svg>
                                                                <svg v-if="field.type === 'email'"
                                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path
                                                                        d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                                    <path
                                                                        d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                                </svg>
                                                                <svg v-if="field.type === 'textarea'"
                                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm2-1h10a1 1 0 011 1v10a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <svg v-if="field.type === 'select'"
                                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 3a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 01-1 1h-3a1 1 0 110-2h3V8a1 1 0 011-1V4a1 1 0 110-2h-3a1 1 0 010-2h3V5z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <svg v-if="field.type === 'radio'"
                                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <svg v-if="field.type === 'checkbox'"
                                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <div class="flex items-center space-x-2">
                                                                    <h3 class="text-sm font-medium text-gray-900">{{
                                                                        field.label }}</h3>
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium rounded-full field-badge">
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
                                            <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
                                                <h2 class="mb-4 text-lg font-semibold text-gray-900">Form Preview</h2>
                                                <TransitionGroup name="form-fields" tag="div"
                                                    class="space-y-4 min-h-[200px]" @dragover.prevent
                                                    @drop.prevent="onDrop($event, form.fields.length)">
                                                    <div v-for="(field, index) in form.fields" :key="field.id" :class="[
                                                        'form-field p-6 bg-white rounded-lg border-2 shadow-sm transition-all duration-200',
                                                        {
                                                            'dragging': draggedField?.id === field.id,
                                                            'is-over': dragOverIndex === index
                                                        }
                                                    ]" :data-type="field.type" draggable="true"
                                                        @dragstart="onDragStart($event, { type: field.type, label: field.label })"
                                                        @dragend="onDragEnd"
                                                        @dragover.prevent="onDragOver($event, index)" @dragenter.prevent
                                                        @drop.prevent="onDrop($event, index)">
                                                        <div class="flex justify-between items-start mb-4">
                                                            <div class="flex items-center space-x-3">
                                                                <!-- Drag Handle -->
                                                                <div
                                                                    class="text-gray-400 cursor-move hover:text-gray-600">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="w-5 h-5" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-8a2 2 0 1 0-.001-4.001A2 2 0 0 0 13 6zm0 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z" />
                                                                    </svg>
                                                                </div>
                                                                <div class="flex items-center space-x-2">
                                                                    <h3 class="text-sm font-medium text-gray-900">{{
                                                                        field.label }}</h3>
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium rounded-full field-badge">
                                                                        {{ field.type }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center space-x-2">
                                                                <button @click="removeField(index)"
                                                                    class="p-2 text-red-400 rounded-lg hover:text-red-500 hover:bg-red-50">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="w-5 h-5" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Field Options -->
                                                        <div class="mt-4 space-y-4">
                                                            <div class="flex items-center space-x-4">
                                                                <label class="inline-flex items-center">
                                                                    <input type="checkbox" v-model="field.is_required"
                                                                        class="text-blue-600 rounded border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                                                    <span
                                                                        class="ml-2 text-sm text-gray-600">Required</span>
                                                                </label>
                                                            </div>

                                                            <input v-model="field.placeholder"
                                                                class="px-4 py-2 w-full text-sm rounded-lg border-2 border-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                placeholder="Placeholder text" />

                                                            <!-- Options for select/radio/checkbox -->
                                                            <div v-if="['select', 'radio', 'checkbox'].includes(field.type)"
                                                                class="space-y-2">
                                                                <div v-for="(option, optionIndex) in field.options"
                                                                    :key="optionIndex"
                                                                    class="flex items-center space-x-2">
                                                                    <input v-model="option.value"
                                                                        class="flex-1 px-4 py-2 text-sm rounded-lg border-2 border-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                        placeholder="Option value" />
                                                                    <button
                                                                        @click="field.options.splice(optionIndex, 1)"
                                                                        class="p-2 text-gray-400 rounded-lg hover:text-red-500 hover:bg-red-50">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="w-5 h-5" viewBox="0 0 20 20"
                                                                            fill="currentColor">
                                                                            <path fill-rule="evenodd"
                                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <button @click="field.options.push({ value: '' })"
                                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="mr-2 w-5 h-5" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 01-1 1h-3a1 1 0 110-2h3V8a1 1 0 011-1V6a1 1 0 110-2h-3a1 1 0 010-2h3V5z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                    Add Option
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Empty State -->
                                                    <div v-if="!form.fields.length"
                                                        class="p-12 text-center rounded-lg border-2 border-gray-300 border-dashed"
                                                        @dragover.prevent @drop.prevent="onDrop($event, 0)">
                                                        <p class="text-gray-500">Drag and drop fields here to start
                                                            building your form</p>
                                                    </div>
                                                </TransitionGroup>
                                            </div>
                                        </div>
                                    </div>
                                </Transition>

                                <div class="flex justify-end mt-6 space-x-4">
                                    <button type="button" @click="saveForm"
                                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-blue-500 rounded-md border border-transparent transition hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25">
                                        Save Form
                                    </button>
                                </div>

                                <Transition name="fade" mode="out-in">
                                    <div v-if="isJsonEditorVisible" class="mt-4">
                                        <textarea v-model="jsonConfig" class="p-4 w-full bg-gray-100 rounded"
                                            rows="20"></textarea>
                                        <div class="mt-4 space-y-2">
                                            <div v-if="jsonError"
                                                class="p-3 text-sm text-red-700 bg-red-50 rounded-md border border-red-200">
                                                <strong class="font-medium">Error:</strong> {{ jsonError }}
                                            </div>
                                            <div v-if="jsonWarnings.length > 0"
                                                class="p-3 text-sm text-yellow-700 bg-yellow-50 rounded-md border border-yellow-200">
                                                <strong class="font-medium">Warnings:</strong>
                                                <ul class="mt-1 ml-4 list-disc">
                                                    <li v-for="(warning, index) in jsonWarnings" :key="index">{{ warning
                                                        }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-4 space-x-4">
                                            <button @click="resetJsonConfig"
                                                class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Reset</button>
                                        </div>
                                    </div>
                                </Transition>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </AuthenticatedLayout>
    </div>
</template>

<script setup lang="ts">
import { useFormBuilder } from './formBuilder';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TrashIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { Form, FormField } from '@/types/form';
import './formBuilder.css';

interface Props {
    form: Form;
}

const props = defineProps<Props>();
const {
    fieldTypes,
    form,
    isJsonEditorVisible,
    jsonConfig,
    jsonError,
    jsonWarnings,
    draggedField,
    dragOverIndex,
    toggleJsonEditor,
    resetJsonConfig,
    onDragStart,
    onDragEnd,
    onDragOver,
    onDrop,
    removeField,
    saveForm
} = useFormBuilder(props);
</script>
