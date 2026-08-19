<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Lead';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('status')
                ->options([
                    'baru_masuk' => 'Baru Masuk',
                    'sudah_dihubungi' => 'Sudah Dihubungi',
                    'closing' => 'Closing',
                    'batal' => 'Batal',
                    // 4 status yang kita definisikan di migration leads
                    // (baru_masuk, sudah_dihubungi, closing, batal)
                ])
                ->required(),

            Textarea::make('catatan_admin')
                ->label('Catatan Admin')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama Pemesan')->searchable(),
                TextColumn::make('user.email')->label('Email')->searchable(),
                TextColumn::make('user.phone')->label('No. HP'),
                TextColumn::make('produk.nama')->label('Produk')->searchable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->label('Waktu Klik')->dateTime('d M Y, H:i')->sortable(),
                // nampilin nama, email, dan nomor HP customer di tabel 
                // data ini yang penting buat admin follow up.
            ])
            ->defaultSort('created_at', 'desc') // lead yang paling baru masuk muncul di paling atas
            ->filters([])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
        // Lead tercipta otomatis lewat LeadController@store pas customer klik "Hubungi Admin".
    }
}