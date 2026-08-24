<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class LeadMonitoringWidget extends BaseWidget
{
    // judul yang muncul di atas widget
    protected static ?string $heading = 'Monitoring Lead Lintas Jurusan';

    // widget ini makan lebar penuh Dashboard
    protected int|string|array $columnSpan = 'full';

    // Widget ini cuma muncul kalau yang login itu Super Admin
    public static function canView(): bool
    {
        return Auth::guard('admin')->user()?->isSuperAdmin() ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Lead::query()->latest())
            // ini query paling simpel yang bisa ditulis, TANPA filter jurusan apapun
            ->columns([
                TextColumn::make('jurusan.nama')->label('Jurusan')->badge(),
                TextColumn::make('user.name')->label('Pemesan'),
                TextColumn::make('produk.nama')->label('Produk'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->label('Waktu')->dateTime('d M Y, H:i'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]); // memberi pilihan berapa baris per halaman
    }
}