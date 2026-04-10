<?php

namespace App\Livewire\Portfolio;

use App\Enums\InquiryStatus;
use App\Models\ContactInquiry;
use Flux\Flux;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $body = '';

    public function submit(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        ContactInquiry::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone !== '' ? $this->phone : null,
            'body' => $this->body,
            'status' => InquiryStatus::New,
        ]);

        Flux::toast(variant: 'success', text: __('Thanks — your message was sent.'));

        $this->reset('name', 'email', 'phone', 'body');
    }

    public function render()
    {
        return view('livewire.portfolio.contact-form');
    }
}
