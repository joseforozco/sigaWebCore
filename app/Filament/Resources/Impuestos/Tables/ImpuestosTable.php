<?php

namespace App\Filament\Resources\Impuestos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ImpuestosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->sortable(),
                TextColumn::make('porcentaje')
                    ->label('Porcentaje')
                    ->suffix('%')
                    ->sortable(),
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'IVA'       => 'IVA',
                        'INC'       => 'INC',
                        'ICO'       => 'ICO',
                        'ReteIVA'   => 'ReteIVA',
                        'ReteICA'   => 'ReteICA',
                        'ReteRenta' => 'ReteRenta',
                        'Otro'      => 'Otro',
                    ]),
                SelectFilter::make('activo')
                    ->label('Estado')
                    ->options(['1' => 'Activo', '0' => 'Inactivo']),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
