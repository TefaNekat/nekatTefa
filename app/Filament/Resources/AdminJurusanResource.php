<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminJurusanResource\Pages;
use App\Models\AdminJurusan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class AdminJurusanResource extends Resource
{
    protected static ?string $model = AdminJurusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Kelola Admin';

    protected static ?string $navigationGroup = 'Manajemen Akun';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Input Nama Admin
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            // Input Email dengan validasi unique (mengabaikan record diri sendiri saat proses Edit)
            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            // Pilihan Role: Super Admin atau Admin Jurusan
            Select::make('role')
                ->options([
                    'super_admin' => 'Super Admin',
                    'admin_jurusan' => 'Admin Jurusan',
                ])
                ->required()
                ->live(), // Membuat form bereaksi secara live tanpa reload halaman

            // Pilihan Jurusan: Hanya muncul dan wajib diisi jika role yang dipilih adalah 'admin_jurusan'
            Select::make('jurusan_id')
                ->relationship('jurusan', 'nama')
                ->required(fn (callable $get) => $get('role') === 'admin_jurusan')
                ->visible(fn (callable $get) => $get('role') === 'admin_jurusan'),

            // Input Password dengan enkripsi otomatis dan kondisi wajib hanya saat 'create'
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // Enkripsi password sebelum disimpan
                ->dehydrated(fn ($state) => filled($state)) // Jangan timpa password jika kosong saat mode Edit
                ->required(fn (string $context) => $context === 'create') // Wajib diisi hanya saat buat akun baru
                ->label(fn (string $context) => $context === 'create' ? 'Password' : 'Password Baru (kosongkan jika tidak diubah)'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                
                // Menampilkan nama jurusan, dengan placeholder khusus untuk Super Admin (karena tidak punya relasi jurusan)
                TextColumn::make('jurusan.nama')->label('Jurusan')->placeholder('— (Super Admin) —'),
                
                // Menampilkan role dalam bentuk badge warna-warni
                TextColumn::make('role')->badge(),
                
                TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
            ])
            ->filters([])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function canViewAny(): bool
    {
        return auth('admin')->user()?->isSuperAdmin() ?? false;
        // kalau auth('admin')->user() ternyata null (belum login), langsung false, nggak error.
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminJurusans::route('/'),
            'create' => Pages\CreateAdminJurusan::route('/create'),
            'edit' => Pages\EditAdminJurusan::route('/{record}/edit'),
        ];
    }
}