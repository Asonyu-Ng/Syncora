<?php

namespace App\Livewire\Admin;

use App\Services\AnalyticsService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AnalyticsDashboard extends Component
{
    public array $kpis = [];
    public array $trafficSources = [];

    public function mount(): void
    {
        $service = app(AnalyticsService::class);

        $this->kpis = $service->getAdminKpis();
        $this->trafficSources = $service->getTrafficSources();
    }

    public function render(): View
    {
        return view('livewire.admin.analytics-dashboard', [
            'title' => 'Analytics Dashboard',
        ])->extends('layouts.dashboard')->section('content');
    }
}
