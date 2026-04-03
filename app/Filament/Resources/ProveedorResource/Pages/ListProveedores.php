<?php

namespace App\Filament\Resources\ProveedorResource\Pages;

use App\Filament\Resources\ProveedorResource;
use App\Models\Proveedor;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProveedores extends ListRecords
{
    protected static string $resource = ProveedorResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    public function getTabs(): array
    {
        $counts = Proveedor::selectRaw('activo, count(*) as total')
            ->groupBy('activo')
            ->pluck('total', 'activo');

        return [
            null => Tab::make('Todos')->icon('heroicon-o-list-bullet'),
            'activos' => Tab::make('Activos')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('activo', true))
                ->badge($counts[1] ?? null ?: null)
                ->badgeColor('success'),
            'inactivos' => Tab::make('Inactivos')
                ->icon('heroicon-o-no-symbol')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('activo', false))
                ->badge($counts[0] ?? null ?: null)
                ->badgeColor('danger'),
        ];
    }
}
