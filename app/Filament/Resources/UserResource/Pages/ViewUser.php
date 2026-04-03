<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\EditRecord;

class ViewUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getFormActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }
}
