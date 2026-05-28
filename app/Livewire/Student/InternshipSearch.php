<?php

namespace App\Livewire\Student;

use App\Services\InternshipService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class InternshipSearch extends Component
{
    public string $city = '';
    public bool $searched = false;
    public array $results = [];

    public function search(): void
    {
        $this->searched = true;
        $this->results = app(InternshipService::class)->searchInternships($this->city);
    }

    public function mount(): void
    {
        $this->search();
    }

    public function render(): View
    {
        return view('livewire.student.internship-search', [
            'title' => 'Internship Search',
        ])->extends('layouts.dashboard')->section('content');
    }
}
