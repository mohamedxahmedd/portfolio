<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactSubmissions\ContactSubmissionResource;
use App\Models\ContactSubmission;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentContactsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent contact submissions';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactSubmission::query()->latest()->limit(5)
            )
            ->columns([
                IconColumn::make('is_read')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('warning')
                    ->label(''),
                TextColumn::make('name')->weight('bold'),
                TextColumn::make('email'),
                TextColumn::make('subject')->limit(40),
                TextColumn::make('created_at')->since(),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (ContactSubmission $record): string => ContactSubmissionResource::getUrl('edit', ['record' => $record])),
            ])
            ->emptyStateHeading('No submissions yet')
            ->emptyStateDescription('When visitors submit the contact form, they\'ll appear here.')
            ->emptyStateIcon('heroicon-o-inbox');
    }
}
