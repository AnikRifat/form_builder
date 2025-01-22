<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class BusinessFormSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = time();
        $forms = [
            [
                'title' => 'Business Loan Application',
                'method' => 'POST',
                'action' => '/submit',
                'is_active' => true,
                'fields' => [
                    // Business Information
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_1',
                        'label' => 'Business Legal Name',
                        'placeholder' => 'Enter your business legal name',
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_2',
                        'label' => 'Trading Name (if different)',
                        'placeholder' => 'Enter your trading name',
                        'is_required' => false,
                        'order' => 2,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_3',
                        'label' => 'Business Registration Number',
                        'placeholder' => 'Enter registration number',
                        'is_required' => true,
                        'order' => 3,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_4',
                        'label' => 'Tax ID Number',
                        'placeholder' => 'Enter tax ID',
                        'is_required' => true,
                        'order' => 4,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_' . $timestamp . '_5',
                        'label' => 'Business Structure',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Sole Proprietorship'],
                            ['value' => 'Partnership'],
                            ['value' => 'Limited Liability Company (LLC)'],
                            ['value' => 'Corporation'],
                            ['value' => 'Non-Profit']
                        ],
                        'order' => 5,
                        'showOptions' => true
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_6',
                        'label' => 'Years in Business',
                        'placeholder' => 'Enter number of years',
                        'is_required' => true,
                        'order' => 6,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_' . $timestamp . '_7',
                        'label' => 'Industry',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Technology'],
                            ['value' => 'Retail'],
                            ['value' => 'Manufacturing'],
                            ['value' => 'Healthcare'],
                            ['value' => 'Construction'],
                            ['value' => 'Food & Beverage'],
                            ['value' => 'Professional Services'],
                            ['value' => 'Other']
                        ],
                        'order' => 7,
                        'showOptions' => true
                    ],
                    // Contact Information
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_8',
                        'label' => 'Business Address',
                        'placeholder' => 'Enter street address',
                        'is_required' => true,
                        'order' => 8,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_9',
                        'label' => 'City',
                        'placeholder' => 'Enter city',
                        'is_required' => true,
                        'order' => 9,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_10',
                        'label' => 'State/Province',
                        'placeholder' => 'Enter state/province',
                        'is_required' => true,
                        'order' => 10,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_11',
                        'label' => 'Postal Code',
                        'placeholder' => 'Enter postal code',
                        'is_required' => true,
                        'order' => 11,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_12',
                        'label' => 'Business Phone',
                        'placeholder' => 'Enter business phone',
                        'is_required' => true,
                        'order' => 12,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'field_' . $timestamp . '_13',
                        'label' => 'Business Email',
                        'placeholder' => 'Enter business email',
                        'is_required' => true,
                        'order' => 13,
                    ],
                    // Loan Information
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_14',
                        'label' => 'Requested Loan Amount',
                        'placeholder' => 'Enter amount in dollars',
                        'is_required' => true,
                        'order' => 14,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_' . $timestamp . '_15',
                        'label' => 'Loan Purpose',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Working Capital'],
                            ['value' => 'Equipment Purchase'],
                            ['value' => 'Expansion'],
                            ['value' => 'Inventory'],
                            ['value' => 'Debt Refinancing'],
                            ['value' => 'Real Estate'],
                            ['value' => 'Other']
                        ],
                        'order' => 15,
                        'showOptions' => true
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_' . $timestamp . '_16',
                        'label' => 'Desired Loan Term',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => '6 months'],
                            ['value' => '12 months'],
                            ['value' => '24 months'],
                            ['value' => '36 months'],
                            ['value' => '48 months'],
                            ['value' => '60 months']
                        ],
                        'order' => 16,
                        'showOptions' => true
                    ],
                    // Financial Information
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_17',
                        'label' => 'Annual Revenue',
                        'placeholder' => 'Enter last year\'s revenue',
                        'is_required' => true,
                        'order' => 17,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_18',
                        'label' => 'Monthly Revenue',
                        'placeholder' => 'Enter average monthly revenue',
                        'is_required' => true,
                        'order' => 18,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_19',
                        'label' => 'Current Outstanding Loans',
                        'placeholder' => 'Enter total amount',
                        'is_required' => true,
                        'order' => 19,
                    ],
                    // Additional Information
                    [
                        'type' => 'textarea',
                        'name' => 'field_' . $timestamp . '_20',
                        'label' => 'Business Description',
                        'placeholder' => 'Describe your business operations and history',
                        'is_required' => true,
                        'order' => 20,
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'field_' . $timestamp . '_21',
                        'label' => 'Loan Usage Details',
                        'placeholder' => 'Explain how you plan to use the loan',
                        'is_required' => true,
                        'order' => 21,
                    ],
                ]
            ]
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
