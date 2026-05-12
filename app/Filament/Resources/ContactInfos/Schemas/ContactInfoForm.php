<?php

namespace App\Filament\Resources\ContactInfos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInfoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('How clients can reach you')
                    ->description('All fields are optional — only filled-in ones are rendered on the public site.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')->email()->prefixIcon('heroicon-o-envelope')->placeholder('hello@example.com'),
                        TextInput::make('phone')->tel()->prefixIcon('heroicon-o-phone')->placeholder('+20 100 000 0000'),
                        TextInput::make('whatsapp')->tel()->prefixIcon('heroicon-o-chat-bubble-left-right')->placeholder('+20 100 000 0000')->helperText('WhatsApp link is generated automatically.'),
                        TextInput::make('working_hours')->prefixIcon('heroicon-o-clock')->placeholder('Mon — Fri · 9:00 AM — 6:00 PM (GMT+2)'),
                    ]),

                Section::make('Address')
                    ->columns(2)
                    ->schema([
                        TextInput::make('address_line_1'),
                        TextInput::make('address_line_2'),
                        TextInput::make('city')->default('Cairo'),
                        TextInput::make('country')->default('Egypt'),
                        TextInput::make('latitude')->numeric()->step(0.0000001),
                        TextInput::make('longitude')->numeric()->step(0.0000001),
                    ]),
            ]);
    }
}
