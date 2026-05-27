@extends('layouts.dashboard')

@section('content')
@php
    $maxRegistrationValue = max($registrationData['values']);
@endphp
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600">Overview of system metrics and activities</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-card
            title="Total Users"
            value="{{ number_format($stats['totalUsers']) }}"
            trend="{{ $stats['userTrend'] }}"
            trendDirection="up"
            icon="users"
            color="blue"
        />

        <x-stats-card
            title="Total Internships"
            value="{{ number_format($stats['totalInternships']) }}"
            trend="{{ $stats['internshipTrend'] }}"
            trendDirection="up"
            icon="briefcase"
            color="green"
        />

        <x-stats-card
            title="Active Applications"
            value="{{ number_format($stats['activeApplications']) }}"
            trend="{{ $stats['applicationTrend'] }}"
            trendDirection="down"
            icon="document"
            color="yellow"
        />

        <x-stats-card
            title="Pending Verifications"
            value="{{ number_format($stats['pendingVerifications']) }}"
            icon="shield-check"
            color="purple"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-widget title="User Registrations" :collapsible="true">
            <div class="space-y-4">
                <div class="flex items-end justify-between space-x-2 h-40">
                    @foreach($registrationData['values'] as $value)
                        <div class="flex-1">
                            <div
                                class="w-full bg-gradient-to-t from-blue-500 to-blue-600 rounded-t-md"
                                style="height: {{ ($value / $maxRegistrationValue) * 100 }}%"
                                title="{{ $value }} registrations"
                            ></div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    @foreach($registrationData['labels'] as $label)
                        <span class="flex-1 text-center">{{ $label }}</span>
                    @endforeach
                </div>
            </div>
        </x-widget>

        <x-widget title="Recent Activity" :collapsible="true">
            <div class="space-y-3">
                @foreach($activities as $activity)
                    @php
                        $activityColor = match($activity['type']) {
                            'registration' => 'bg-blue-100 text-blue-600',
                            'internship' => 'bg-green-100 text-green-600',
                            'verification' => 'bg-purple-100 text-purple-600',
                            'application' => 'bg-yellow-100 text-yellow-600',
                            'task' => 'bg-indigo-100 text-indigo-600',
                            'report' => 'bg-gray-100 text-gray-600',
                            default => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="p-2 rounded-full {{ $activityColor }}">
                            <span class="text-xs font-semibold">{{ strtoupper(substr($activity['type'], 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-widget>
    </div>
</div>
@endsection
