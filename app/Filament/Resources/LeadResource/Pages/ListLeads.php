<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use Filament\Resources\Pages\ListRecords;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    // ini method yang nentuin tombol-tombol apa aja yang muncul di pojok kanan atas halaman List
    {
        return [];
    }
}
