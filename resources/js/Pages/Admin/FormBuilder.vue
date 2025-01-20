<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Form Builder
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-12 gap-6">
              <!-- Field Palette -->
              <div class="col-span-3">
                <div class="space-y-4">
                  <div
                    v-for="field in fieldTypes"
                    :key="field.type"
                    class="p-4 rounded-lg border border-gray-200 cursor-move"
                    draggable="true"
                    @dragstart="onDragStart($event, field)"
                  >
                    <span class="text-sm font-medium">{{ field.label }}</span>
                  </div>
                </div>
              </div>

              <!-- Form Canvas -->
              <div class="col-span-9">
                <div
                  class="p-6 border border-dashed border-gray-300 rounded-lg min-h-[400px]"
                  @drop="onDrop"
                  @dragover.prevent
                >
                  <div
                    v-for="(field, index) in form.fields"
                    :key="index"
                    class="p-4 mb-4 bg-gray-50 rounded-lg"
                  >
                    <div class="flex justify-between items-center">
                      <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">
                          {{ field.label }}
                        </label>
                        <component
                          :is="getFieldComponent(field.type)"
                          v-model="field.value"
                          :field="field"
                          class="mt-1"
                        />
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
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { Form, FormField } from '@/types/form';

const fieldTypes = [
  { type: 'text', label: 'Text Input' },
  { type: 'email', label: 'Email Input' },
  { type: 'textarea', label: 'Text Area' },
  { type: 'select', label: 'Select Box' },
  { type: 'checkbox', label: 'Checkbox' },
  { type: 'radio', label: 'Radio Button' },
];

const form = ref<Form>({
  title: '',
  description: '',
  method: 'POST',
  action: '/submit',
  is_active: true,
  fields: [],
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
    options: type === 'select' || type === 'radio' ? [] : undefined,
    order: form.value.fields.length + 1,
  };
  form.value.fields.push(newField);
};

const removeField = (index: number) => {
  form.value.fields.splice(index, 1);
};

const saveForm = async () => {
  try {
    await router.post(route('forms.store'), {
      ...form.value,
      fields: form.value.fields.map(field => ({
        ...field,
        validation_rules: field.validation_rules || {}
      }))
    });

    router.visit(route('forms.index'));
  } catch (error) {
    console.error('Error saving form:', error);
  }
};
</script>
