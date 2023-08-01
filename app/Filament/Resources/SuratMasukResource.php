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
use Filament\Tables\Columns\SelectColumn;
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
                            ->disk('public')
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
                TextColumn::make('status')->enum([
                    'new' => 'Baru',
                    'process' => 'Dalam Proses',
                    'disposition' => 'Disposisi',
                    'rejected' => 'Ditolak',
                    'finis' => 'Selesai'
                ]),
                IconColumn::make('disposisi')
                    ->label('Disposisi')
                    ->options([
                        'heroicon-o-x-circle' => fn ($state): bool => $state == 0,
                        'heroicon-o-check-circle' => fn ($state): bool => $state == 1,
                    ])->colors([
                        'secondary',
                        'success' => 1,
                    ]),
                IconColumn::make('approved_by')
                    ->label('Approve')
                    ->options([
                        'heroicon-o-x-circle' => fn ($state): bool => $state == null,
                        'heroicon-o-check-circle' => fn ($state): bool => $state != null,
                    ])->colors([
                        'secondary',
                        'success' => fn ($state): bool => $state !=  null,
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

                Tables\Actions\Action::make('Proccess')
                    ->action(function ($record): void {
                        $record->status = 'process';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->visible(fn ($record) => Auth::user()->hasRole(['admin', 'sekretaris']) && $record->status == 'new'),
                    // Print
                    Tables\Actions\Action::make('Print')
                    ->label('')
                    ->icon('heroicon-s-printer')
                    ->url(fn($record): string => url(sprintf("/storage/%s", $record->file))),
                Tables\Actions\ActionGroup::make([
                    // edit
                    Tables\Actions\EditAction::make()
                        ->visible(fn ($record) => $record->status == 'new'),
                    // delete
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn ($record) => Auth::user()->hasRole(['admin', 'sekretaris']) && $record->status == 'new'),
                    // disposisi
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
                        ])
                        ->icon('heroicon-s-switch-horizontal')
                        ->visible(fn($record) => Auth::user()->hasRole(['admin', 'lurah']) && $record->status == 'process'),
                    //     ->visible(function ($record) {
                    //         if(Auth::user()->hasRole(['admin', 'lurah'])  && $record->status == array('process')) {
                    //             return true;
                    //         } else {
                    //             return false;
                    //         }
                    //     }),
                    // // approve
                    Tables\Actions\Action::make('Approve')
                        ->action(function ($record): void {
                            $record->approved_by = Auth::user()->id;
                            $record->save();
                        })
                        ->requiresConfirmation()
                        ->icon('heroicon-s-thumb-up')
                        ->visible(fn ($record) => Auth::user()->hasRole(['admin', 'lurah']) && $record->approved_by == null && $record->status != 'rejected'),
                    // approve
                    Tables\Actions\Action::make('Reject')
                        ->action(function ($record): void {
                            $record->status = "rejected";
                            $record->save();
                        })
                        ->requiresConfirmation()
                        ->icon('heroicon-s-thumb-down')
                        ->visible(function ($record) {
                            if(Auth::user()->hasRole(['admin', 'lurah']) ) {
                                if($record->status == 'process' || $record->status == 'disposition' && $record->approved_by == null){
                                    return true;
                                }
                            }else {
                                return false;
                            }
                        })->disabled(fn($record) => $record->approvedBy != null),
                    // finish
                    Tables\Actions\Action::make('Selesaikan')
                        ->action(function ($record): void {
                            $record->status = "finis";
                            $record->save();
                        })
                        ->requiresConfirmation()
                        ->icon('heroicon-s-flag')
                        ->visible(fn($record) => Auth::user()->hasRole(['admin', 'sekretaris', 'lurah']) && $record->approved_by != null && $record->status != 'finis')
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])->defaultSort('created_at', 'asc');
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
        return Masuk::where('approved_by', '==', null)->count();
    }
}
