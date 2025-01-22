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
              <p v-if="form.description" class="mt-1 text-sm text-gray-600">{{ form.description }}</p>
            </div>

            <!-- Form Body -->
            <div class="p-6">
              <form @submit.prevent="submitForm" class="space-y-6">
                <div v-for="field in form.fields" :key="field.id" class="p-4 bg-white rounded-lg border border-gray-200">
                  <label :for="field.name" class="block text-sm font-medium text-gray-700">
                    {{ field.label }}
                    <span v-if="field.is_required" class="text-red-500">*</span>
                  </label>

                  <!-- Text & Email Inputs -->
                  <input v-if="field.type === 'text' || field.type === 'email'" v-model="formData[field.name]" :id="field.name" :type="field.type" :placeholder="field.placeholder" :required="field.is_required" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />

                  <!-- Textarea -->
                  <textarea v-if="field.type === 'textarea'" v-model="formData[field.name]" :id="field.name" :placeholder="field.placeholder" :required="field.is_required" rows="4" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>

                  <!-- Select Box -->
                  <select v-if="field.type === 'select'" v-model="formData[field.name]" :id="field.name" :required="field.is_required" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="" disabled>Please select an option</option>
                    <option v-for="option in field.options" :key="option.value" :value="option.value">
                      {{ option.value }}
                    </option>
                  </select>

                  <!-- Radio Buttons -->
                  <div v-if="field.type === 'radio'" class="mt-2 space-y-2">
                    <div v-for="option in field.options" :key="option.value" class="flex items-center">
                      <input :id="field.name + '-' + option.value" v-model="formData[field.name]" :name="field.name" type="radio" :value="option.value" :required="field.is_required" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" />
                      <label :for="field.name + '-' + option.value" class="ml-3 block text-sm font-medium text-gray-700">
                        {{ option.value }}
                      </label>
                    </div>
                  </div>

                  <!-- Checkboxes -->
                  <div v-if="field.type === 'checkbox'" class="mt-2">
                    <template v-if="field.options">
                      <div v-for="option in field.options" :key="option.value" class="flex items-center mb-2">
                        <input :id="field.name + '-' + option.value" v-model="formData[field.name]" type="checkbox" :value="option.value" :required="field.is_required" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" />
                        <label :for="field.name + '-' + option.value" class="ml-3 block text-sm font-medium text-gray-700">
                          {{ option.value }}
                        </label>
                      </div>
                    </template>
                    <template v-else>
                      <div class="flex items-center">
                        <input :id="field.name" v-model="formData[field.name]" type="checkbox" :required="field.is_required" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" />
                        <label :for="field.name" class="ml-3 block text-sm font-medium text-gray-700">
                          {{ field.label }}
                        </label>
                      </div>
                    </template>
                  </div>

                  <!-- Field Description/Help Text -->
                  <p v-if="field.placeholder && field.type !== 'text' && field.type !== 'email' && field.type !== 'textarea'" class="mt-2 text-sm text-gray-500">
                    {{ field.placeholder }}
                  </p>
                </div>

                <!-- Submit Button -->
                <div class="pt-5 border-t border-gray-200">
                  <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
import { defineProps, ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Form, FormField } from '@/types/form';

interface Props {
  form: Form;
}

const props = defineProps<Props>();
const formData = ref<Record<string, any>>({});

// Initialize form data with appropriate data types
const initializeFormData = () => {
  props.form.fields.forEach(field => {
    if (field.type === 'checkbox' && field.options) {
      formData.value[field.name] = [];
    } else if (field.type === 'checkbox' && !field.options) {
      formData.value[field.name] = false;
    } else {
      formData.value[field.name] = '';
    }
  });
};

// Initialize form data when component mounts
initializeFormData();

const submitForm = () => {
  // Here you would typically send the form data to your backend
  console.log('Form submitted with data:', formData.value);
  // You can use Inertia to submit the form
  // router.post(route('forms.submit', props.form.id), formData.value);
};
</script>
