import { ref, defineProps, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TrashIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { Form, FormField } from '@/types/form';

export const useFormBuilder = (props) => {
    const fieldTypes = [
        { type: 'text', label: 'Text Input' },
        { type: 'email', label: 'Email Input' },
        { type: 'textarea', label: 'Text Area' },
        { type: 'select', label: 'Select Box' },
        { type: 'checkbox', label: 'Checkbox' },
        { type: 'radio', label: 'Radio Button' },
    ];

    const form = ref(props.form);
    const isJsonEditorVisible = ref(false);
    const jsonConfig = ref('');
    const jsonError = ref('');
    const jsonWarnings = ref([]);
    const draggedField = ref(null);
    const dragOverIndex = ref(null);

    // Initialize form fields if empty
    if (!form.value.fields) {
        form.value.fields = [];
    }

    const toggleJsonEditor = () => {
        isJsonEditorVisible.value = !isJsonEditorVisible.value;
        if (isJsonEditorVisible.value) {
            showJsonConfig();
        }
    };

    const showJsonConfig = () => {
        const { id, created_at, updated_at, deleted_at, ...formWithoutTimestamps } = form.value;
        const fieldsWithoutTimestamps = formWithoutTimestamps.fields.map(field => {
            const { id, created_at, updated_at, deleted_at, form_id, ...fieldWithoutTimestamps } = field;
            return fieldWithoutTimestamps;
        });
        jsonConfig.value = JSON.stringify({ ...formWithoutTimestamps, fields: fieldsWithoutTimestamps }, null, 2);
    };

    const resetJsonConfig = () => {
        showJsonConfig();
    };

    const validateFormJson = (json) => {
        try {
            const warnings = [];
            
            if (!json.title) return { isValid: false, error: 'Form title is required', warnings };
            
            if (!json.method) {
                return { isValid: false, error: 'Form method is required', warnings };
            }
            
            const validMethods = ['POST', 'GET', 'PUT', 'PATCH', 'DELETE'];
            const providedMethod = json.method.toUpperCase();
            
            if (!validMethods.includes(providedMethod)) {
                return { 
                    isValid: false, 
                    error: `Invalid HTTP method "${json.method}". Must be one of: ${validMethods.join(', ')}`,
                    warnings 
                };
            }
            
            if (json.method !== providedMethod) {
                warnings.push(`Method should be uppercase: "${json.method}" → "${providedMethod}"`);
                json.method = providedMethod;
            }

            if (!json.action) {
                return { isValid: false, error: 'Form action is required', warnings };
            }
            
            if (!json.action.startsWith('/')) {
                warnings.push(`Action URL should start with a forward slash: "${json.action}" → "/${json.action}"`);
            }

            if (!Array.isArray(json.fields)) {
                return { isValid: false, error: 'Fields must be an array', warnings };
            }

            for (let i = 0; i < json.fields.length; i++) {
                const field = json.fields[i];
                
                if (!field.type) {
                    return { isValid: false, error: `Field ${i + 1}: Type is required`, warnings };
                }
                if (!field.name) {
                    return { isValid: false, error: `Field ${i + 1}: Name is required`, warnings };
                }
                if (!field.label) {
                    return { isValid: false, error: `Field ${i + 1}: Label is required`, warnings };
                }

                const validTypes = ['text', 'email', 'textarea', 'select', 'checkbox', 'radio'];
                if (!validTypes.includes(field.type)) {
                    return { 
                        isValid: false, 
                        error: `Field ${i + 1}: Invalid type "${field.type}". Must be one of: ${validTypes.join(', ')}`,
                        warnings
                    };
                }

                if (!/^[a-zA-Z_][a-zA-Z0-9_]*$/.test(field.name)) {
                    return { 
                        isValid: false, 
                        error: `Field ${i + 1}: Invalid name "${field.name}". Must start with a letter or underscore and contain only letters, numbers, and underscores`,
                        warnings
                    };
                }

                if (field.name !== field.name.toLowerCase()) {
                    warnings.push(`Field ${i + 1}: Name should be in snake_case: "${field.name}" → "${field.name.toLowerCase()}"`);
                }

                const duplicateName = json.fields.find((f, index) => index !== i && f.name === field.name);
                if (duplicateName) {
                    return { 
                        isValid: false, 
                        error: `Field ${i + 1}: Duplicate field name "${field.name}"`,
                        warnings
                    };
                }

                if (['select', 'radio'].includes(field.type)) {
                    if (!Array.isArray(field.options)) {
                        return { 
                            isValid: false, 
                            error: `Field ${i + 1}: Options must be an array for ${field.type} fields`,
                            warnings
                        };
                    }
                    if (field.options.length === 0) {
                        return { 
                            isValid: false, 
                            error: `Field ${i + 1}: ${field.type} field must have at least one option`,
                            warnings
                        };
                    }
                    for (let j = 0; j < field.options.length; j++) {
                        if (!field.options[j].value) {
                            return { 
                                isValid: false, 
                                error: `Field ${i + 1}, Option ${j + 1}: Option value is required`,
                                warnings
                            };
                        }
                    }
                }
            }

            return { isValid: true, error: '', warnings };
        } catch (error) {
            return { isValid: false, error: 'Invalid JSON format', warnings: [] };
        }
    };

    const onDragStart = (event, field) => {
        draggedField.value = field;
        event.target.classList.add('dragging');
    };

    const onDragEnd = (event) => {
        event.target.classList.remove('dragging');
        draggedField.value = null;
        dragOverIndex.value = null;
    };

    const onDragOver = (event, index) => {
        event.preventDefault();
        if (!draggedField.value) return;
        
        const draggedIndex = form.value.fields.findIndex(f => f.id === draggedField.value.id);
        if (draggedIndex === index) return;
        
        dragOverIndex.value = index;
    };

    const onDrop = (event, index) => {
        event.preventDefault();
        
        if (!draggedField.value) return;
        
        const currentIndex = form.value.fields.findIndex(f => f.id === draggedField.value.id);
        
        if (currentIndex === -1) {
            const newField = {
                id: Date.now(),
                ...draggedField.value
            };
            form.value.fields.splice(index, 0, newField);
        } else {
            const [movedField] = form.value.fields.splice(currentIndex, 1);
            form.value.fields.splice(index, 0, movedField);
        }
        
        draggedField.value = null;
        dragOverIndex.value = null;
    };

    const createNewField = (type) => {
        return {
            type,
            name: `field_${Date.now()}`,
            label: `New ${type.charAt(0).toUpperCase() + type.slice(1)} Field`,
            placeholder: '',
            is_required: false,
            options: (type === 'select' || type === 'radio') ? [{ value: 'Option 1' }] : undefined,
            order: form.value.fields.length + 1,
            showOptions: type === 'select' || type === 'radio'
        };
    };

    const updateFieldOrders = () => {
        form.value.fields.forEach((field, index) => {
            field.order = index + 1;
        });
    };

    const removeField = (index) => {
        form.value.fields.splice(index, 1);
        updateFieldOrders();
    };

    const sanitizeFieldName = (fieldName) => {
        return fieldName.replace(/[^a-zA-Z0-9_]/g, '_');
    };

    const saveForm = async () => {
        if (!form.value.title) {
            alert('Please enter a form title');
            return;
        }

        for (const field of form.value.fields) {
            field.name = sanitizeFieldName(field.name);
            if (!field.name || !/^[a-zA-Z_][a-zA-Z0-9_]*$/.test(field.name)) {
                alert(`Invalid field name: ${field.name}. Field names must start with a letter or underscore and contain only letters, numbers, and underscores.`);
                return;
            }
        }

        const fieldNames = new Set();
        for (const field of form.value.fields) {
            if (fieldNames.has(field.name)) {
                alert(`Duplicate field name: ${field.name}. Field names must be unique.`);
                return;
            }
            fieldNames.add(field.name);
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const url = form.value.id
                ? route('forms.update', { form: form.value.id })
                : route('forms.store');

            await router[form.value.id ? 'put' : 'post'](url, {
                ...form.value,
                fields: form.value.fields.map(field => ({
                    ...field
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

    // Watch for props changes
    watch(() => props.form, (newForm) => {
        form.value = newForm || {
            title: '',
            description: '',
            method: '',
            action: '',
            is_active: true,
            fields: []
        };

        form.value.fields = form.value.fields || [];
        form.value.fields.forEach(field => {
            field.showOptions = Boolean(field.options?.length);
        });
    }, { immediate: true });

    // Watch for JSON config changes
    watch(jsonConfig, (newJson) => {
        try {
            const newForm = JSON.parse(newJson);
            const validation = validateFormJson(newForm);
            
            jsonWarnings.value = validation.warnings;
            
            if (!validation.isValid) {
                jsonError.value = validation.error;
                return;
            }

            form.value = {
                ...newForm,
                id: form.value.id,
                created_at: form.value.created_at,
                updated_at: form.value.updated_at,
            };
            form.value.fields = form.value.fields.map((field, index) => ({
                ...field,
                id: newForm.fields[index]?.id || field.id,
            }));
            jsonError.value = '';
        } catch (error) {
            jsonError.value = 'Invalid JSON syntax';
            jsonWarnings.value = [];
        }
    });

    return {
        fieldTypes,
        form,
        isJsonEditorVisible,
        jsonConfig,
        jsonError,
        jsonWarnings,
        draggedField,
        dragOverIndex,
        toggleJsonEditor,
        resetJsonConfig,
        onDragStart,
        onDragEnd,
        onDragOver,
        onDrop,
        removeField,
        saveForm
    };
};
