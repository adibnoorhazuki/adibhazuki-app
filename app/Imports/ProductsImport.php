<?php

namespace App\Imports;

use App\Actions\FileUpload\UpdateFileUploadAction;
use App\Models\FileUpload;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\ImportFailed;

class ProductsImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading, WithEvents
{
    protected $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function model(array $row)
    {
        return Product::updateOrCreate(
            [
                'id' => $row['unique_key'],
            ],
            [
                'product_title' => $row['product_title'],
                'product_description' => $row['product_description'],
                'style' => $row['style'],
                'sanmar_mainframe_color' => $row['sanmar_mainframe_color'],
                'size' => $row['size'],
                'color_name' => $row['color_name'],
                'piece_price' => $row['piece_price'],
            ]
        );
    }

    public function batchSize(): int
    {
        return 2;
    }

    public function uniqueBy()
    {
        return 'id';
    }

    public function chunkSize(): int
    {
        return 2;
    }

    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeImport::class => function(BeforeImport $event) {
                (new UpdateFileUploadAction())->execute($this->object, 'processing');
            },

            AfterImport::class => function(AfterImport $event) {
                (new UpdateFileUploadAction())->execute($this->object, 'completed');
            },

            ImportFailed::class => function(ImportFailed $event) {
                (new UpdateFileUploadAction())->execute($this->object, 'failed');
            }

        ];
    }
}
