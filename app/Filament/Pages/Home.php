<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Company;
use App\Models\Project;

class Home extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.home';

    public function getViewData(): array
    {
        return [
            'totalCompanies' => Company::count(),
            'totalProjects' => Project::count(),
            'recentProjects' => Project::latest()->take(5)->get(),
        ];
    }
}
