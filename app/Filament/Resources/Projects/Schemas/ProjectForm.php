<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('project_tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Overview')
                            ->icon('heroicon-o-information-circle')
                            ->schema(self::overviewTab()),

                        Tab::make('Description')
                            ->icon('heroicon-o-document-text')
                            ->schema(self::descriptionTab()),

                        Tab::make('Links')
                            ->icon('heroicon-o-link')
                            ->badge('App + Play Store')
                            ->schema(self::linksTab()),

                        Tab::make('Media')
                            ->icon('heroicon-o-photo')
                            ->schema(self::mediaTab()),

                        Tab::make('Categorization')
                            ->icon('heroicon-o-tag')
                            ->schema(self::categorizationTab()),

                        Tab::make('Display & SEO')
                            ->icon('heroicon-o-eye')
                            ->schema(self::displayTab()),
                    ]),
            ]);
    }

    protected static function overviewTab(): array
    {
        return [
            Section::make('Project Basics')
                ->description('Title, slug and short description shown on project cards.')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set, ?string $operation) =>
                            $operation === 'create' ? $set('slug', Str::slug($state)) : null
                        ),

                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('URL-friendly identifier (auto from title).'),

                    TextInput::make('subtitle')
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('description')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('1-3 sentence summary shown on project cards.')
                        ->columnSpanFull(),
                ]),

            Section::make('Meta')
                ->columns(3)
                ->schema([
                    TextInput::make('year')
                        ->numeric()
                        ->minValue(2010)
                        ->maxValue((int) date('Y') + 1)
                        ->default((int) date('Y')),

                    TextInput::make('client')
                        ->maxLength(255),

                    TextInput::make('duration')
                        ->placeholder('e.g. 3 months'),

                    TextInput::make('role')
                        ->required()
                        ->default('Senior Flutter Developer'),

                    Select::make('platform')
                        ->options([
                            'iOS' => 'iOS only',
                            'Android' => 'Android only',
                            'iOS & Android' => 'iOS & Android',
                            'Web' => 'Web',
                            'Cross-platform' => 'Cross-platform',
                        ])
                        ->default('iOS & Android'),
                ]),
        ];
    }

    protected static function descriptionTab(): array
    {
        return [
            Section::make('Detailed Description')
                ->description('Full project write-up shown on the project detail page.')
                ->schema([
                    RichEditor::make('body')
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'h2', 'h3', 'blockquote', 'codeBlock',
                            'bulletList', 'orderedList',
                            'link', 'undo', 'redo',
                        ]),
                ]),

            Section::make('Problem / Solution')
                ->columns(2)
                ->schema([
                    Textarea::make('problem')
                        ->rows(4)
                        ->placeholder('What problem did this app solve?'),
                    Textarea::make('solution')
                        ->rows(4)
                        ->placeholder('How did your Flutter solution address it?'),
                ]),

            Section::make('Key Features')
                ->description('Bulleted list of features shown on the project detail page.')
                ->schema([
                    Repeater::make('features')
                        ->label('Features')
                        ->simple(
                            TextInput::make('feature')
                                ->required()
                                ->placeholder('e.g. Real-time sync')
                        )
                        ->reorderable()
                        ->reorderableWithButtons()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['feature'] ?? null)
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),
        ];
    }

    protected static function linksTab(): array
    {
        return [
            Section::make('Mobile Store Links')
                ->description('App Store and Play Store URLs — render store-style buttons on the project page.')
                ->columns(2)
                ->icon('heroicon-o-device-phone-mobile')
                ->schema([
                    TextInput::make('app_store_url')
                        ->label('App Store URL')
                        ->prefixIcon('heroicon-o-shield-check')
                        ->url()
                        ->placeholder('https://apps.apple.com/...')
                        ->helperText('Direct link to the iOS app on the App Store.'),

                    TextInput::make('play_store_url')
                        ->label('Play Store URL')
                        ->prefixIcon('heroicon-o-play')
                        ->url()
                        ->placeholder('https://play.google.com/store/apps/...')
                        ->helperText('Direct link to the Android app on Google Play.'),
                ]),

            Section::make('Repository & Demo')
                ->columns(2)
                ->schema([
                    TextInput::make('github_url')
                        ->label('GitHub URL')
                        ->prefixIcon('heroicon-o-code-bracket')
                        ->url()
                        ->placeholder('https://github.com/username/repo'),

                    TextInput::make('live_demo_url')
                        ->label('Live Demo URL')
                        ->prefixIcon('heroicon-o-globe-alt')
                        ->url(),

                    TextInput::make('video_url')
                        ->label('Demo Video (YouTube/Vimeo)')
                        ->prefixIcon('heroicon-o-play-circle')
                        ->url(),

                    TextInput::make('case_study_url')
                        ->label('Case Study URL')
                        ->prefixIcon('heroicon-o-document-text')
                        ->url(),
                ]),
        ];
    }

    protected static function mediaTab(): array
    {
        return [
            Section::make('Cover Image')
                ->description('Hero image shown on project cards and the detail page header.')
                ->schema([
                    \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('cover')
                        ->image()
                        ->imageEditor()
                        ->imageResizeTargetWidth('1920')
                        ->imageResizeTargetHeight('1080')
                        ->columnSpanFull(),
                ]),

            Section::make('App Icon')
                ->description('Square 1024×1024 icon for store-style display.')
                ->schema([
                    \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('app_icon')
                        ->collection('app_icon')
                        ->image()
                        ->imageEditor()
                        ->imageResizeTargetWidth('1024')
                        ->imageResizeTargetHeight('1024')
                        ->columnSpanFull(),
                ]),

            Section::make('Screenshots Gallery')
                ->description('Multiple screenshots shown in the project detail page lightbox. Drag to reorder.')
                ->schema([
                    \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('screenshots')
                        ->collection('screenshots')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->panelLayout('grid')
                        ->columnSpanFull(),
                ]),
        ];
    }

    protected static function categorizationTab(): array
    {
        return [
            Section::make('Technologies Used')
                ->description('Tech stack rendered as pills on the project card and detail page.')
                ->schema([
                    Select::make('technologies')
                        ->multiple()
                        ->relationship('technologies', 'name')
                        ->preload()
                        ->searchable()
                        ->createOptionForm([
                            TextInput::make('name')->required(),
                            TextInput::make('slug')->required(),
                            TextInput::make('color')->default('#ff014f'),
                        ])
                        ->columnSpanFull(),
                ]),

            Section::make('Tags')
                ->description('Free-form tags for filtering on the projects index.')
                ->schema([
                    Select::make('tags')
                        ->multiple()
                        ->relationship('tags', 'name')
                        ->preload()
                        ->searchable()
                        ->createOptionForm([
                            TextInput::make('name')->required(),
                            TextInput::make('slug')->required(),
                        ])
                        ->columnSpanFull(),
                ]),
        ];
    }

    protected static function displayTab(): array
    {
        return [
            Section::make('Display Options')
                ->columns(2)
                ->schema([
                    Toggle::make('is_published')
                        ->label('Published')
                        ->default(true)
                        ->helperText('When OFF, project is hidden from the public site.'),

                    Toggle::make('is_featured')
                        ->label('Featured on homepage')
                        ->default(false),

                    TextInput::make('display_order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers show first.'),

                    DateTimePicker::make('published_at')
                        ->helperText('Schedule for future publishing (optional).'),
                ]),

            Section::make('SEO Overrides (optional)')
                ->description('Fall back to global defaults if blank.')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextInput::make('seo_title')
                        ->maxLength(70)
                        ->helperText('Recommended ≤ 60 chars.'),
                    TextInput::make('seo_description')
                        ->maxLength(160)
                        ->helperText('Recommended ≤ 155 chars.')
                        ->columnSpanFull(),
                ]),
        ];
    }
}
