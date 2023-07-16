<?php

namespace App\Filament\Resources\ReportSuratMasukResource\Pages;

use App\Filament\Resources\ReportSuratMasukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportSuratMasuk extends EditRecord
{
    protected static string $resource = ReportSuratMasukResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
