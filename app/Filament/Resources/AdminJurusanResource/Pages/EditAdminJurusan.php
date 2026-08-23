<?php

namespace App\Filament\Resources\AdminJurusanResource\Pages;

use App\Filament\Resources\AdminJurusanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminJurusan extends EditRecord
{
    protected static string $resource = AdminJurusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
