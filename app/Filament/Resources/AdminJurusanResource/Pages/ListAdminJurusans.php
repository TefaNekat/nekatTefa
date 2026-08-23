<?php

namespace App\Filament\Resources\AdminJurusanResource\Pages;

use App\Filament\Resources\AdminJurusanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminJurusans extends ListRecords
{
    protected static string $resource = AdminJurusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
