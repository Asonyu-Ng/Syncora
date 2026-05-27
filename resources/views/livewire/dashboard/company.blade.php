@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Company Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600">Track internships and applications</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stats-card
            title="Posted Internships"
            value="{{ $stats['postedInternships'] }}"
            trend="{{ $stats['postedInternshipsTrend'] }}"
            trendDirection="up"
            icon="folder"
            color="blue"
        />

        <x-stats-card
            title="Applications Received"
            value="{{ $stats['applicationsReceived'] }}"
            trend="{{ $stats['applicationsReceivedTrend'] }}"
            trendDirection="up"
            icon="document"
            color="green"
        />

        <x-stats-card
            title="Active Positions"
            value="{{ $stats['activePositions'] }}"
            icon="briefcase"
            color="yellow"
        />

        <x-stats-card
            title="Hired This Month"
            value="{{ $stats['hiredThisMonth'] }}"
            icon="check-circle"
            color="purple"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-widget title="Active Internships" :collapsible="true">
            <div class="space-y-3">
                @foreach($activeInternships as $internship)
                    <div class="p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $internship['title'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $internship['location'] }} • {{ $internship['duration'] }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">{{ $internship['applications'] }} apps</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-3">{{ $internship['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </x-widget>

        <x-widget title="Recent Applications" :collapsible="true">
            <div class="space-y-3">
                @foreach($recentApplications as $app)
                    <div class="flex items-start justify-between p-4 border border-gray-200 rounded-xl">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $app['student'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $app['internship'] }} • {{ $app['university'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $app['time'] }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ $app['major'] }}</span>
                    </div>
                @endforeach
            </div>
        </x-widget>
    </div>
</div>
@endsection
