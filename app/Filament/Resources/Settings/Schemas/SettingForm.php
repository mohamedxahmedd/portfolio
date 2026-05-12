<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('settings_tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Appearance')
                            ->icon('heroicon-o-paint-brush')
                            ->badge(count(config('themes.themes', [])).' themes')
                            ->schema([
                                Section::make('Active theme')
                                    ->description('Pick the theme used on the public portfolio. Your content stays the same — only the look changes. The site updates instantly after saving.')
                                    ->schema([
                                        Radio::make('active_theme')
                                            ->label(false)
                                            ->required()
                                            ->default('reeni')
                                            ->options(collect(config('themes.themes', []))->mapWithKeys(fn ($cfg, $slug) => [
                                                $slug => new HtmlString(
                                                    '<div style="display:flex;align-items:center;gap:14px;padding:6px 0;">'
                                                    .'<span style="font-size:32px;line-height:1;">'.e($cfg['preview_emoji'] ?? '🎨').'</span>'
                                                    .'<div>'
                                                    .'<div style="font-weight:600;font-size:16px;color:#fff;">'.e($cfg['name']).'</div>'
                                                    .'<div style="font-size:12px;opacity:.7;margin-top:2px;max-width:520px;">'.e($cfg['description']).'</div>'
                                                    .'<div style="margin-top:6px;display:flex;gap:6px;flex-wrap:wrap;">'
                                                    .collect($cfg['tags'] ?? [])->map(fn ($t) => '<span style="font-size:10px;text-transform:uppercase;letter-spacing:.05em;padding:2px 8px;border-radius:99px;background:'.e($cfg['primary']).'22;color:'.e($cfg['primary']).';border:1px solid '.e($cfg['primary']).'55;">'.e($t).'</span>')->join('')
                                                    .'</div>'
                                                    .'</div>'
                                                    .'</div>'
                                                ),
                                            ])->all())
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Branding')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Section::make('Site identity')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('site_name')->required()->maxLength(60),
                                        TextInput::make('site_tagline')->maxLength(160),
                                        Textarea::make('site_description')
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->helperText('Used for the meta description (SEO) and social-share previews.')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Logo & Favicon')
                                    ->columns(3)
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('logo')
                                            ->collection('logo')
                                            ->image()
                                            ->imageEditor(),
                                        SpatieMediaLibraryFileUpload::make('favicon')
                                            ->collection('favicon')
                                            ->image()
                                            ->imageResizeTargetWidth('64')
                                            ->imageResizeTargetHeight('64'),
                                        SpatieMediaLibraryFileUpload::make('og_image')
                                            ->label('Default OG image')
                                            ->collection('og_image')
                                            ->image()
                                            ->helperText('Default social-share image (1200×630).'),
                                    ]),
                            ]),

                        Tab::make('Theme')
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                Section::make('Colors')
                                    ->columns(2)
                                    ->schema([
                                        ColorPicker::make('theme_primary_color')->default('#ff014f'),
                                        ColorPicker::make('theme_dark_bg')->default('#1a1a1a'),
                                    ]),
                                Section::make('Fonts')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('theme_font_body')->default('Rubik')->helperText('Google / Bunny Fonts family for body text.'),
                                        TextInput::make('theme_font_display')->default('Rajdhani')->helperText('Google / Bunny Fonts family for display headings.'),
                                    ]),
                                Section::make('Display preferences')
                                    ->columns(2)
                                    ->schema([
                                        Toggle::make('show_dark_light_toggle')->default(true)->helperText('Add a theme switcher to the header.'),
                                        Toggle::make('default_dark_mode')->default(true)->helperText('Site loads in dark mode by default.'),
                                    ]),
                            ]),

                        Tab::make('Analytics')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Section::make('Tracking IDs')
                                    ->schema([
                                        TextInput::make('google_analytics_id')->placeholder('G-XXXXXXXXXX')->helperText('GA4 Measurement ID — paste yours to enable Google Analytics.'),
                                        TextInput::make('plausible_domain')->placeholder('your-domain.com')->helperText('Domain registered in Plausible — leave blank to disable.'),
                                    ]),
                            ]),

                        Tab::make('Maintenance')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->schema([
                                Section::make('Maintenance mode')
                                    ->description('Enable to show a maintenance page instead of the public site.')
                                    ->schema([
                                        Toggle::make('maintenance_mode')->default(false),
                                        Textarea::make('maintenance_message')->rows(2)->placeholder("We'll be back shortly!"),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
