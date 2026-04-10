<?php

namespace App\Livewire\Admin\Portfolio;

use App\Models\MediaAsset;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Media library')]
class MediaLibrary extends Component
{
    use WithFileUploads;
    use WithPagination;

    /** @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $uploads = [];

    public function mount(): void
    {
        $this->authorize('viewAny', MediaAsset::class);
    }

    public function saveUploads(): void
    {
        $this->authorize('create', MediaAsset::class);

        $this->validate([
            'uploads' => ['required', 'array', 'min:1'],
            'uploads.*' => ['file', 'max:12288'],
        ]);

        foreach ($this->uploads as $file) {
            $path = $file->store('media', 'public');
            MediaAsset::query()->create([
                'user_id' => Auth::id(),
                'disk' => 'public',
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'folder' => 'media',
            ]);
        }

        $this->reset('uploads');
        Flux::toast(variant: 'success', text: __('Files uploaded.'));
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $asset = MediaAsset::query()->findOrFail($id);
        $this->authorize('delete', $asset);
        Storage::disk($asset->disk)->delete($asset->path);
        $asset->delete();
        Flux::toast(variant: 'success', text: __('File removed.'));
        $this->resetPage();
    }

    public function render()
    {
        $assets = MediaAsset::query()->latest()->paginate(20);

        return view('livewire.admin.portfolio.media-library', [
            'assets' => $assets,
        ]);
    }
}
