<?php

namespace App\Filament\Resources\Empresas;

use App\Filament\Resources\Empresas\Pages\CreateEmpresa;
use App\Filament\Resources\Empresas\Pages\EditEmpresa;
use App\Filament\Resources\Empresas\Pages\ListEmpresas;
use App\Filament\Resources\Empresas\Pages\ViewEmpresa;
use App\Filament\Resources\Empresas\Schemas\EmpresaForm;
use App\Filament\Resources\Empresas\Tables\EmpresasTable;
use App\Models\Empresa;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class EmpresaResource extends Resource
{
    protected static ?string $model = Empresa::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
    protected static string|UnitEnum|null $navigationGroup = 'Configuración';
    protected static ?string $navigationLabel = 'Datos de la Empresa';
    protected static ?string $modelLabel = 'Empresa';
    protected static ?string $pluralModelLabel = 'Empresa';
    protected static ?int $navigationSort = 0;

    public static function canAccess(): bool
    {
        return Auth::user()?->can('empresa.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('empresa.editar') ?? false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return Auth::user()?->can('empresa.editar') ?? false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return Auth::user()?->can('empresa.eliminar') ?? false;
    }


    public static function getGloballySearchableAttributes(): array
    {
        return ['razon_social', 'nit'];
    }

    public static function form(Schema $schema): Schema
    {
        return EmpresaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmpresasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListEmpresas::route('/'),
            'create' => CreateEmpresa::route('/create'),
            'view'   => ViewEmpresa::route('/{record}'),
            'edit'   => EditEmpresa::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
