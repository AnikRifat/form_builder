<template>
  <Head>
    <title>{{ form.title }} - Form Display</title>
  </Head>
  <div>
    <AuthenticatedLayout>
      <template #header>
        <div class="flex justify-between items-center">
          <h1 class="text-3xl font-bold text-gray-900">{{ form.title }}</h1>
          <Link :href="route('forms.index')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white rounded-md border border-gray-300 hover:bg-gray-50">
            Back to Forms
          </Link>
        </div>
      </template>
      <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
          <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <!-- Form Header -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
              <h2 class="text-xl font-semibold text-gray-800">{{ form.title }}</h2>
              <p class="mt-1 text-sm text-gray-600">Please fill out the form below</p>
            </div>

            <!-- Form Body -->
            <div class="p-6">
              <form @submit.prevent="submitForm" class="space-y-6">
                <div v-for="field in form.fields" :key="field.id" class="space-y-1">
                  <label :for="field.name" class="block text-sm font-medium text-gray-700">
                    {{ field.label }}
                    <span v-if="field.is_required" class="text-red-500">*</span>
                  </label>

                  <!-- Text & Email Inputs -->
                  <input
                    v-if="field.type === 'text' || field.type === 'email'"
                    v-model="formData[field.name]"
                    :id="field.name"
                    :type="field.type"
                    :placeholder="field.placeholder"
                    :required="field.is_required"
                    class="block px-4 py-2 mt-1 w-full text-gray-900 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />

                  <!-- Textarea -->
                  <textarea
                    v-if="field.type === 'textarea'"
                    v-model="formData[field.name]"
                    :id="field.name"
                    :placeholder="field.placeholder"
                    :required="field.is_required"
                    rows="4"
                    class="block px-4 py-2 mt-1 w-full text-gray-900 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  ></textarea>

                  <!-- Select Box -->
                  <select
                    v-if="field.type === 'select'"
                    v-model="formData[field.name]"
                    :id="field.name"
                    :required="field.is_required"
                    class="block px-4 py-2 mt-1 w-full text-gray-900 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="" disabled selected>Please select an option</option>
                    <option
                      v-for="option in JSON.parse(field.options)"
                      :key="option"
                      :value="option"
                    >
                      {{ option }}
                    </option>
                  </select>

                  <!-- Radio Buttons -->
                  <div v-if="field.type === 'radio'" class="mt-2 space-y-2">
                    <div
                      v-for="option in JSON.parse(field.options)"
                      :key="option"
                      class="flex items-center"
                    >
                      <input
                        :id="field.name + '-' + option"
                        v-model="formData[field.name]"
                        :name="field.name"
                        type="radio"
                        :value="option"
                        :required="field.is_required"
                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                      />
                      <label :for="field.name + '-' + option" class="block ml-3 text-sm font-medium text-gray-700">
                        {{ option }}
                      </label>
                    </div>
                  </div>

                  <!-- Checkboxes -->
                  <div v-if="field.type === 'checkbox'" class="mt-2 space-y-2">
                    <template v-if="field.options">
                      <div
                        v-for="option in JSON.parse(field.options)"
                        :key="option"
                        class="flex items-center"
                      >
                        <input
                          :id="field.name + '-' + option"
                          v-model="formData[field.name]"
                          type="checkbox"
                          :value="option"
                          :required="field.is_required"
                          class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                        />
                        <label :for="field.name + '-' + option" class="block ml-3 text-sm font-medium text-gray-700">
                          {{ option }}
                        </label>
                      </div>
                    </template>
                    <template v-else>
                      <div class="flex items-center">
                        <input
                          :id="field.name"
                          v-model="formData[field.name]"
                          type="checkbox"
                          :required="field.is_required"
                          class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                        />
                        <label :for="field.name" class="block ml-3 text-sm font-medium text-gray-700">
                          {{ field.label }}
                        </label>
                      </div>
                    </template>
                  </div>

                  <!-- Field Description/Help Text -->
                  <p v-if="field.placeholder && field.type !== 'text' && field.type !== 'email' && field.type !== 'textarea'" class="mt-1 text-sm text-gray-500">
                    {{ field.placeholder }}
                  </p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-200">
                  <button
                    type="submit"
                    class="px-4 py-2 w-full text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                  >
                    Submit Form
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Form } from '@/types/form';

interface Props {
  form: Form;
}

const props = defineProps<Props>();
const formData = ref<Record<string, any>>({});

// Initialize form data with appropriate data types
onMounted(() => {
  props.form.fields.forEach(field => {
    if (field.type === 'checkbox' && field.options) {
      formData.value[field.name] = [];
    } else {
      formData.value[field.name] = '';
    }
  });
});

const submitForm = () => {
  try {
    // Save form data to localStorage
    localStorage.setItem('formSubmission', JSON.stringify(formData.value));

    // Show success message
    const message = 'Form submitted successfully!';
    const detail = 'Your response has been recorded.';

    // You can implement a proper toast/notification system here
    alert(message);

    // Reset form after submission
    props.form.fields.forEach(field => {
      if (field.type === 'checkbox' && field.options) {
        formData.value[field.name] = [];
      } else {
        formData.value[field.name] = '';
      }
    });
  } catch (error) {
    console.error('Error submitting form:', error);
    alert('An error occurred while submitting the form. Please try again.');
  }
};
</script>
