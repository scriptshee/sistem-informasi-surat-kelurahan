<?php

namespace App\Filament\Resources\BagianResource\Pages;

use App\Filament\Resources\BagianResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBagian extends CreateRecord
{
    protected static string $resource = BagianResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
