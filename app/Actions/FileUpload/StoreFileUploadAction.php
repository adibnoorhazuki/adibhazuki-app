<?php

namespace App\Actions\FileUpload;

use App\Models\FileUpload;

class StoreFileUploadAction
{
    public function execute($file)
    {
        $object = new FileUpload();
        $object->time = now();
        $object->file_name = $file->getClientOriginalName();
        $object->status = 'pending';
        $object->save();

        return $object;
    }
}

