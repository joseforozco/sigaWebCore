<?php

namespace App\Filament\Resources\Empresas\Schemas;

use App\Models\Ciudad;
use App\Models\Departamento;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
#use Filament\Forms\Components\Textarea;
#use Filament\Forms\Components\TextInput;
use Schmeits\FilamentCharacterCounter\Forms\Components\TextInput;
use Schmeits\FilamentCharacterCounter\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class EmpresaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificación de la Empresa')
                    ->columns(2)
                    ->schema([
                        TextInput::make('razon_social')
                            ->label('Razón Social')
                            ->required()
                            ->maxLength(150),
                        TextInput::make('nombre_comercial')
                            ->label('Nombre Comercial')
                            ->maxLength(150),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nit')
                                    ->label('NIT')
                                    ->required()
                                    ->maxLength(20),
                                TextInput::make('digito_verificacion')
                                    ->label('DV')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->maxValue(9),
                            ]),
                        Grid::make(1)->schema([
                            Select::make('tipo_persona')
                                ->label('Tipo Persona')
                                ->options([
                                    'natural' => 'Natural',
                                    'juridica' => 'Jurídica',
                                ])
                                ->default('juridica')
                                ->required(),
                        ]),
                    ])->columnSpanFull(),

                Section::make('Ubicación y Contacto')
                    ->columns(3)
                    ->schema([
                        TextInput::make('direccion')
                            ->label('Dirección')
                            ->required()
                            ->maxLength(150),
                        Select::make('departamento_id')
                            ->label('Departamento')
                            ->options(Departamento::pluck('nombre', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn(Set $set) => $set('ciudad_id', null)),
                        Select::make('ciudad_id')
                            ->label('Ciudad')
                            ->options(fn(Get $get): Collection => Ciudad::where('departamento_id', $get('departamento_id'))->pluck('nombre', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('celular')
                            ->label('Telefono / Celular')
                            ->tel(),
                        TextInput::make('email')
                            ->label('Email General')
                            ->email(),
                        TextInput::make('email_documentos')
                            ->label('Email Envío Facturas')
                            ->email(),
                    ])->columnSpanFull(),

                Section::make('Información Tributaria')
                    ->columns(2)
                    ->schema([
                        Select::make('regimen_tributario')
                            ->label('Régimen Tributario')
                            ->options([
                                'simplificado' => 'Simplificado',
                                'comun' => 'Común',
                                'gran_contribuyente' => 'Gran Contribuyente',
                            ])
                            ->default('comun')
                            ->required(),
                        TextInput::make('actividad_ciiu')
                            ->label('Actividad CIIU')
                            ->maxLength(10),
                        Toggle::make('responsable_iva')
                            ->label('Responsable de IVA')
                            ->default(true),
                        Toggle::make('usa_seriales')
                            ->label('Usar control de seriales por producto')
                            ->helperText('Activa el manejo opcional de seriales unitarios en el inventario.')
                            ->default(false),

                    ]),

                Section::make('Documentos y Logo')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo de la Empresa')
                            ->image()
                            ->directory('empresa')
                            ->maxSize(2048),

                    ]),

                Section::make('Márgenes de Ganancia')
                    ->columns(2)
                    ->schema([
                        TextInput::make('margen_ganancia_default')
                            ->label('Margen Default (%)')
                            ->numeric()
                            ->default(30.00)
                            ->minValue(0)
                            ->maxValue(100)
                            ->helperText('Margen de ganancia por defecto para precios de venta'),
                        TextInput::make('margen_ganancia_minimo')
                            ->label('Margen Mínimo (%)')
                            ->numeric()
                            ->default(10.00)
                            ->minValue(0)
                            ->maxValue(100)
                            ->helperText('Margen mínimo permitido'),

                        Textarea::make('pie_pagina')
                            ->label('Pie de Página Documentos')
                            ->maxLength(100),
                        Textarea::make('notas_factura')
                            ->label('Notas Legales Factura')
                            ->characterLimit(50)
                            ->maxLength(100)
                    ]),
            ]);
    }
}
