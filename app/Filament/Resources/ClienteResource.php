<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ClienteExporter;
use App\Filament\Resources\ClienteResource\Pages;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Departamento;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|UnitEnum|null $navigationGroup = 'Administración';

    protected static ?string $navigationLabel = 'Clientes';

    protected static ?string $modelLabel = 'Cliente';

    protected static ?string $pluralModelLabel = 'Clientes';

    protected static ?int $navigationSort = 2;

    public static function getGloballySearchableAttributes(): array
    {
        return ['nombre', 'documento', 'email'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identificación')
                ->columns(2)
                ->schema([
                    TextInput::make('nombre')
                        ->label('Nombre / Razón Social')
                        ->required()
                        ->maxLength(100),
                    Select::make('tipo_documento')
                        ->label('Tipo Documento')
                        ->options(['CC' => 'CC', 'NIT' => 'NIT', 'CE' => 'CE', 'PP' => 'PP'])
                        ->default('CC')
                        ->required(),
                    TextInput::make('documento')
                        ->label('Número Documento')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(20),
                    TextInput::make('contacto_principal')
                        ->label('Contacto Principal')
                        ->maxLength(100),
                ]),
            Section::make('Contacto')
                ->columns(2)
                ->schema([
                    TextInput::make('telefono')
                        ->label('Teléfono')
                        ->tel()
                        ->required()
                        ->maxLength(30),
                    TextInput::make('email')
                        ->label('Correo Electrónico')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(100),
                    TextInput::make('sitio_web')
                        ->label('Sitio Web')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('pais')
                        ->label('País')
                        ->default('Colombia')
                        ->maxLength(100),
                ]),
            Section::make('Ubicación')
                ->columns(2)
                ->schema([
                    Select::make('departamento_id')
                        ->label('Departamento')
                        ->options(Departamento::orderBy('nombre')->pluck('nombre', 'id'))
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('ciudad_id', null)),
                    Select::make('ciudad_id')
                        ->label('Ciudad')
                        ->options(fn (Get $get): Collection => Ciudad::where('departamento_id', $get('departamento_id'))
                            ->orderBy('nombre')
                            ->pluck('nombre', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('direccion1')
                        ->label('Dirección')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('direccion2')
                        ->label('Dirección 2')
                        ->maxLength(100),
                ]),
            Section::make('Crédito y Precios')
                ->columns(2)
                ->schema([
                    TextInput::make('limite_credito')
                        ->label('Límite de Crédito')
                        ->numeric()
                        ->prefix('$')
                        ->default(0),
                    TextInput::make('dias_credito')
                        ->label('Días de Crédito')
                        ->numeric()
                        ->default(0),
                    TextInput::make('dias_pago')
                        ->label('Días de Pago')
                        ->numeric()
                        ->default(0),
                    TextInput::make('porcentaje_descuento')
                        ->label('% Descuento')
                        ->numeric()
                        ->suffix('%')
                        ->default(0)
                        ->minValue(0)
                        ->maxValue(100)
                        ->helperText('Descuento comercial (integradores/subdistribuidores)'),
                    TextInput::make('saldo')
                        ->label('Saldo')
                        ->numeric()
                        ->prefix('$')
                        ->disabled()
                        ->dehydrated(false),
                ]),
            Section::make('Estado')
                ->schema([
                    Toggle::make('activo')
                        ->label('Cliente Activo')
                        ->default(true),
                ]),

            /*Section::make('Portal de Cliente')
                ->columns(2)
                ->schema([
                    Select::make('portal_acceso')
                        ->label('Acceso a Portal')
                        ->options([
                            'sin_acceso' => 'Sin Acceso',
                            'pendiente' => 'Pendiente',
                            'activo' => 'Activo',
                        ])
                        ->default('sin_acceso')
                        ->required(),
                    Select::make('user_id_portal')
                        ->label('Usuario Portal')
                        ->relationship('portalUser', 'name')
                        ->searchable()
                        ->nullable()
                        ->helperText('Usuario asociado a este cliente en el portal'),
                ]),*/
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identificación')
                ->columns(2)
                ->schema([
                    TextEntry::make('nombre')->label('Nombre / Razón Social'),
                    TextEntry::make('tipo_documento')->label('Tipo Documento'),
                    TextEntry::make('documento')->label('Número Documento'),
                    TextEntry::make('contacto_principal')->label('Contacto Principal')->placeholder('—'),
                ]),
            Section::make('Contacto')
                ->columns(2)
                ->schema([
                    TextEntry::make('telefono')->label('Teléfono'),
                    TextEntry::make('email')->label('Correo')->copyable(),
                    TextEntry::make('sitio_web')->label('Sitio Web')->placeholder('—'),
                    TextEntry::make('pais')->label('País'),
                ]),
            Section::make('Ubicación')
                ->columns(2)
                ->schema([
                    TextEntry::make('departamento.nombre')->label('Departamento'),
                    TextEntry::make('ciudad.nombre')->label('Ciudad'),
                    TextEntry::make('direccion1')->label('Dirección'),
                    TextEntry::make('direccion2')->label('Dirección 2')->placeholder('—'),
                ]),
            Section::make('Crédito y Saldo')
                ->columns(2)
                ->schema([
                    TextEntry::make('saldo')->label('Saldo')->money('COP', locale: 'es_CO'),
                    TextEntry::make('limite_credito')->label('Límite de Crédito')->money('COP', locale: 'es_CO'),
                    TextEntry::make('dias_credito')->label('Días de Crédito'),
                    TextEntry::make('dias_pago')->label('Días de Pago'),
                    TextEntry::make('listaPrecio.nombre')->label('Lista de Precios')->placeholder('Precio estándar'),
                ]),
            Section::make('Estado')
                ->columns(2)
                ->schema([
                    TextEntry::make('activo')
                        ->label('Estado')
                        ->badge()
                        ->color(fn ($state) => $state ? 'success' : 'danger')
                        ->formatStateUsing(fn ($state) => $state ? 'Activo' : 'Inactivo'),
                    TextEntry::make('usuario.name')->label('Registrado por'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('documento')
                    ->label('Documento')
                    ->searchable(),
                TextColumn::make('telefono')
                    ->label('Teléfono'),
                TextColumn::make('ciudad.nombre')
                    ->label('Ciudad')
                    ->sortable(),
                TextColumn::make('saldo')
                    ->label('Saldo')
                    ->money('COP', locale: 'es_CO')
                    ->sortable(),
                TextColumn::make('activo')
                    ->label('Activo')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => $state ? 'Si' : 'No'),
            ])
            ->filters([
                SelectFilter::make('activo')
                    ->label('Estado')
                    ->options(['1' => 'Activo', '0' => 'Inactivo']),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn ($record) => $record->id !== 1),
                Action::make('desactivar')
                    ->label('Desactivar')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('¿Desactivar cliente?')
                    ->modalDescription('El cliente quedará inactivo. Esta acción se puede revertir editando el cliente.')
                    ->modalSubmitActionLabel('Sí, desactivar')
                    ->visible(fn ($record) => Auth::user()?->hasRole('administrador') &&
                        $record->id !== 1 &&
                        $record->activo
                    )
                    ->action(function ($record) {
                        $record->update(['activo' => false]);
                        Notification::make()
                            ->title('Cliente desactivado')
                            ->body('El cliente ha sido marcado como inactivo.')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make()
                    ->visible(fn ($record) => Auth::user()?->hasRole('administrador') && $record->id !== 1
                    )
                    
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Exportar')
                    ->exporter(ClienteExporter::class),
                BulkActionGroup::make([
                    // Sin bulk actions destructivas
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'view' => Pages\ViewCliente::route('/{record}'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->can('cliente_catalogo.ver') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('cliente_catalogo.crear') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()?->can('cliente_catalogo.editar') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()?->can('cliente_catalogo.eliminar') ?? false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
