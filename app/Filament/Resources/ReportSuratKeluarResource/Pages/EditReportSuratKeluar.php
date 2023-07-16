<?php

namespace App\Filament\Resources\ReportSuratKeluarResource\Pages;

use App\Filament\Resources\ReportSuratKeluarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportSuratKeluar extends EditRecord
{
    protected static string $resource = ReportSuratKeluarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
