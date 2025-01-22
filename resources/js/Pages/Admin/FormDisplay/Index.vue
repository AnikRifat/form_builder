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
            <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
              <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                Form Submission
              </DialogTitle>

              <div class="mt-4">
                <!-- Error Message -->
                <div v-if="submissionError" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
                  <div class="flex">
                    <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                      </svg>
                    </div>
                    <div class="ml-3">
                      <p class="text-sm text-red-600">{{ submissionError }}</p>
                    </div>
                  </div>
                </div>

                <!-- Form Data -->
                <div class="space-y-4">
                  <div v-for="field in form.fields" :key="field.id" class="border-b border-gray-200 pb-4">
                    <h4 class="font-medium text-gray-700">{{ field.label }}</h4>
                    <p class="mt-1 text-sm text-gray-600">
                      {{ formatFieldValue(formData[field.name]) }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- Loading State -->
              <div v-if="isSubmitting" class="mt-4 text-sm text-gray-500">
                Submitting form data...
              </div>

              <div class="mt-6 flex justify-end space-x-3">
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="showModal = false"
                  :disabled="isSubmitting"
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
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Form, FormField } from '@/types/form';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import axios, { AxiosError } from 'axios';

interface Props {
  form: Form;
}

const props = defineProps<Props>();
const formData = ref<Record<string, any>>({});
const isSubmitting = ref(false);
const showModal = ref(false);
const submissionError = ref<string | null>(null);

// Format error message based on the error response
const formatErrorMessage = (error: AxiosError): string => {
  const baseMessage = `An error occurred while submitting the form to ${props.form.action}.`;
  
  if (error.response) {
    // Server responded with error status
    const status = error.response.status;
    const data = error.response.data as any;
    
    switch (status) {
      case 404:
        return `${baseMessage} The form submission endpoint was not found (404).`;
      case 422:
        // Validation errors
        const validationErrors = data.errors ? Object.values(data.errors).flat().join(', ') : '';
        return `${baseMessage} Validation failed: ${validationErrors}`;
      case 500:
        return `${baseMessage} The server encountered an internal error (500).`;
      default:
        return `${baseMessage} Server returned status ${status}.`;
    }
  } else if (error.request) {
    // Request made but no response received
    return `${baseMessage} No response received from server. Please check your connection.`;
  } else {
    // Error setting up the request
    return `${baseMessage} ${error.message}`;
  }
};

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
  submissionError.value = null;

  try {
    // Show the modal first
    showModal.value = true;

    // Then submit the form data to the action URL
    const response = await axios({
      method: props.form.method || 'POST',
      url: props.form.action,
      data: formData.value,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      }
    });

    // Handle successful submission
    console.log('Form submitted successfully:', response.data);
  } catch (error) {
    console.error('Error submitting form:', error);
    submissionError.value = formatErrorMessage(error as AxiosError);
  } finally {
    isSubmitting.value = false;
  }
};

// Initialize form data on component mount
initializeFormData();
</script>
