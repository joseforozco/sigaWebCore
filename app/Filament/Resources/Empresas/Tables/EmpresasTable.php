<?php

namespace App\Filament\Resources\Empresas\Tables;

use App\Filament\Resources\Empresas\EmpresaResource;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmpresasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(),
                TextColumn::make('razon_social')
                    ->label('Razón Social')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nit')
                    ->label('NIT')
                    ->formatStateUsing(fn ($record) => $record->nit . '-' . $record->digito_verificacion)
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('telefono')
                    ->label('Teléfono'),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn () => EmpresaResource::isSuperAdmin()),
                ViewAction::make()
                    ->visible(fn () => !EmpresaResource::isSuperAdmin()),
            ]);
    }
}
