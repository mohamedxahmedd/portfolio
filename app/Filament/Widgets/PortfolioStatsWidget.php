<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use App\Models\Project;
use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortfolioStatsWidget extends BaseWidget
{
    protected ?string $heading = 'Portfolio at a glance';

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $publishedProjects = Project::published()->count();
        $featuredProjects = Project::published()->featured()->count();
        $totalViews = (int) Project::sum('view_count');
        $unreadMessages = ContactSubmission::unread()->count();
        $approvedTestimonials = Testimonial::approved()->count();

        return [
            Stat::make('Published projects', $publishedProjects)
                ->description("{$featuredProjects} featured on the homepage")
                ->descriptionIcon('heroicon-m-star')
                ->color('primary')
                ->chart([3, 5, 4, 6, 8, 7, $publishedProjects ?: 1]),

            Stat::make('Project views (all time)', number_format($totalViews))
                ->description('Total visits to project detail pages')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),

            Stat::make('Unread messages', $unreadMessages)
                ->description($unreadMessages > 0 ? 'New contact form submissions' : 'You\'re all caught up')
                ->descriptionIcon($unreadMessages > 0 ? 'heroicon-m-envelope-open' : 'heroicon-m-check-circle')
                ->color($unreadMessages > 0 ? 'warning' : 'success'),

            Stat::make('Approved testimonials', $approvedTestimonials)
                ->description('Visible on the public site')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),
        ];
    }
}
