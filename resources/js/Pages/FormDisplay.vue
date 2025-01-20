<script setup lang="ts">
import { Form } from '@/types/form'
import useVuelidate from '@vuelidate/core'
import { required, email, minLength, maxLength } from '@vuelidate/validators'
import { computed, reactive, ref } from 'vue'

const props = defineProps<{
    form: Form
}>()

// Create reactive form data
const formData = reactive<Record<string, any>>({})
const rules = computed(() => {
    const validationRules: Record<string, any> = {}

    props.form.fields.forEach(field => {
        const fieldRules: Record<string, any> = {}

        if (field.is_required) {
            fieldRules.required = required
        }

        if (field.validation_rules) {
            if (field.validation_rules.minLength) {
                fieldRules.minLength = minLength(field.validation_rules.minLength)
            }
            if (field.validation_rules.maxLength) {
                fieldRules.maxLength = maxLength(field.validation_rules.maxLength)
            }
            if (field.type === 'email') {
                fieldRules.email = email
            }
        }

        validationRules[field.name] = fieldRules
    })

    return validationRules
})

const v$ = useVuelidate(rules, formData)

const isLoading = ref(false)
const submissionStatus = ref<null | 'success' | 'error'>(null)

const submitForm = async () => {
    const isValid = await v$.value.$validate()

    if (!isValid) {
        return
    }

    try {
        isLoading.value = true
        submissionStatus.value = null

        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000))

        // Handle form submission
        console.log('Form submitted:', formData)
        submissionStatus.value = 'success'
    } catch (error) {
        console.error('Submission failed:', error)
        submissionStatus.value = 'error'
    } finally {
        isLoading.value = false
    }
}
</script>

<template>
    <div class="p-6 mx-auto max-w-2xl">
        <h1 class="mb-6 text-2xl font-bold">{{ form.title }}</h1>

        <form @submit.prevent="submitForm" class="space-y-4">
            <div v-for="(field, index) in form.fields" :key="index" class="space-y-2">
                <label class="block text-sm font-medium">
                    {{ field.label }}
                    <span v-if="field.is_required" class="text-red-500">*</span>
                </label>

                <input
                    v-if="['text', 'email'].includes(field.type)"
                    :type="field.type"
                    :name="field.name"
                    :placeholder="field.placeholder"
                    class="w-full input"
                    :class="{ 'border-red-500': v$[field.name]?.$error }"
                    v-model="formData[field.name]"
                    :required="field.is_required"
                >
                <div v-if="v$[field.name]?.$error" class="mt-1 text-sm text-red-500">
                    <p v-if="v$[field.name]?.required?.$invalid">This field is required</p>
                    <p v-if="v$[field.name]?.email?.$invalid">Please enter a valid email address</p>
                    <p v-if="v$[field.name]?.minLength?.$invalid">
                        Minimum length is {{ field.validation_rules?.minLength }} characters
                    </p>
                    <p v-if="v$[field.name]?.maxLength?.$invalid">
                        Maximum length is {{ field.validation_rules?.maxLength }} characters
                    </p>
                </div>

                <textarea
                    v-else-if="field.type === 'textarea'"
                    :name="field.name"
                    :placeholder="field.placeholder"
                    class="w-full input"
                    :class="{ 'border-red-500': v$[field.name]?.$error }"
                    v-model="formData[field.name]"
                    :required="field.is_required"
                ></textarea>
                <div v-if="v$[field.name]?.$error" class="mt-1 text-sm text-red-500">
                    <p v-if="v$[field.name]?.required?.$invalid">This field is required</p>
                    <p v-if="v$[field.name]?.minLength?.$invalid">
                        Minimum length is {{ field.validation_rules?.minLength }} characters
                    </p>
                    <p v-if="v$[field.name]?.maxLength?.$invalid">
                        Maximum length is {{ field.validation_rules?.maxLength }} characters
                    </p>
                </div>

                <select
                    v-else-if="field.type === 'select'"
                    :name="field.name"
                    class="w-full input"
                    :class="{ 'border-red-500': v$[field.name]?.$error }"
                    v-model="formData[field.name]"
                    :required="field.is_required"
                >
                    <option value="">Select an option</option>
                    <option v-for="(option, i) in field.options" :key="i" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
                <div v-if="v$[field.name]?.$error" class="mt-1 text-sm text-red-500">
                    <p v-if="v$[field.name]?.required?.$invalid">Please select an option</p>
                </div>

                <div v-else-if="field.type === 'checkbox'">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            :name="field.name"
                            class="mr-2"
                            v-model="formData[field.name]"
                            :required="field.is_required"
                        >
                        {{ field.label }}
                    </label>
                    <div v-if="v$[field.name]?.$error" class="mt-1 text-sm text-red-500">
                        <p v-if="v$[field.name]?.required?.$invalid">This field is required</p>
                    </div>
                </div>

                <div v-else-if="field.type === 'radio'">
                    <div v-for="(option, i) in field.options" :key="i" class="flex items-center">
                        <input
                            type="radio"
                            :name="field.name"
                            :value="option.value"
                            class="mr-2"
                            v-model="formData[field.name]"
                            :required="field.is_required"
                        >
                        {{ option.label }}
                    </div>
                    <div v-if="v$[field.name]?.$error" class="mt-1 text-sm text-red-500">
                        <p v-if="v$[field.name]?.required?.$invalid">Please select an option</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button
                    type="submit"
                    class="btn-primary"
                    :disabled="isLoading"
                >
                    <span v-if="isLoading">Submitting...</span>
                    <span v-else>Submit</span>
                </button>

                <div v-if="submissionStatus === 'success'" class="text-green-600">
                    Form submitted successfully!
                </div>
                <div v-else-if="submissionStatus === 'error'" class="text-red-600">
                    Submission failed. Please try again.
                </div>
            </div>
        </form>
    </div>
</template>
