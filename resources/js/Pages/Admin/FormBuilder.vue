<template>
  <div class="container p-4 mx-auto">
    <h1 class="mb-4 text-3xl font-bold">Form Builder</h1>
    <div class="mb-4">
      <label for="formTitle" class="block mb-2 font-bold text-gray-700">Form Title</label>
      <input v-model="form.title" type="text" id="formTitle" class="px-3 py-2 w-full rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div class="mb-4">
      <label for="formDescription" class="block mb-2 font-bold text-gray-700">Form Description</label>
      <textarea v-model="form.description" id="formDescription" class="px-3 py-2 w-full rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
    </div>

    <div class="grid grid-cols-12 gap-4">
      <div class="col-span-3">
        <div class="p-4 rounded-lg border border-gray-300">
          <h2 class="mb-2 text-lg font-medium">Add Field</h2>
          <div class="space-y-2">
            <button v-for="field in fieldTypes" :key="field.type" class="px-4 py-2 w-full font-medium text-gray-800 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500" @click="addField(field.type)">
              {{ field.label }}
            </button>
          </div>
        </div>
      </div>
      <div class="col-span-9">
        <div class="p-4 rounded-lg border border-gray-300">
          <h2 class="mb-2 text-lg font-medium">Form Fields</h2>
          <div v-for="(field, index) in form.fields" :key="index" class="mb-4">
            <div class="flex justify-between items-center mb-2">
              <div class="flex items-center">
                <span class="mr-2 font-medium text-blue-600">{{ field.type }}</span>
                <span class="font-medium text-gray-700"> - {{ field.label }}</span>
              </div>
              <button @click="removeField(index)" class="text-red-500 hover:text-red-700">
                <TrashIcon class="w-4 h-4" />
              </button>
            </div>
            <div class="mb-2">
              <label for="fieldName" class="block mb-1 font-medium text-gray-700">Field Name</label>
              <input v-model="field.name" type="text" id="fieldName" class="px-3 py-2 w-full rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-2">
              <label for="fieldLabel" class="block mb-1 font-medium text-gray-700">Field Label</label>
              <input v-model="field.label" type="text" id="fieldLabel" class="px-3 py-2 w-full rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div v-if="field.options &amp;&amp; field.options.length > 0" class="mt-2">
              <div v-for="(option, optionIndex) in field.options" :key="optionIndex" class="flex items-center mb-1 space-x-2">
                <input v-model="option.value" type="text" class="px-3 py-2 w-full rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button @click="field.options.splice(optionIndex, 1)" class="text-red-500 hover:text-red-700">
                  <TrashIcon class="w-4 h-4" />
                </button>
              </div>
              <button @click="field.options.push({ value: '' })" class="inline-flex items-center px-3 py-1.5 mt-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100">
                <PlusIcon class="mr-1 w-4 h-4" />
                Add Option
              </button>
            </div>
          </div>
          <button @click="addField('text')" class="px-4 py-2 mt-4 w-full font-medium text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-700">
            Add Field
          </button>
        </div>
      </div>
    </div>
    <div class="mt-6">
      <button @click="saveForm" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
        Save Form
      </button>
    </div>
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

const onDragStart = (event: DragEvent, field: { type: string }) => {
  event.dataTransfer?.setData('fieldType', field.type);
};

const onDrop = (event: DragEvent) => {
  const fieldType = event.dataTransfer?.getData('fieldType');
  if (fieldType) {
    addField(fieldType);
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
