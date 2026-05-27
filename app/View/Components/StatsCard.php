<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatsCard extends Component
{
    public function __construct(
        public string $title = '',
        public string $value = '0',
        public string $trend = '0%',
        public string $trendDirection = 'neutral',
        public string $icon = 'chart-bar',
        public string $color = 'blue'
    ) {}

    public function getTrendColor(): string
    {
        return match ($this->trendDirection) {
            'up' => 'bg-green-100 text-green-800',
            'down' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getIconColor(): string
    {
        return match ($this->color) {
            'blue' => 'bg-blue-100 text-blue-600',
            'green' => 'bg-green-100 text-green-600',
            'yellow' => 'bg-yellow-100 text-yellow-600',
            'red' => 'bg-red-100 text-red-600',
            'purple' => 'bg-purple-100 text-purple-600',
            'gray' => 'bg-gray-100 text-gray-600',
            default => 'bg-blue-100 text-blue-600'
        };
    }

    public function getArrowDirection(): string
    {
        return $this->trendDirection === 'up' ? 'rotate-0' : 'rotate-180';
    }

    public function shouldShowTrend(): bool
    {
        return $this->trend !== '0%' && $this->trend !== '';
    }

    public function render(): View|Closure|string
    {
        return view('components.stats-card');
    }
}

