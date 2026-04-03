<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    public function getTabs(): array
    {
        // Una sola query: conteo por activo (0=pendiente, 1=activo)
        $counts = User::where('email', '!=', 'joseforozco@gmail.com')
            ->selectRaw('activo, count(*) as total')
            ->groupBy('activo')
            ->pluck('total', 'activo');

        $pendientes = $counts[0] ?? 0;
        $activos    = $counts[1] ?? 0;

        return [
            null => Tab::make('Todos')
                ->icon('heroicon-o-users'),
            'pendientes' => Tab::make('Pendientes')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('activo', false))
                ->badge($pendientes ?: null)
                ->badgeColor('danger'),
            'activos' => Tab::make('Activos')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('activo', true))
                ->badge($activos ?: null)
                ->badgeColor('success'),
        ];
    }
}
