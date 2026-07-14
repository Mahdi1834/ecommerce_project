<?php

namespace App\Filament\Resources\Brands\Schemas;


use App\Models\Brand;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;


class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Section::make([
                    Grid::make()->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', str($state)->slug()) : null),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->maxLength(255)
                            ->dehydrated()
                            ->unique(Brand::class, 'slug', ignoreRecord: true),
                    ]),
                    FileUpload::make('image')
                        ->image()
                        ->disk('public')
                        ->directory('brand')
                        ->visibility('public'),
                        
                    Toggle::make('is_active')
                        ->required()
                        ->default(true),
                ]),

            ]);
    }
}
