import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { Form, FormField } from '@/types/form';

interface DraggedField {
    id?: number;
    type: string;
    label: string;
    name?: string;
    placeholder?: string;
    is_required?: boolean;
    options?: { value: string }[];
    showOptions?: boolean;
}

export const useFormBuilder = (props: { form: Form }) => {
    const fieldTypes = [
        { type: 'text', label: 'Text Input' },
        { type: 'email', label: 'Email Input' },
        { type: 'textarea', label: 'Text Area' },
        { type: 'select', label: 'Select Box' },
        { type: 'radio', label: 'Radio Button' },
    ];

    const form = ref<Form>(props.form);
    const isJsonEditorVisible = ref(false);
    const jsonConfig = ref('');
    const jsonError = ref('');
    const jsonWarnings = ref<string[]>([]);
    const draggedField = ref<DraggedField | null>(null);
    const dragOverIndex = ref<number | null>(null);

    // Initialize form fields if empty
    if (!form.value.fields) {
        form.value.fields = [];
    }

    const createNewField = (type: string, name: string = ''): FormField => {
        return {
            id: Date.now(),
            type,
            name: name || `field_${Date.now()}`,
            label: `New ${type.charAt(0).toUpperCase() + type.slice(1)} Field`,
            placeholder: '',
            is_required: false,
            options: (type === 'select' || type === 'radio') ? [{ value: 'Option 1' }] : undefined,
            order: form.value.fields.length + 1,
            showOptions: type === 'select' || type === 'radio',
            isEditingLabel: false,
            isEditingName: false
        };
    };

    const onDragStart = (event: DragEvent, field: DraggedField) => {
        if (!event.dataTransfer) return;
        
        // Set drag effect and store field data
        event.dataTransfer.effectAllowed = 'move';
        draggedField.value = field;
        
        // Store field data as JSON string
        event.dataTransfer.setData('application/json', JSON.stringify({
            type: field.type,
            label: field.label,
            id: field.id
        }));
        
        // Add dragging class
        const target = event.target as HTMLElement;
        target.classList.add('dragging');
    };

    const onDragEnd = (event: DragEvent) => {
        const target = event.target as HTMLElement;
        target.classList.remove('dragging');
        draggedField.value = null;
        dragOverIndex.value = null;
    };

    const onDragOver = (event: DragEvent, index: number) => {
        event.preventDefault();
        event.dataTransfer!.dropEffect = 'move';
        
        // Only update dragOverIndex if it's different
        if (dragOverIndex.value !== index) {
            dragOverIndex.value = index;
        }
    };

    const onDrop = (event: DragEvent, index: number) => {
        event.preventDefault();
        
        // Reset drag state
        dragOverIndex.value = null;
        
        try {
            // Get the dragged field data
            const data = event.dataTransfer?.getData('application/json');
            if (!data) return;
            
            const draggedFieldData = JSON.parse(data);
            
            // Check if we're dragging from the palette or reordering
            if (draggedField.value) {
                if (draggedField.value.id) {
                    // Reordering existing field
                    const currentIndex = form.value.fields.findIndex(f => f.id === draggedField.value?.id);
                    if (currentIndex !== -1 && currentIndex !== index) {
                        const [movedField] = form.value.fields.splice(currentIndex, 1);
                        form.value.fields.splice(index, 0, movedField);
                    }
                } else {
                    // Creating new field from palette
                    const newField = createNewField(draggedField.value.type);
                    form.value.fields.splice(index, 0, newField);
                }
            }
            
            // Update field orders
            updateFieldOrders();
        } catch (error) {
            console.error('Error handling drop:', error);
        } finally {
            draggedField.value = null;
        }
    };

    const updateFieldOrders = () => {
        form.value.fields.forEach((field, index) => {
            field.order = index + 1;
        });
    };

    const removeField = (index: number) => {
        form.value.fields.splice(index, 1);
        updateFieldOrders();
    };

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

    const saveForm = async () => {
        if (!form.value.title) {
            alert('Please enter a form title');
            return;
        }

        try {
            const csrfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
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
