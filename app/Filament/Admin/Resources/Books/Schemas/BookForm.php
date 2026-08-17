<?php

namespace App\Filament\Admin\Resources\Books\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('author_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Textarea::make('description')
                    ->required()
                    ->row(5)
                    ->columnSpanFull(),
                TextInput::make('quantity')
                    ->required()
                    ->integer()
                    ->minValue(0),
                FileUpload::make('book_img')
                    ->image()
                    ->disk('book_public')
                    ->maxSize(2048)
                    ->moveFiles(),
                FileUpload::make('author_img')
                    ->image()
                    ->disk('author_public')
                    ->maxSize(2048)
                    ->moveFiles(),
                Select::make('category_id')
                    ->relationship('category', 'cat_title')
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }
}
