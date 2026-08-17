<?php

namespace App\Filament\Admin\Resources\Books\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->searchable()
                ->sortable(),
                TextColumn::make('author_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(40)
                    ->wrap()
                    ->searchable(),
                TextColumn::make('category.cat_title')
                    ->label('Category')
                    ->sortable(),
                ImageColumn::make('author_img')
                    ->getStateUsing(fn ($record) => asset('author/' . $record->author_img))
                    ->label('Author Image'),
                ImageColumn::make('book_img')
                    ->getStateUsing(fn ($record) => asset('book/' . $record->book_img))
                    ->label('Book Image'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')->relationship('category', 'cat_title'),
                Filter::make('low_stock')
                ->query(fn ($query) => $query->where('quantity', '=', 1))
                ->label('Low Stock'),
                Filter::make('out_of_stock')
                ->query(fn ($query) => $query->where('quantity', '=', 0))
                ->label('Out of Stock')
            ])
            ->recordActions([
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
