<?php

namespace App\Filament\Resources\SocialLinks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('platform')
                    ->required(),
                TextInput::make('label'),
                TextInput::make('url')
                    ->url()
                    ->required(),
                TextInput::make('icon_class'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('show_in_header')
                    ->required(),
                Toggle::make('show_in_footer')
                    ->required(),
                TextInput::make('display_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
