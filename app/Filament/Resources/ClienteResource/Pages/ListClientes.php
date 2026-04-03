<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use App\Filament\Resources\ClienteResource\Widgets\ClientesStatsWidget;
use App\Models\Cliente;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListClientes extends ListRecords
{
    protected static string $resource = ClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    protected function getHeaderWidgets(): array
    {
        return [ClientesStatsWidget::class];
    }

    public function getTabs(): array
    {
        $counts = Cliente::selectRaw('activo, count(*) as total')
            ->groupBy('activo')
            ->pluck('total', 'activo');

        $inactivos = $counts[0] ?? 0;
        $activos   = $counts[1] ?? 0;

        return [
            null => Tab::make('Todos')
                ->icon('heroicon-o-list-bullet'),
            'activos' => Tab::make('Activos')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('activo', true))
                ->badge($activos ?: null)
                ->badgeColor('success'),
            'inactivos' => Tab::make('Inactivos')
                ->icon('heroicon-o-no-symbol')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('activo', false))
                ->badge($inactivos ?: null)
                ->badgeColor('danger'),
        ];
    }
}
