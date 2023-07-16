<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKeluarResource\Pages;
use App\Filament\Resources\SuratKeluarResource\RelationManagers;
use App\Models\Surat\Keluar as SuratKeluar;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SuratKeluarResource extends Resource
{
    protected static ?string $model = SuratKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';
    protected static ?string $navigationLabel = 'Surat Keluar';
    protected static ?string $navigationGroup = 'Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('perihal')
                    ->required(),
                TextInput::make('tujuan')
                    ->required(),
                Select::make('kategori_id')
                    ->required()
                    ->relationship('ketegori', 'kategori')->preload(),
                Select::make('author_id')
                    ->required()
                    ->relationship('author', 'name')->preload(),
                FileUpload::make('file')
                    ->disk('local')
                    ->directory('surat-keluar')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required()
                    ->enableDownload(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('perihal')
                    ->searchable(),
                TextColumn::make('tujuan')
                    ->searchable(),
                TextColumn::make('approve.name'),
                TextColumn::make('status')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'Baru',
                        'process' => 'Process',
                        'finish' => 'Selesai'
                    ])
            ])
            ->actions([
                Tables\Actions\Action::make('Approve')
                    ->color('success')
                    ->icon('heroicon-o-cursor-click')
                    ->action(function ($record): void {
                        $record->approved_by = Auth::user()->id;
                        $record->status = 'finish';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->disabled(fn ($record) => $record->status == 'process' ? false : true)
                    ->visible(fn () => Auth::user()->hasRole(['admin', 'lurah'])),
                Tables\Actions\Action::make('Process')
                    ->color('success')
                    ->icon('heroicon-o-cursor-click')
                    ->action(function ($record): void {
                        $record->status = 'process';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->disabled(fn ($record) => $record->status == 'new' ? false : true)
                    ->visible(fn () => Auth::user()->hasRole(['admin', 'sekretaris'])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSuratKeluars::route('/'),
            // 'create' => Pages\CreateSuratKeluar::route('/create'),
            // 'edit' => Pages\EditSuratKeluar::route('/{record}/edit'),
        ];
    }
}
