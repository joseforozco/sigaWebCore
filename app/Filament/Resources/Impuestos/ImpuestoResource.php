<?php

namespace App\Filament\Resources\Impuestos;

use App\Filament\Resources\Impuestos\Pages\CreateImpuesto;
use App\Filament\Resources\Impuestos\Pages\EditImpuesto;
use App\Filament\Resources\Impuestos\Pages\ListImpuestos;
use App\Filament\Resources\Impuestos\Schemas\ImpuestoForm;
use App\Filament\Resources\Impuestos\Tables\ImpuestosTable;
use App\Models\Impuesto;
use BackedEnum;
use UnitEnum;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ImpuestoResource extends Resource
{
    protected static ?string $model = Impuesto::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-receipt-percent';
    protected static string|UnitEnum|null $navigationGroup = 'Configuración';
    protected static ?string $navigationLabel = 'Impuestos';
    protected static ?string $modelLabel = 'Impuesto';
    protected static ?string $pluralModelLabel = 'Impuestos';
    protected static ?int $navigationSort = 4;


    public static function getGloballySearchableAttributes(): array
    {
        return ['nombre'];
    }

    public static function form(Schema $schema): Schema
    {
        return ImpuestoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImpuestosTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListImpuestos::route('/'),
            'create' => CreateImpuesto::route('/create'),
            'edit'   => EditImpuesto::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->can('impuesto.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('impuesto.crear') ?? false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return Auth::user()?->can('impuesto.editar') ?? false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return Auth::user()?->can('impuesto.eliminar') ?? false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
