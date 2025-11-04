<?php

namespace App\Livewire\Admin;

use App\Models\SignageStats;
use App\Models\SignageMedia;
use App\Models\Category;
use Livewire\Component;
use Carbon\Carbon;

class SignageAnalytics extends Component
{
    public $period = 'today'; // today, week, month
    public $stats = [];
    public $totalViews = 0;
    public $totalRotations = 0;
    public $totalMediaDisplays = 0;
    public $totalUptime = 0;
    public $popularCategories = [];
    public $popularMedia = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        switch ($this->period) {
            case 'today':
                $this->loadTodayStats();
                break;
            case 'week':
                $this->loadWeekStats();
                break;
            case 'month':
                $this->loadMonthStats();
                break;
        }
    }

    private function loadTodayStats()
    {
        $stats = SignageStats::getTodayStats();
        
        if ($stats) {
            $this->totalViews = $stats->total_views;
            $this->totalRotations = $stats->category_rotations;
            $this->totalMediaDisplays = $stats->media_displays;
            $this->totalUptime = $stats->total_uptime_minutes;
            $this->popularCategories = $this->formatPopularCategories($stats->popular_categories ?? []);
            $this->popularMedia = $this->formatPopularMedia($stats->media_views ?? []);
        } else {
            $this->resetStats();
        }
    }

    private function loadWeekStats()
    {
        $stats = SignageStats::getWeekStats();
        
        $this->totalViews = $stats->sum('total_views');
        $this->totalRotations = $stats->sum('category_rotations');
        $this->totalMediaDisplays = $stats->sum('media_displays');
        $this->totalUptime = $stats->sum('total_uptime_minutes');
        
        $allCategories = [];
        $allMedia = [];
        
        foreach ($stats as $stat) {
            foreach ($stat->popular_categories ?? [] as $catId => $count) {
                $allCategories[$catId] = ($allCategories[$catId] ?? 0) + $count;
            }
            foreach ($stat->media_views ?? [] as $mediaId => $count) {
                $allMedia[$mediaId] = ($allMedia[$mediaId] ?? 0) + $count;
            }
        }
        
        $this->popularCategories = $this->formatPopularCategories($allCategories);
        $this->popularMedia = $this->formatPopularMedia($allMedia);
    }

    private function loadMonthStats()
    {
        $stats = SignageStats::getMonthStats();
        
        $this->totalViews = $stats->sum('total_views');
        $this->totalRotations = $stats->sum('category_rotations');
        $this->totalMediaDisplays = $stats->sum('media_displays');
        $this->totalUptime = $stats->sum('total_uptime_minutes');
        
        $allCategories = [];
        $allMedia = [];
        
        foreach ($stats as $stat) {
            foreach ($stat->popular_categories ?? [] as $catId => $count) {
                $allCategories[$catId] = ($allCategories[$catId] ?? 0) + $count;
            }
            foreach ($stat->media_views ?? [] as $mediaId => $count) {
                $allMedia[$mediaId] = ($allMedia[$mediaId] ?? 0) + $count;
            }
        }
        
        $this->popularCategories = $this->formatPopularCategories($allCategories);
        $this->popularMedia = $this->formatPopularMedia($allMedia);
    }

    private function formatPopularCategories($data)
    {
        if (empty($data)) return [];
        
        arsort($data);
        $result = [];
        
        foreach (array_slice($data, 0, 5) as $catId => $count) {
            $category = Category::find($catId);
            if ($category) {
                $result[] = [
                    'name' => $category->name_mm ?? $category->name,
                    'count' => $count,
                ];
            }
        }
        
        return $result;
    }

    private function formatPopularMedia($data)
    {
        if (empty($data)) return [];
        
        arsort($data);
        $result = [];
        
        foreach (array_slice($data, 0, 5) as $mediaId => $count) {
            $media = SignageMedia::find($mediaId);
            if ($media) {
                $result[] = [
                    'title' => $media->title_mm ?? $media->title,
                    'type' => $media->type,
                    'count' => $count,
                ];
            }
        }
        
        return $result;
    }

    private function resetStats()
    {
        $this->totalViews = 0;
        $this->totalRotations = 0;
        $this->totalMediaDisplays = 0;
        $this->totalUptime = 0;
        $this->popularCategories = [];
        $this->popularMedia = [];
    }

    public function setPeriod($period)
    {
        $this->period = $period;
        $this->loadStats();
    }

    public function render()
    {
        return view('livewire.admin.signage-analytics');
    }
}
