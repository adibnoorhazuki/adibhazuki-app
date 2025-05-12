<?php

namespace App\Livewire;

use App\Actions\FileUpload\StoreFileUploadAction;
use App\Actions\FileUpload\UpdateFileUploadAction;
use App\Imports\ProductsImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadResource extends Component
{
    use WithFileUploads;

    public $showForm = false;
    public $showSuccessModal = false;
    public $file;

    protected $rules = [
        'file' => 'required|file|max:102400', // 100MB max
    ];

    public function openModal() { $this->showForm = true; }
    public function closeModal() { $this->reset(['showForm', 'file']); }
    public function closeSuccessModal() { $this->showSuccessModal = false; }

    public function render()
    {
        return view('livewire.file-upload-resource');
    }

    public function submit()
    {
        sleep(3);
        $this->validate();

        $object = (new StoreFileUploadAction())->execute($this->file);

        Excel::import(new ProductsImport($object), $this->file);

        $this->closeModal();

        $this->showSuccessModal = true;
    }
}
