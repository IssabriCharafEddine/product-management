<?php

namespace App\Services\ProductImport;

use Illuminate\Support\Facades\Storage;

namespace App\Services\ProductImport;

use Illuminate\Support\Facades\Storage;

class CsvProductImporter implements ProductImporterInterface
{
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function import(): array
    {
        $products = [];
        $handle = fopen(Storage::path($this->filePath), 'r');

        fgetcsv($handle);

        while (($data = fgetcsv($handle)) !== false) {
            $products[] = [
                'sku' => $data[2],
                'name' => $data[1],
                'status' => $data[7] ?? null,
                'price' => (empty($data[3]) || strtolower($data[3]) === 'null') ? null : $data[3],
                'currency' => $data[4],
                'variations' => json_decode($data[5] ?? '[]', true)
            ];
        }

        fclose($handle);
        return $products;
    }
}
