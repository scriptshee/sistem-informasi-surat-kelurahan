<?php

namespace App\Filament\Resources\SuratKeluarResource\Widgets;

use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Surat\Keluar as SuratKeluar;
use Filament\Tables\Columns\TextColumn;

class SuratKeluarNew extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return SuratKeluar::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')->date(),
            TextColumn::make('perihal'),
            TextColumn::make('tujuan'),
            TextColumn::make('status'),
        ];
    }
}
