<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Contact Form
        $contactForm = Form::create([
            'title' => 'Contact Form',
            'method' => 'POST',
            'action' => '/contact',
            'is_active' => true,
        ]);

        $this->createFormFields($contactForm->id, [
            ['type' => 'text', 'name' => 'name', 'label' => 'Full Name', 'placeholder' => 'Enter your name', 'is_required' => true],
            ['type' => 'email', 'name' => 'email', 'label' => 'Email Address', 'placeholder' => 'Enter your email', 'is_required' => true],
            ['type' => 'textarea', 'name' => 'message', 'label' => 'Message', 'placeholder' => 'Your message here', 'is_required' => true],
        ]);

        // 2. Newsletter Subscription Form
        $newsletterForm = Form::create([
            'title' => 'Newsletter Subscription',
            'method' => 'POST',
            'action' => '/subscribe',
            'is_active' => true,
        ]);

        $this->createFormFields($newsletterForm->id, [
            ['type' => 'text', 'name' => 'name', 'label' => 'Name', 'placeholder' => 'Your name', 'is_required' => true],
            ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'placeholder' => 'Your email address', 'is_required' => true],
            ['type' => 'select', 'name' => 'frequency', 'label' => 'Email Frequency', 'is_required' => true, 'options' => json_encode(['Daily', 'Weekly', 'Monthly'])],
            ['type' => 'checkbox', 'name' => 'terms', 'label' => 'I agree to receive newsletters', 'is_required' => true],
        ]);

        // 3. Survey Form
        $surveyForm = Form::create([
            'title' => 'Customer Feedback Survey',
            'method' => 'POST',
            'action' => '/survey',
            'is_active' => true,
        ]);

        $this->createFormFields($surveyForm->id, [
            ['type' => 'text', 'name' => 'name', 'label' => 'Name', 'placeholder' => 'Your name', 'is_required' => false],
            ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'placeholder' => 'Your email', 'is_required' => true],
            ['type' => 'select', 'name' => 'age_group', 'label' => 'Age Group', 'is_required' => true, 'options' => json_encode(['18-24', '25-34', '35-44', '45-54', '55+'])],
            ['type' => 'radio', 'name' => 'satisfaction', 'label' => 'Overall Satisfaction', 'is_required' => true, 'options' => json_encode(['Very Satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very Dissatisfied'])],
            ['type' => 'checkbox', 'name' => 'improvements', 'label' => 'Areas for Improvement', 'is_required' => false, 'options' => json_encode(['Service', 'Product Quality', 'Price', 'Support', 'Website'])],
            ['type' => 'textarea', 'name' => 'comments', 'label' => 'Additional Comments', 'placeholder' => 'Please share any additional feedback', 'is_required' => false],
        ]);

        // 4. Event Registration Form
        $eventForm = Form::create([
            'title' => 'Event Registration',
            'method' => 'POST',
            'action' => '/event-register',
            'is_active' => true,
        ]);

        $this->createFormFields($eventForm->id, [
            ['type' => 'text', 'name' => 'name', 'label' => 'Attendee Name', 'placeholder' => 'Your name', 'is_required' => true],
            ['type' => 'email', 'name' => 'email', 'label' => 'Email Address', 'placeholder' => 'Your email', 'is_required' => true],
            ['type' => 'select', 'name' => 'ticket_type', 'label' => 'Ticket Type', 'is_required' => true, 'options' => json_encode(['Standard', 'VIP', 'Group'])],
            ['type' => 'radio', 'name' => 'attendance', 'label' => 'Attendance Type', 'is_required' => true, 'options' => json_encode(['In Person', 'Virtual'])],
            ['type' => 'checkbox', 'name' => 'preferences', 'label' => 'Special Requirements', 'is_required' => false, 'options' => json_encode(['Vegetarian Meal', 'Wheelchair Access', 'Parking', 'Hotel Booking'])],
            ['type' => 'textarea', 'name' => 'special_requests', 'label' => 'Special Requests', 'placeholder' => 'Any special requests or notes', 'is_required' => false],
        ]);

        // 5. Product Review Form
        $reviewForm = Form::create([
            'title' => 'Product Review',
            'method' => 'POST',
            'action' => '/review',
            'is_active' => true,
        ]);

        $this->createFormFields($reviewForm->id, [
            ['type' => 'text', 'name' => 'name', 'label' => 'Your Name', 'placeholder' => 'Enter your name', 'is_required' => true],
            ['type' => 'email', 'name' => 'email', 'label' => 'Email Address', 'placeholder' => 'Enter your email', 'is_required' => true],
            ['type' => 'select', 'name' => 'product', 'label' => 'Select Product', 'is_required' => true, 'options' => json_encode(['Product A', 'Product B', 'Product C', 'Product D'])],
            ['type' => 'radio', 'name' => 'rating', 'label' => 'Rating', 'is_required' => true, 'options' => json_encode(['5 Stars', '4 Stars', '3 Stars', '2 Stars', '1 Star'])],
            ['type' => 'checkbox', 'name' => 'features', 'label' => 'Best Features', 'is_required' => false, 'options' => json_encode(['Quality', 'Price', 'Design', 'Functionality', 'Support'])],
            ['type' => 'textarea', 'name' => 'review', 'label' => 'Your Review', 'placeholder' => 'Write your detailed review here', 'is_required' => true],
        ]);
    }

    private function createFormFields($formId, $fields)
    {
        foreach ($fields as $index => $field) {
            FormField::create([
                'form_id' => $formId,
                'type' => $field['type'],
                'name' => $field['name'],
                'label' => $field['label'],
                'placeholder' => $field['placeholder'] ?? null,
                'is_required' => $field['is_required'],
                'options' => $field['options'] ?? null,
                'order' => $index,
            ]);
        }
    }
}
