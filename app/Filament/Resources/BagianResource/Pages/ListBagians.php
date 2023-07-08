<?php

namespace App\Filament\Resources\BagianResource\Pages;

use App\Filament\Resources\BagianResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBagians extends ListRecords
{
    protected static string $resource = BagianResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
