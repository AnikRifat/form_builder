<template>
    <div>
      <AuthenticatedLayout>
        <template #header>
          <h2 class="text-xl font-semibold leading-tight text-gray-800">Form Builder</h2>
        </template>
        <div class="py-12 min-h-screen bg-gray-50">
          <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-2xl">
              <div class="p-8 bg-white">
                <h1 class="mb-8 text-3xl font-bold text-gray-900">Form Builder</h1>
                <div class="mb-6 space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Form Title</label>
                    <input v-model="form.title" type="text" class="mt-1 w-full input" placeholder="Enter form title" required>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Form Description</label>
                    <textarea v-model="form.description" class="mt-1 w-full input" placeholder="Enter form description" rows="3"></textarea>
                  </div>
                </div>

                <div class="grid grid-cols-12 gap-6">
                  <!-- Field Palette -->
                  <div class="col-span-3">
                    <div class="space-y-4">
                      <div
                        v-for="field in fieldTypes"
                        :key="field.type"
                        class="p-4 bg-white rounded-lg shadow-sm transition-all duration-200 cursor-move hover:shadow-md hover:bg-gray-50 hover:-translate-y-0.5"
                        draggable="true"
                        @dragstart="onDragStart($event, field)"
                      >
                        <div class="flex items-center space-x-3">
                          <div class="flex justify-center items-center w-8 h-8 bg-blue-50 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                          </div>
                          <span class="text-sm font-medium text-gray-700">{{ field.label }}</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Canvas -->
                  <div class="col-span-9">
                    <div
                      class="p-6 border border-dashed border-gray-300 rounded-lg min-h-[400px]"
                      @drop="onDrop($event, form.fields.length)"
                      @dragover.prevent
                      @dragenter.prevent
                    >
                      <div
                        v-for="(field, index) in form.fields"
                        :key="index"
                        class="p-6 mb-4 bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_32px_rgba(0,0,0,0.1)] transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] transform hover:-translate-y-1 border border-white/20 hover:border-white/40"
                        draggable="true"
                        @dragstart="onDragStart($event, field)"
                        @dragover.prevent
                        @drop="onDrop($event, index)"
                      >
                        <div class="flex justify-between items-start">
                          <div class="flex-1 space-y-2">
                            <div class="flex justify-between items-center">
                              <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                {{ field.type }}
                              </span>
                              <button
                                v-if="['select', 'radio'].includes(field.type)"
                                @click="field.showOptions = !field.showOptions"
                                class="text-sm text-blue-600 hover:text-blue-900"
                              >
                                {{ field.showOptions ? 'Hide' : 'Edit' }} Options
                              </button>
                            </div>
                            <div class="space-y-1">
                              <label class="block text-sm font-medium text-gray-700/80">Field Name</label>
                              <input
                                v-model="field.name"
                                type="text"
                                class="px-4 py-2.5 w-full text-sm rounded-xl border backdrop-blur-sm transition-all duration-200 outline-none bg-white/50 border-gray-200/60 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                                placeholder="Enter field name"
                                required
                              />
                            </div>
                            <div class="space-y-1">
                              <label class="block text-sm font-medium text-gray-700/80">Field Label</label>
                              <input
                                v-model="field.label"
                                type="text"
                                class="px-4 py-2.5 w-full text-sm rounded-xl border backdrop-blur-sm transition-all duration-200 outline-none bg-white/50 border-gray-200/60 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                                placeholder="Enter field label"
                                required
                              />
                            </div>
                            <component
                              :is="getFieldComponent(field.type)"
                              v-model="field.value"
                              :field="field"
                              class="mt-1"
                            />

                            <div v-show="field.showOptions &amp;&amp; ['select', 'radio'].includes(field.type)" class="mt-4 space-y-2">
                              <div v-for="(option, optionIndex) in field.options" :key="optionIndex" class="flex items-center space-x-2">
                                <input
                                  v-model="option.value"
                                  type="text"
                                  class="flex-1 px-3 py-1.5 text-sm rounded-lg border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                                  placeholder="Option value"
                                />
                                <button
                                  @click="field.options.splice(optionIndex, 1)"
                                  class="p-1.5 text-red-500 hover:text-red-700"
                                >
                                  <TrashIcon class="w-4 h-4" />
                                </button>
                              </div>
                              <button
                                @click="field.options.push({ value: '' })"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100"
                              >
                                <PlusIcon class="mr-1 w-4 h-4" />
                                Add Option
                              </button>
                            </div>
                          </div>
                          <button
                            @click="removeField(index)"
                            class="ml-4 text-red-600 hover:text-red-900"
                          >
                            <TrashIcon class="w-5 h-5" />
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="flex justify-end mt-6 space-x-4">
                    <button
                      type="button"
                      @click="saveForm"
                      class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-blue-500 rounded-md border border-transparent transition hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25"
                    >
                      Save Form
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </AuthenticatedLayout>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, defineProps, watch } from 'vue';
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
      method: 'POST',
      action: '/submit',
      is_active: true,
      fields: []
    };

    // Ensure fields array exists
    form.value.fields = form.value.fields || [];

    // Initialize showOptions for each field
    form.value.fields.forEach(field => {
      field.showOptions = Boolean(field.options?.length);
    });
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
      validation_rules: {},
      options: (type === 'select' || type === 'radio') ? [] : undefined,
      order: form.value.fields.length + 1,
      showOptions: type === 'select' || type === 'radio'
    };
    form.value.fields.push(newField);
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
          ...field,
          validation_rules: field.validation_rules || {}
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
