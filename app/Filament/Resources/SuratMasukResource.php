<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratMasukResource\Pages;
use App\Filament\Resources\SuratMasukResource\RelationManagers;
use App\Filament\Resources\SuratMasukResource\Widgets\SuratMasukOverview;
use App\Models\Surat\Kategori;
use App\Models\Surat\Masuk;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Modal\Actions\Action;
use Illuminate\Support\Facades\Auth;

class SuratMasukResource extends Resource
{
    protected static ?string $model = Masuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-in';
    protected static ?string $navigationLabel = 'Surat Masuk';
    protected static ?string $navigationGroup = 'Surat';
    protected static ?string $label = 'SuratMasuk';


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
                            ->acceptedFileTypes(['application/pdf'])
                            ->enableDownload(),
                        Select::make('approved_by')
                            ->relationship('approvedBy', 'name')
                            ->disabled()
                            ->visibleOn('edit')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->date(),
                TextColumn::make('perihal')
                    ->label('Perihal')
                    ->searchable(),
                TextColumn::make('pengirim')
                    ->label('Pengirim')
                    ->searchable(),
                TextColumn::make('atasNama.name')
                    ->label('Tujuan')
                    ->searchable(),
                TextColumn::make('status'),
                IconColumn::make('disposisi')
                    ->label('Disposisi')
                    ->options([
                        'heroicon-o-x-circle' => fn ($state): bool => $state == 0,
                        'heroicon-o-check-circle' => fn ($state): bool => $state == 1,
                    ])->colors([
                        'secondary',
                        'success' => 1,
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'Baru',
                        'process' => 'Diproses',
                        'disposition' => 'Disposisi',
                        'rejected' => 'Ditolak',
                        'finis' => 'Selesai'
                    ])
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn () => Auth::user()->hasRole(['admin', 'sekretaris'])),
                    Tables\Actions\Action::make('disposisi')
                        ->action(function (array $data, $record): void {
                            $record->atas_nama = $data['atas_nama'];
                            $record->disposisi = true;
                            $record->status = 'disposition';
                            $record->save();
                        })
                        ->form([
                            Select::make("atas_nama")
                                ->label("Nama Penerima")
                                ->helperText("Nama penerima pada surat")
                                ->options(User::all()->pluck("name", "id"))
                                ->searchable()
                                ->required(),
                        ])->visible(fn () => Auth::user()->hasRole(['admin', 'lurah'])),
                ]),
                Tables\Actions\Action::make('Approve')
                    ->action(function ($record): void {
                        $record->approved_by = Auth::user()->id;
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->visible(fn () => Auth::user()->hasRole(['admin', 'lurah'])),
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
            // 'edit' => Pages\EditSuratMasuk::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return Masuk::where('status', 'new')->count();
    }
}
