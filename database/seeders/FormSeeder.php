<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
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
                        'name' => 'field_' . $timestamp . '_1',
                        'label' => 'Full Name',
                        'placeholder' => 'Enter your full name',
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'field_' . $timestamp . '_2',
                        'label' => 'Email Address',
                        'placeholder' => 'Enter your email',
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_' . $timestamp . '_3',
                        'label' => 'Subject',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'General Inquiry'],
                            ['value' => 'Support'],
                            ['value' => 'Feedback']
                        ],
                        'order' => 3,
                        'showOptions' => true
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'field_' . $timestamp . '_4',
                        'label' => 'Message',
                        'placeholder' => 'Write your message here',
                        'is_required' => true,
                        'order' => 4,
                    ]
                ]
            ],
            [
                'title' => 'Job Application',
                'method' => 'POST',
                'action' => '/submit',
                'is_active' => true,
                'fields' => [
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_5',
                        'label' => 'Full Name',
                        'placeholder' => 'Enter your full name',
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'field_' . $timestamp . '_6',
                        'label' => 'Email Address',
                        'placeholder' => 'Enter your email',
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_' . $timestamp . '_7',
                        'label' => 'Position',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Frontend Developer'],
                            ['value' => 'Backend Developer'],
                            ['value' => 'Full Stack Developer'],
                            ['value' => 'UI/UX Designer']
                        ],
                        'order' => 3,
                        'showOptions' => true
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_' . $timestamp . '_8',
                        'label' => 'Experience Level',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Entry Level'],
                            ['value' => 'Mid Level'],
                            ['value' => 'Senior Level']
                        ],
                        'order' => 4,
                        'showOptions' => true
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'field_' . $timestamp . '_10',
                        'label' => 'Cover Letter',
                        'placeholder' => 'Tell us about yourself',
                        'is_required' => true,
                        'order' => 6,
                    ]
                ]
            ],
            [
                'title' => 'Event Registration',
                'method' => 'POST',
                'action' => '/submit',
                'is_active' => true,
                'fields' => [
                    [
                        'type' => 'text',
                        'name' => 'field_' . $timestamp . '_11',
                        'label' => 'Attendee Name',
                        'placeholder' => 'Enter your name',
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'field_' . $timestamp . '_12',
                        'label' => 'Email',
                        'placeholder' => 'Enter your email',
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'field_' . $timestamp . '_13',
                        'label' => 'Ticket Type',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'Regular'],
                            ['value' => 'VIP'],
                            ['value' => 'Student']
                        ],
                        'order' => 3,
                        'showOptions' => true
                    ],
                    [
                        'type' => 'radio',
                        'name' => 'field_' . $timestamp . '_14',
                        'label' => 'Attendance Mode',
                        'placeholder' => '',
                        'is_required' => true,
                        'options' => [
                            ['value' => 'In Person'],
                            ['value' => 'Virtual']
                        ],
                        'order' => 4,
                        'showOptions' => true
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
