<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class BasicFormSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = time();
        $forms = [
            [
                'title' => 'Contact Form',
                'method' => 'POST',
                'action' => '/submit',
                'is_active' => true,
                'fields' => [
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_1',
                        'label' => 'Full Name',
                        'placeholder' => 'Enter your full name',
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'field_'.$timestamp.'_2',
                        'label' => 'Email Address',
                        'placeholder' => 'Enter your email',
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_3',
                        'label' => 'Phone Number',
                        'placeholder' => 'Enter your phone number',
                        'is_required' => false,
                        'order' => 3,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_4',
                        'label' => 'Department',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Sales'],
                            ['value' => 'Support'],
                            ['value' => 'Technical'],
                            ['value' => 'Billing'],
                            ['value' => 'Other'],
                        ],
                        'order' => 4,
                        'showOptions' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_5',
                        'label' => 'Priority',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Low'],
                            ['value' => 'Medium'],
                            ['value' => 'High'],
                            ['value' => 'Urgent'],
                        ],
                        'order' => 5,
                        'showOptions' => true,
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'field_'.$timestamp.'_6',
                        'label' => 'Message',
                        'placeholder' => 'Please describe your inquiry in detail',
                        'is_required' => true,
                        'order' => 6,
                    ],

                ],
            ],
            [
                'title' => 'Newsletter Subscription',
                'method' => 'POST',
                'action' => '/submit',
                'is_active' => true,
                'fields' => [
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_8',
                        'label' => 'Full Name',
                        'placeholder' => 'Enter your full name',
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'field_'.$timestamp.'_9',
                        'label' => 'Email Address',
                        'placeholder' => 'Enter your email',
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_10',
                        'label' => 'Email Format',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'HTML'],
                            ['value' => 'Plain Text'],
                        ],
                        'order' => 3,
                        'showOptions' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_11',
                        'label' => 'Frequency',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Daily Digest'],
                            ['value' => 'Weekly Newsletter'],
                            ['value' => 'Monthly Updates'],
                            ['value' => 'Quarterly Review'],
                        ],
                        'order' => 4,
                        'showOptions' => true,
                    ],

                ],
            ],
            [
                'title' => 'Event Registration',
                'method' => 'POST',
                'action' => '/submit',
                'is_active' => true,
                'fields' => [
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_14',
                        'label' => 'Full Name',
                        'placeholder' => 'Enter your full name',
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'field_'.$timestamp.'_15',
                        'label' => 'Email Address',
                        'placeholder' => 'Enter your email',
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_16',
                        'label' => 'Phone Number',
                        'placeholder' => 'Enter your phone number',
                        'is_required' => true,
                        'order' => 3,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'field_'.$timestamp.'_17',
                        'label' => 'Company/Organization',
                        'placeholder' => 'Enter your company name',
                        'is_required' => false,
                        'order' => 4,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_18',
                        'label' => 'Event Type',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Conference'],
                            ['value' => 'Workshop'],
                            ['value' => 'Webinar'],
                            ['value' => 'Training'],
                        ],
                        'order' => 5,
                        'showOptions' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_'.$timestamp.'_19',
                        'label' => 'Session Time',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Morning Session (9 AM - 12 PM)'],
                            ['value' => 'Afternoon Session (2 PM - 5 PM)'],
                            ['value' => 'Evening Session (6 PM - 9 PM)'],
                        ],
                        'order' => 6,
                        'showOptions' => true,
                    ],

                    [
                        'type' => 'textarea',
                        'name' => 'field_'.$timestamp.'_21',
                        'label' => 'Special Requests',
                        'placeholder' => 'Enter any special requests or requirements',
                        'is_required' => false,
                        'order' => 8,
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
