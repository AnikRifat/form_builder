<template>
  <Head>
    <title>{{ form.title }} - Form Display</title>
  </Head>
  <div>
    <AuthenticatedLayout>
      <template #header>
        <h1 class="text-3xl font-bold text-gray-900">Form Display</h1>
      </template>
      <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden p-6 bg-white shadow-xl sm:rounded-lg">
            <h2 class="mb-4 text-2xl font-semibold text-gray-800">Form Details</h2>
            <div v-if="form" class="space-y-4">
              <form @submit.prevent="submitForm" class="space-y-6">
                <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                  <p><strong>Title:</strong> {{ form.title }}</p>
                  <p><strong>Method:</strong> {{ form.method }}</p>
                  <p><strong>Action:</strong> {{ form.action }}</p>
                </div>
                <div v-for="field in form.fields" :key="field.id" class="space-y-2">
                  <label class="block text-sm font-medium text-gray-700">{{ field.label }}</label>
                  <input v-if="field.type === 'text' || field.type === 'email'" v-model="formData[field.name]" :type="field.type" :placeholder="field.placeholder" :required="field.is_required" class="p-2 mt-1 w-full rounded-md border" />
                  <textarea v-if="field.type === 'textarea'" v-model="formData[field.name]" :placeholder="field.placeholder" :required="field.is_required" class="p-2 mt-1 w-full rounded-md border"></textarea>
                  <select v-if="field.type === 'select'" v-model="formData[field.name]" :required="field.is_required" class="p-2 mt-1 w-full rounded-md border">
                    <option disabled value="" class="text-gray-400">{{ field.placeholder }}</option>
                    <option v-for="option in field.options" :key="option.value" :value="option.value">{{ option.value }}</option>
                  </select>
                  <div v-if="field.type === 'checkbox'" class="flex items-center">
                    <input v-model="formData[field.name]" type="checkbox" :required="field.is_required" class="mt-1" />
                    <span class="ml-2 text-sm text-gray-600">{{ field.placeholder }}</span>
                  </div>
                  <input v-if="field.type === 'radio'" v-model="formData[field.name]" type="radio" :value="field.value" :required="field.is_required" class="mt-1" />
                </div>
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Submit</button>
              </form>
            </div>
            <div v-else>
              <p>Loading form details...</p>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Form } from '@/types/form';

interface Props {
  form: Form;
}

const props = defineProps<Props>();
const formData = ref({});

const submitForm = () => {
  // Handle form submission logic here
  console.log('Form submitted:', formData.value);
  alert('Form submitted successfully');
  // Save form data to localStorage
  localStorage.setItem('formSubmission', JSON.stringify(formData.value));
};
</script>
