<?php

namespace App\Filament\Resources\AboutSections\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class AboutSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('about_tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Identity')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Section::make('Who you are')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('name')->required()->maxLength(120),
                                        TextInput::make('title')
                                            ->required()
                                            ->placeholder('Senior Flutter Developer')
                                            ->maxLength(120),
                                        TextInput::make('subtitle')
                                            ->placeholder('Building Amazing Mobile Apps with Flutter')
                                            ->columnSpanFull()
                                            ->maxLength(255),
                                        TextInput::make('location')->placeholder('Cairo, Egypt'),
                                        TextInput::make('availability')
                                            ->placeholder('Available for freelance & full-time roles')
                                            ->helperText('Shown in the green pulsing badge on the hero.'),
                                    ]),

                                Section::make('Stats counters (hero)')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('years_experience')->numeric()->default(2)->minValue(0)->suffix('years'),
                                        TextInput::make('projects_completed')->numeric()->default(10)->minValue(0)->suffix('projects'),
                                        TextInput::make('happy_clients')->numeric()->default(0)->minValue(0)->suffix('clients'),
                                    ]),
                            ]),

                        Tab::make('Bio')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Short bio (hero subtitle)')
                                    ->schema([
                                        Textarea::make('short_bio')
                                            ->rows(2)
                                            ->maxLength(220)
                                            ->placeholder('Flutter Developer delivering exceptional mobile applications.')
                                            ->helperText('Recommended ≤ 200 chars. Shown right under your hero title.')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Long bio (about section)')
                                    ->schema([
                                        Textarea::make('bio')
                                            ->rows(8)
                                            ->columnSpanFull()
                                            ->helperText('2–4 paragraphs. Shown in the About section. Plain text — paragraph breaks preserved.'),
                                    ]),
                            ]),

                        Tab::make('Photos')
                            ->icon('heroicon-o-photo')
                            ->badge('Profile + Hero')
                            ->schema([
                                Section::make('Profile photo')
                                    ->description('Shown in the hero. Transparent PNG works best. ~1200×1500px recommended.')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('profile_photo')
                                            ->collection('profile_photo')
                                            ->image()
                                            ->imageEditor()
                                            ->imageResizeTargetWidth('1200')
                                            ->imageResizeTargetHeight('1500')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Hero / cover image')
                                    ->description('Optional secondary image for the about page header. Landscape, ~1920×1080.')
                                    ->collapsed()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('hero_image')
                                            ->collection('hero_image')
                                            ->image()
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Resume')
                            ->icon('heroicon-o-document-arrow-down')
                            ->badge('PDF upload')
                            ->schema([
                                Section::make('Upload your CV / Resume')
                                    ->description('PDF only. Max 10 MB. This file is what the "Download CV" button on the hero will serve.')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('cv')
                                            ->label('CV / Resume PDF')
                                            ->collection('cv')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->maxSize(10 * 1024) // 10 MB in KB
                                            ->downloadable()
                                            ->openable()
                                            ->previewable(false)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Or link to an external CV (optional)')
                                    ->description('Use this only if you prefer hosting your CV on Google Drive, Dropbox, Notion, etc. The uploaded PDF above takes priority — this URL is only used as a fallback when no file is uploaded.')
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('cv_url')
                                            ->label('External CV URL')
                                            ->url()
                                            ->placeholder('https://drive.google.com/your-cv.pdf')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
