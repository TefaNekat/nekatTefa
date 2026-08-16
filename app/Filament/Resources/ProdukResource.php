<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;
    // Resource ini urus Model Produk — otomatis kena JurusanScope juga

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Produk';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Select::make('jurusan_id')
                ->relationship('jurusan', 'nama')  // dropdown isi nama jurusan
                ->required()
                ->disabled(fn () => !Auth::guard('admin')->user()->isSuperAdmin())
                // dikunci kalau bukan Super Admin
                ->dehydrated()
                // biar field yg disabled tetap ikut kesimpan
                ->default(fn () => Auth::guard('admin')->user()->jurusan_id),
                // auto-isi jurusan miliknya sendiri

            TextInput::make('nama')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                // auto-generate slug dari nama

            TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
                // ignoreRecord biar nggak bentrok sama dirinya sendiri pas edit

            Textarea::make('deskripsi')->required()->columnSpanFull(),
            Textarea::make('fungsi')->required()->columnSpanFull(),
            Textarea::make('manfaat')->required()->columnSpanFull(),
            Textarea::make('fitur_keunggulan')->required()->columnSpanFull(),

            TextInput::make('harga')
                ->required()
                ->numeric()
                ->prefix('Rp'),

            Select::make('status')
                ->options(['draft' => 'Draft', 'published' => 'Published'])
                ->required()
                ->default('published'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('jurusan.nama')->label('Jurusan')->sortable(),
                // titik = ambil dari relasi, bukan kolom langsung
                TextColumn::make('harga')->money('IDR')->sortable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
            ])
            ->filters([])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}