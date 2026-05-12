<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\ContactInfo;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Models\Testimonial;
use App\Support\ThemeManager;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view(ThemeManager::view('home'), [
            'about' => AboutSection::current(),
            'contact' => ContactInfo::current(),
            'settings' => Setting::current(),
            'experiences' => Experience::orderBy('display_order')->orderByDesc('start_date')->get(),
            'educations' => Education::orderBy('display_order')->orderByDesc('start_date')->get(),
            'skillCategories' => SkillCategory::with('skills')->orderBy('display_order')->get(),
            'services' => Service::where('is_active', true)->orderBy('display_order')->get(),
            'projects' => Project::with(['technologies', 'media'])
                ->published()->ordered()->limit(6)->get(),
            'testimonials' => Testimonial::approved()->ordered()->limit(6)->get(),
            'socialLinks' => SocialLink::active()->ordered()->get(),
        ]);
    }
}
