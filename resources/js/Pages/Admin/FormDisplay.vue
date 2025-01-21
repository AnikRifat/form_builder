<template>
  <div>
    <AuthenticatedLayout>
      <template #header>
        <h1 class="text-3xl font-bold text-gray-900">Form Display</h1>
      </template>
      <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden p-6 bg-white shadow-xl sm:rounded-lg">
            <h2 class="mb-4 text-2xl font-semibold text-gray-800">Form Details</h2>
            <div v-if="form">
              <form @submit.prevent="submitForm">
                <p><strong>Title:</strong> {{ form.title }}</p>
                <p><strong>Method:</strong> {{ form.method }}</p>
                <p><strong>Action:</strong> {{ form.action }}</p>
                <p><strong>Fields:</strong></p>
                <div v-for="field in form.fields" :key="field.id" class="mb-4">
                  <label class="block text-sm font-medium text-gray-700">{{ field.label }}</label>
                  <input v-if="field.type === 'text' || field.type === 'email'" v-model="formData[field.name]" :type="field.type" :placeholder="field.placeholder" :required="field.is_required" class="p-2 mt-1 w-full rounded-md border" />
                  <textarea v-if="field.type === 'textarea'" v-model="formData[field.name]" :placeholder="field.placeholder" :required="field.is_required" class="p-2 mt-1 w-full rounded-md border"></textarea>
                  <select v-if="field.type === 'select'" v-model="formData[field.name]" :required="field.is_required" class="p-2 mt-1 w-full rounded-md border">
                    <option v-for="option in field.options" :key="option.value" :value="option.value">{{ option.value }}</option>
                  </select>
                  <input v-if="field.type === 'checkbox'" v-model="formData[field.name]" type="checkbox" :required="field.is_required" class="mt-1" />
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
