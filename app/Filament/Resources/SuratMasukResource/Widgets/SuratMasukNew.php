<?php

namespace App\Filament\Resources\SuratMasukResource\Widgets;

use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Surat\Masuk as SuratMasuk;
use Filament\Tables\Columns\TextColumn;

class SuratMasukNew extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return SuratMasuk::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
           TextColumn::make('created_at')->date(),
           TextColumn::make('perihal'),
           TextColumn::make('pengirim'),
           TextColumn::make('atas_nama'),
           TextColumn::make('status'),
        ];
    }
}
