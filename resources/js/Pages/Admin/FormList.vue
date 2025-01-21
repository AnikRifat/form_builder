<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Form Management
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-medium">Forms</h3>
              <Link
                :href="route('forms.create')"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-blue-500 rounded-md border border-transparent transition hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25"
              >
                Create New Form
              </Link>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Title
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Method
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Action
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Created At
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="form in forms" :key="form.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ form.title }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ form.method }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ form.action }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ formatDate(form.created_at) }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                      <Link
                        :href="route('forms.view', form.id)"
                        class="mr-4 text-green-600 hover:text-green-900"
                      >
                        View
                      </Link>
                      <Link
                        :href="route('forms.edit', form.id)"
                        class="mr-4 text-blue-600 hover:text-blue-900"
                      >
                        Edit
                      </Link>
                      <button
                        @click="deleteForm(form.id)"
                        class="text-red-600 hover:text-red-900"
                      >
                        Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Form } from '@/types/form';
import { router } from '@inertiajs/vue3';

defineProps<{
  forms: Form[];
}>();

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString();
};

const deleteForm = (id: number) => {
  if (confirm('Are you sure you want to delete this form?')) {
    router.delete(route('forms.destroy', id));
  }
};
</script>
