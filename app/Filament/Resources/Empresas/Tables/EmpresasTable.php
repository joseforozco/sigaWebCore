<?php

namespace App\Filament\Resources\Empresas\Tables;

use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Auth;
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
                    ->visible(fn () => Auth::user()?->can('empresa.editar') ?? false),
                ViewAction::make()
                    ->visible(fn () => !Auth::user()?->can('empresa.editar')),
            ]);
    }
}
