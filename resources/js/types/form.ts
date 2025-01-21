export interface FormField {
  id?: number;
  form_id?: number;
  type: string;
  name: string;
  label: string;
  placeholder?: string;
  is_required: boolean;
  validation_rules?: any;
  options?: Record<string, any>;
  order: number;
  value?: any;
  showOptions?: boolean;
  created_at?: string;
  updated_at?: string;
  deleted_at?: string;
}

export interface Form {
  id?: number;
  title: string;
  description?: string;
  method: string;
  action: string;
  is_active: boolean;
  fields: FormField[];
  created_at?: string;
  updated_at?: string;
  deleted_at?: string;
}

export interface FormBuilderState {
  forms: Form[];
  currentForm: Form | null;
  isLoading: boolean;
  error: string | null;
}
