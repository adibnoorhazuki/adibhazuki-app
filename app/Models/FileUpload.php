<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    /** @use HasFactory<\Database\Factories\FileUploadFactory> */
    use HasFactory;

    public const STATUSES = ['pending', 'processing', 'failed', 'completed'];

    protected $fillable = [
        'time',
        'file_name',
        'status'
    ];

    protected $dates = [
        'time',
        'created_at',
        'updated_at',
    ];
}
