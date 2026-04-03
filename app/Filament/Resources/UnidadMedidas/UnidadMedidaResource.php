<?php

namespace App\Filament\Resources\UnidadMedidas;

use App\Filament\Resources\UnidadMedidas\Pages\CreateUnidadMedida;
use App\Filament\Resources\UnidadMedidas\Pages\EditUnidadMedida;
use App\Filament\Resources\UnidadMedidas\Pages\ListUnidadMedidas;
use App\Filament\Resources\UnidadMedidas\Schemas\UnidadMedidaForm;
use App\Filament\Resources\UnidadMedidas\Tables\UnidadMedidasTable;
use App\Models\UnidadMedida;
use BackedEnum;
use UnitEnum;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UnidadMedidaResource extends Resource
{
    protected static ?string $model = UnidadMedida::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-scale';
    protected static string|UnitEnum|null $navigationGroup = 'Configuración';
    protected static ?string $navigationLabel = 'Unidades de Medida';
    protected static ?string $modelLabel = 'Unidad de Medida';
    protected static ?string $pluralModelLabel = 'Unidades de Medida';
    protected static ?int $navigationSort = 1;


    public static function getGloballySearchableAttributes(): array
    {
        return ['nombre'];
    }

    public static function form(Schema $schema): Schema
    {
        return UnidadMedidaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnidadMedidasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListUnidadMedidas::route('/'),
            'create' => CreateUnidadMedida::route('/create'),
            'edit'   => EditUnidadMedida::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->can('unidad_medida.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('unidad_medida.crear') ?? false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return Auth::user()?->can('unidad_medida.editar') ?? false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return Auth::user()?->can('unidad_medida.eliminar') ?? false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
