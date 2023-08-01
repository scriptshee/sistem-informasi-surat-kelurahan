<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportSuratKeluarResource\Pages;
use App\Filament\Resources\ReportSuratKeluarResource\RelationManagers;
use App\Models\Surat\Keluar;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportSuratKeluarResource extends Resource
{
    protected static ?string $model = Keluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';
    protected static ?string $navigationLabel = 'Surat Keluar';
    protected static ?string $label = 'ReportSuratKeluar';
    protected static ?string $navigationGroup = 'Laporan';
    public static ?string $slug = 'reportSuratKeluar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->sortable(),
                TextColumn::make('perihal')
                    ->searchable(),
                TextColumn::make('tujuan'),
                TextColumn::make('status')
                ->sortable()
                ->enum([
                    'new' => 'Baru',
                    'process' => 'Proses',
                    'finish' => 'Selesai'
                ]),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Print')
                    ->label('')
                    ->icon('heroicon-s-printer')
                    ->url(fn ($record): string => url(sprintf("/storage/%s", $record->file))),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportSuratKeluars::route('/'),
            // 'create' => Pages\CreateReportSuratKeluar::route('/create'),
            // 'edit' => Pages\EditReportSuratKeluar::route('/{record}/edit'),
        ];
    }
}
