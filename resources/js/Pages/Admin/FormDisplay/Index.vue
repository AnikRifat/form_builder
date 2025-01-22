<template>
  <Head :title="form.title" />

  <AuthenticatedLayout>
    <div class="py-12">

      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        <div class="overflow-hidden mx-auto max-w-3xl bg-white shadow sm:rounded-lg form-container">
          <!-- Form Header -->
          <div class="px-4 py-5 border-b border-gray-200 sm:px-6 form-header">
            <div class="mb-4">
              <Link :href="route('forms.index')" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Forms
              </Link>
            </div>
            <div class="space-y-2">
              <h3 class="text-xl font-semibold text-gray-900">{{ form.title }}</h3>
              <p class="text-sm text-gray-500">{{ form.description }}</p>
            </div>
          </div>

          <!-- Form Body -->
          <div class="px-4 py-5 sm:p-6 form-content">
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <div v-for="field in form.fields" :key="field.id" class="p-4 bg-white rounded-lg border border-gray-200">
                <label :for="field.name" class="block text-sm font-medium text-gray-700 field-label">
                  {{ field.label }}
                  <span v-if="field.is_required" class="text-red-500">*</span>
                </label>

                <!-- Text Input -->
                <input
                  v-if="field.type === 'text' || field.type === 'email'"
                  :id="field.name"
                  v-model="formData[field.name]"
                  :type="field.type"
                  :required="field.is_required"
                  :placeholder="field.placeholder"
                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-input"
                />

                <!-- Textarea -->
                <textarea
                  v-if="field.type === 'textarea'"
                  :id="field.name"
                  v-model="formData[field.name]"
                  :required="field.is_required"
                  :placeholder="field.placeholder"
                  rows="4"
                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-input"
                />

                <!-- Select Box -->
                <select
                  v-if="field.type === 'select'"
                  :id="field.name"
                  v-model="formData[field.name]"
                  :required="field.is_required"
                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-input"
                >
                  <option value="" disabled>Please select an option</option>
                  <option v-for="option in field.options" :key="option.value" :value="option.value">
                    {{ option.value }}
                  </option>
                </select>

                <!-- Radio Buttons -->
                <div v-if="field.type === 'radio'" class="mt-4 space-y-3">
                  <div
                    v-for="option in field.options"
                    :key="option.value"
                    class="flex relative items-center p-4 rounded-lg border border-gray-200 transition duration-150 cursor-pointer hover:bg-gray-50"
                  >
                    <input
                      :id="field.name + '-' + option.value"
                      v-model="formData[field.name]"
                      :name="field.name"
                      type="radio"
                      :value="option.value"
                      :required="field.is_required"
                      class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500"
                    />
                    <label :for="field.name + '-' + option.value" class="block ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                      {{ option.value }}
                    </label>
                  </div>
                </div>

                <!-- Field Description -->
                <p v-if="field.placeholder && field.type !== 'text' && field.type !== 'email' && field.type !== 'textarea'" class="mt-2 text-sm text-gray-500">
                  {{ field.placeholder }}
                </p>
              </div>

              <!-- Submit Button -->
              <div class="flex justify-end form-footer">
                <button
                  type="submit"
                  class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed submit-button"
                  :disabled="isSubmitting"
                >
                  {{ isSubmitting ? 'Submitting...' : 'Submit' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <!-- Submission Modal -->
  <TransitionRoot appear :show="showModal" as="template">
    <Dialog as="div" @close="showModal = false" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="overflow-y-auto fixed inset-0">
        <div class="flex justify-center items-center p-4 min-h-full text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="overflow-hidden p-6 w-full max-w-md text-left align-middle bg-white rounded-2xl shadow-xl transition-all transform">
              <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                Form Submission
              </DialogTitle>

              <div class="mt-4">
                <div class="space-y-4">
                  <div v-for="field in form.fields" :key="field.id" class="pb-4 border-b border-gray-200">
                    <h4 class="font-medium text-gray-700">{{ field.label }}</h4>
                    <p class="mt-1 text-sm text-gray-600">
                      {{ formatFieldValue(formData[field.name]) }}
                    </p>
                  </div>
                </div>
              </div>

              <div class="flex justify-end mt-6">
                <button
                  type="button"
                  class="inline-flex justify-center px-4 py-2 text-sm font-medium text-blue-900 bg-blue-100 rounded-md border border-transparent hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="showModal = false"
                >
                  Close
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup lang="ts">
import { defineProps, ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Form, FormField } from '@/types/form';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';

interface Props {
  form: Form;
}

const props = defineProps<Props>();
const formData = ref<Record<string, any>>({});
const isSubmitting = ref(false);
const showModal = ref(false);

// Initialize form data with appropriate data types
const initializeFormData = () => {
  props.form.fields.forEach(field => {
    formData.value[field.name] = '';
  });
};

// Format field values for display
const formatFieldValue = (value: any): string => {
  if (!value) return 'Not provided';
  return String(value);
};

// Handle form submission
const handleSubmit = async (e: Event) => {
  e.preventDefault();
  isSubmitting.value = true;

  try {
    // Here you would typically send the data to your backend
    // For now, we'll just show the modal with the form data
    showModal.value = true;
  } catch (error) {
    console.error('Error submitting form:', error);
  } finally {
    isSubmitting.value = false;
  }
};

// Initialize form data on component mount
initializeFormData();
</script>
