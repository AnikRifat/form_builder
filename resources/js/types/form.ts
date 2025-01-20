export interface Form {
    id?: number;
    title: string;
    description?: string;
    method: string;
    action: string;
    is_active: boolean;
    fields: FormField[];
}

export interface FormField {
    id?: number;
    type: string;
    name: string;
    label: string;
    placeholder?: string;
    is_required: boolean;
    validation_rules?: Record<string, any>;
    options?: Record<string, any>;
    order: number;
}

export interface FormFieldOption {
    label: string;
    value: string;
}

export interface FormValidationRules {
    required?: boolean;
    minLength?: number;
    maxLength?: number;
    pattern?: string;
    custom?: (value: any) => boolean;
}
