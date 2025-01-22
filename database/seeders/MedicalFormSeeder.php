<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class MedicalFormSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = time();
        $forms = [
            [
                'title' => 'Patient Registration Form',
                'method' => 'POST',
                'action' => '/submit',
                'is_active' => true,
                'fields' => [
                    // Personal Information
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_1',
                        'label' => 'Full Legal Name',
                        'placeholder' => 'Enter your full legal name',
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_2',
                        'label' => 'Date of Birth',
                        'placeholder' => 'MM/DD/YYYY',
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_3',
                        'label' => 'Gender',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Male'],
                            ['value' => 'Female'],
                            ['value' => 'Other'],
                            ['value' => 'Prefer not to say'],
                        ],
                        'order' => 3,
                        'showOptions' => true,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_4',
                        'label' => 'Social Security Number',
                        'placeholder' => 'XXX-XX-XXXX',
                        'is_required' => true,
                        'order' => 4,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_5',
                        'label' => 'Marital Status',
                        'placeholder' => 'Enter marital status',
                        'is_required' => true,
                        'order' => 5,
                    ],

                    // Contact Information
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_6',
                        'label' => 'Street Address',
                        'placeholder' => 'Enter your street address',
                        'is_required' => true,
                        'order' => 6,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_7',
                        'label' => 'City',
                        'placeholder' => 'Enter city',
                        'is_required' => true,
                        'order' => 7,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_8',
                        'label' => 'State/Province',
                        'placeholder' => 'Enter state/province',
                        'is_required' => true,
                        'order' => 8,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_9',
                        'label' => 'Postal Code',
                        'placeholder' => 'Enter postal code',
                        'is_required' => true,
                        'order' => 9,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_10',
                        'label' => 'Home Phone',
                        'placeholder' => 'Enter home phone',
                        'is_required' => false,
                        'order' => 10,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_11',
                        'label' => 'Mobile Phone',
                        'placeholder' => 'Enter mobile phone',
                        'is_required' => true,
                        'order' => 11,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'field_'.$timestamp.'_12',
                        'label' => 'Email Address',
                        'placeholder' => 'Enter email address',
                        'is_required' => true,
                        'order' => 12,
                    ],

                    // Emergency Contact
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_13',
                        'label' => 'Emergency Contact Name',
                        'placeholder' => 'Enter emergency contact name',
                        'is_required' => true,
                        'order' => 13,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_14',
                        'label' => 'Emergency Contact Phone',
                        'placeholder' => 'Enter emergency contact phone',
                        'is_required' => true,
                        'order' => 14,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_15',
                        'label' => 'Relationship to Patient',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Spouse'],
                            ['value' => 'Parent'],
                            ['value' => 'Child'],
                            ['value' => 'Sibling'],
                            ['value' => 'Friend'],
                            ['value' => 'Other'],
                        ],
                        'order' => 15,
                        'showOptions' => true,
                    ],

                    // Insurance Information
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_16',
                        'label' => 'Insurance Provider',
                        'placeholder' => 'Enter insurance provider name',
                        'is_required' => true,
                        'order' => 16,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_17',
                        'label' => 'Policy Number',
                        'placeholder' => 'Enter policy number',
                        'is_required' => true,
                        'order' => 17,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_18',
                        'label' => 'Group Number',
                        'placeholder' => 'Enter group number',
                        'is_required' => true,
                        'order' => 18,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_19',
                        'label' => 'Policy Holder Name',
                        'placeholder' => 'Enter policy holder name',
                        'is_required' => true,
                        'order' => 19,
                    ],

                    // Medical History
                    [
                        'type' => 'textarea',
                        'name' => 'field_'.$timestamp.'_20',
                        'label' => 'Current Medications',
                        'placeholder' => 'List all current medications and dosages',
                        'is_required' => true,
                        'order' => 20,
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'field_'.$timestamp.'_21',
                        'label' => 'Allergies',
                        'placeholder' => 'List any known allergies',
                        'is_required' => true,
                        'order' => 21,
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'field_'.$timestamp.'_23',
                        'label' => 'Previous Surgeries',
                        'placeholder' => 'List any previous surgeries and dates',
                        'is_required' => false,
                        'order' => 23,
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'field_'.$timestamp.'_24',
                        'label' => 'Family Medical History',
                        'placeholder' => 'Describe relevant family medical history',
                        'is_required' => true,
                        'order' => 24,
                    ],

                    // Lifestyle Information
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_25',
                        'label' => 'Smoking Status',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Never Smoked'],
                            ['value' => 'Former Smoker'],
                            ['value' => 'Current Smoker'],
                        ],
                        'order' => 25,
                        'showOptions' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_26',
                        'label' => 'Alcohol Consumption',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Never'],
                            ['value' => 'Occasionally'],
                            ['value' => 'Regularly'],
                            ['value' => 'Daily'],
                        ],
                        'order' => 26,
                        'showOptions' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_27',
                        'label' => 'Exercise Frequency',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Never'],
                            ['value' => '1-2 times per week'],
                            ['value' => '3-4 times per week'],
                            ['value' => '5+ times per week'],
                        ],
                        'order' => 27,
                        'showOptions' => true,
                    ],
                ],
            ],
        ];

        foreach ($forms as $formData) {
            $form = Form::create([
                'title' => $formData['title'],
                'method' => $formData['method'],
                'action' => $formData['action'],
                'is_active' => $formData['is_active'],
            ]);

            foreach ($formData['fields'] as $field) {
                FormField::create([
                    'form_id' => $form->id,
                    'type' => $field['type'],
                    'name' => $field['name'],
                    'label' => $field['label'],
                    'placeholder' => $field['placeholder'],
                    'is_required' => $field['is_required'],
                    'options' => isset($field['options']) ? $field['options'] : null,
                    'order' => $field['order'],
                ]);
            }
        }
    }
}
