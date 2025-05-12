<?php

namespace App\Actions\FileUpload;

class UpdateFileUploadAction
{
    public function execute($object, $status)
    {

        $object->time = now();
        $object->status = $status;
        $object->save();

        return $object;
    }
}
