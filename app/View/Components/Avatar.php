<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    public function __construct(
        public string $name,
        public ?string $email = null,
        public ?string $src = null,
        public string $size = 'md',
        public bool $showOnlineStatus = false
    ) {}

    public function getInitials(): string
    {
        $names = explode(' ', trim($this->name));

        if (count($names) >= 2) {
            return strtoupper($names[0][0] . end($names)[0]);
        }

        return strtoupper($this->name[0]);
    }

    public function getColorClass(): string
    {
        $colors = [
            'bg-blue-500',
            'bg-green-500',
            'bg-yellow-500',
            'bg-red-500',
            'bg-purple-500',
            'bg-indigo-500',
            'bg-pink-500',
        ];

        $hash = crc32($this->name);
        $index = abs($hash) % count($colors);

        return $colors[$index];
    }

    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'xs' => 'w-6 h-6 text-xs',
            'sm' => 'w-8 h-8 text-sm',
            'md' => 'w-10 h-10 text-base',
            'lg' => 'w-12 h-12 text-lg',
            'xl' => 'w-16 h-16 text-xl',
            default => 'w-10 h-10 text-base',
        };
    }

    public function render(): View|Closure|string
    {
        return view('components.avatar');
    }
}

