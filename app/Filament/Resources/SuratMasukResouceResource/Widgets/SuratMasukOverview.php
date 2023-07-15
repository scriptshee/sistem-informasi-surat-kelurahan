<?php

namespace App\Filament\Resources\SuratMasukResouceResource\Widgets;

use App\Models\Surat\Masuk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SuratMasukOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $totalSuratMasuk = Masuk::count();
        $totalDisposisi = Masuk::where('status', 'disposition')->count();
        $totalDisposisi = Masuk::where('status', 'disposition')->count();
        $totalRejected = Masuk::where('status', 'rejected')->count();
        $totalFinish = Masuk::where('status', 'finis')->count();
        return [
            Card::make('Surat Masuk', $totalSuratMasuk),
            Card::make('Disposisi', $totalDisposisi),
            Card::make('Finish', $totalFinish),
            Card::make('Rejected', $totalRejected),
        ];
    }
}
