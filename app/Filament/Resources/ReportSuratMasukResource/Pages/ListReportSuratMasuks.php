<?php

namespace App\Filament\Resources\ReportSuratMasukResource\Pages;

use App\Filament\Resources\ReportSuratMasukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportSuratMasuks extends ListRecords
{
    protected static string $resource = ReportSuratMasukResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
