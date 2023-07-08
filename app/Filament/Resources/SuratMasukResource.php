<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratMasukResource\Pages;
use App\Filament\Resources\SuratMasukResource\RelationManagers;
use App\Models\Surat\Kategori;
use App\Models\Surat\Masuk;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuratMasukResource extends Resource
{
    protected static ?string $model = Masuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-in';
    protected static ?string $navigationLabel = 'Surat Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Card::make()
                ->schema([
                    TextInput::make("perihal")
                        ->required(),
                    TextInput::make("pengirim")
                        ->helperText('Masukkan nama atau instansi pengirim.')
                        ->required(),
                    Select::make("penerima")
                        ->label("Penerima")
                        ->helperText("Penerima surat saat diantarkan")
                        ->options(User::all()->pluck("name", "id"))
                        ->searchable()
                        ->required(),
                    Select::make("kategori_id")
                        ->label("Kategori Surat")
                        ->options(Kategori::all()->pluck("kategori", "id"))
                        ->searchable()
                        ->required(),
                    Select::make("atas_nama")
                        ->label("Nama Penerima")
                        ->helperText("Nama penerima pada surat")
                        ->options(User::all()->pluck("name", "id"))
                        ->searchable()
                        ->required(),
                    FileUpload::make('file')
                        ->disk('local')
                        ->directory('surat-masuk')
                        ->visibility('public')
                        ->acceptedFileTypes(['application/pdf']),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('perihal')
                    ->label('Perihal')
                    ->searchable(),
                TextColumn::make('pengirim')
                    ->label('Pengirim')
                    ->searchable(),
                IconColumn::make('disposisi')
                    ->options([
                        'heroicon-o-x-circle' => fn ($state): bool => $state == 0,
                        'heroicon-o-check-circle' => fn ($state): bool => $state == 1,
                    ])->colors([
                        'secondary',
                        'success' => 1,
                    ]),
                TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListSuratMasuks::route('/'),
            'create' => Pages\CreateSuratMasuk::route('/create'),
            'edit' => Pages\EditSuratMasuk::route('/{record}/edit'),
        ];
    }    
}
