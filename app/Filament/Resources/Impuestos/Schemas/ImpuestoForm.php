<?php

namespace App\Filament\Resources\Impuestos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ImpuestoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(100),
                Select::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'IVA'       => 'IVA',
                        'INC'       => 'INC',
                        'ICO'       => 'ICO',
                        'ReteIVA'   => 'ReteIVA',
                        'ReteICA'   => 'ReteICA',
                        'ReteRenta' => 'ReteRenta',
                        'Otro'      => 'Otro',
                    ])
                    ->default('IVA')
                    ->required(),
                TextInput::make('porcentaje')
                    ->label('Porcentaje (%)')
                    ->numeric()
                    ->suffix('%')
                    ->required(),
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->columnSpanFull(),
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true),
            ]);
    }
}
