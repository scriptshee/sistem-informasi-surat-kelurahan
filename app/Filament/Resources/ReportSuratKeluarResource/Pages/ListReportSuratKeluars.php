<?php

namespace App\Filament\Resources\ReportSuratKeluarResource\Pages;

use App\Filament\Resources\ReportSuratKeluarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportSuratKeluars extends ListRecords
{
    protected static string $resource = ReportSuratKeluarResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
