<?php

namespace App\Livewire\Admin\Portfolio;

use App\Enums\InquiryStatus;
use App\Models\ContactInquiry;
use Flux\Flux;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Contact inquiries')]
class InquiriesManager extends Component
{
    use WithPagination;

    public string $search = '';

    public function mount(): void
    {
        $this->authorize('viewAny', ContactInquiry::class);
    }

    public function markRead(int $id): void
    {
        $inquiry = ContactInquiry::query()->findOrFail($id);
        $this->authorize('update', $inquiry);
        $inquiry->update([
            'status' => InquiryStatus::Read,
            'read_at' => now(),
        ]);
        Flux::toast(variant: 'success', text: __('Marked as read.'));
    }

    public function archive(int $id): void
    {
        $inquiry = ContactInquiry::query()->findOrFail($id);
        $this->authorize('update', $inquiry);
        $inquiry->update(['status' => InquiryStatus::Archived]);
        Flux::toast(variant: 'success', text: __('Archived.'));
    }

    public function render()
    {
        $inquiries = ContactInquiry::query()
            ->when($this->search !== '', function ($q): void {
                $q->where(function ($q): void {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('body', 'like', '%'.$this->search.'%');
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.portfolio.inquiries-manager', [
            'inquiries' => $inquiries,
        ]);
    }
}
