<?php

namespace App\Filament\Resources\ProdukResource\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProdukGambarsRelationManager extends RelationManager
{
    // widget ini ngurus relasi produkGambars dari Model Produk yang lagi dibuka.
    protected static string $relationship = 'produkGambars';

    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('path_gambar') // komponen form khusus buat upload file.
                ->label('Foto')
                ->image() // mastiin cuma file gambar yang diterima (jpg, png, dll), nolak file lain.
                ->directory('produk') // nentuin file yang di-upload bakal disimpan di folder storage/app/public/produk/ yang memanfaatkan Storage::disk('public') + storage:link
                ->required(),

            TextInput::make('urutan')
                ->numeric()
                ->required()
                ->default(fn () => $this->getOwnerRecord()->produkGambars()->count() + 1),
                // itu cara ambil data produk induk yang lagi dibuka (produk yang lagi di-edit).
                // + 1 itu jadi kalau udah ada 2 foto, field urutan otomatis ke-suggest angka 3 buat foto baru.
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path_gambar')
            ->columns([
                ImageColumn::make('path_gambar')->label('Foto'),
                // ini nampilin thumbnail gambar beneran di tabel listing,
                // biar Admin Jurusan bisa lihat preview fotonya langsung tanpa perlu buka satu-satu.
                TextColumn::make('urutan')->sortable(),
            ])
            ->defaultSort('urutan') // tabel foto ini otomatis terurut sesuai kolom urutan
            ->headerActions([
                \Filament\Tables\Actions\CreateAction::make()
                    ->visible(fn () => $this->getOwnerRecord()->produkGambars()->count() < 5),
                    // ini yang menegakkan requirement "maksimal 5 foto" dari scope.
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ]);
    }
}