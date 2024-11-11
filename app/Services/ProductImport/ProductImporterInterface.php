<?php

namespace App\Services\ProductImport;

interface ProductImporterInterface
{
    public function import(): array;
}
