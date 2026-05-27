@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Supervisor Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600">Monitor student progress and verifications</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-card title="Interns" value="{{ $stats['interns'] }}" icon="users" color="blue" />
        <x-stats-card title="Active Internships" value="{{ $stats['activeInternships'] }}" icon="briefcase" color="green" />
        <x-stats-card title="Pending Tasks" value="{{ $stats['pendingTasks'] }}" icon="clipboard" color="yellow" />
        <x-stats-card title="Pending Verifications" value="{{ $stats['pendingVerifications'] }}" icon="shield-check" color="purple" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-widget title="Students" :collapsible="true">
            <div class="space-y-4">
                @foreach($students as $student)
                    @php
                        $words = explode(' ', $student['name']);
                        $initials = '';
                        foreach ($words as $word) {
                            $initials .= strtoupper(substr($word, 0, 1));
                        }
                        $statusBadgeClass = match($student['status']) {
                            'good' => 'bg-green-100 text-green-800',
                            'warning' => 'bg-yellow-100 text-yellow-800',
                            'attention' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                    @endphp
                    <div class="p-4 rounded-xl border border-gray-200">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-semibold">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $student['name'] }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $student['company'] }} • {{ $student['position'] }}</p>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full {{ $statusBadgeClass }}">
                                {{ ucfirst($student['status']) }}
                            </span>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-600">Progress</span>
                                <span class="text-xs font-semibold text-gray-900">{{ $student['progress'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $student['progress'] }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-widget>

        <x-widget title="Pending Verifications" :collapsible="true">
            <div class="space-y-3">
                @forelse($verifications as $verification)
                    <div class="p-4 rounded-xl border border-gray-200">
                        <p class="text-sm font-semibold text-gray-900">{{ $verification['student'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $verification['type'] }} • {{ $verification['time'] }}</p>
                    </div>
                @empty
                    <div class="text-sm text-gray-500">No verifications pending</div>
                @endforelse
            </div>
        </x-widget>
    </div>
</div>
@endsection
