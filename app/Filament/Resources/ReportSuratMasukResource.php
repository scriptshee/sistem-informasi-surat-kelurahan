<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportSuratMasukResource\Pages;
use App\Filament\Resources\ReportSuratMasukResource\RelationManagers;
use App\Models\Surat\Masuk as ReportSuratMasuk;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportSuratMasukResource extends Resource
{
    protected static ?string $model = ReportSuratMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-in';
    protected static ?string $navigationLabel = 'Surat Masuk';
    protected static ?string $label = 'ReportSuratMasuk';
    protected static ?string $navigationGroup = 'Laporan';
    public static ?string $slug = 'reportSuratMasuk';

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
                    ->label('Dibuat'),
                TextColumn::make('updated_at')
                    ->label('Diupdate'),
                TextColumn::make('perihal')
                    ->searchable(),
                TextColumn::make('pengirim'),
                TextColumn::make('status')

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
            'index' => Pages\ListReportSuratMasuks::route('/'),
            // 'create' => Pages\CreateReportSuratMasuk::route('/create'),
            // 'edit' => Pages\EditReportSuratMasuk::route('/{record}/edit'),
        ];
    }
}
