@extends('layouts.dashboard')

@section('content')
@php
    $weekProgress = (int) (($hoursThisWeek['logged'] / $hoursThisWeek['target']) * 100);
@endphp
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ $user['name'] }}!</h1>
            <p class="text-gray-600">{{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-4">
            <x-avatar :name="$user['name']" :email="$user['email']" size="lg" />
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-widget title="Active Internship">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Company</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $activeInternship['company'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Position</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $activeInternship['position'] }}</p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm text-gray-600">Progress</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $activeInternship['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $activeInternship['progress'] }}%"></div>
                        </div>
                    </div>
                </div>
            </x-widget>

            <x-widget title="Pending Tasks" :collapsible="true">
                <div class="space-y-3">
                    @foreach($tasks as $task)
                        @php
                            $priorityBadgeClass = match($task['priority']) {
                                'high' => 'bg-red-100 text-red-800',
                                'medium' => 'bg-yellow-100 text-yellow-800',
                                'low' => 'bg-gray-100 text-gray-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <div class="flex items-center justify-between p-3 rounded-lg border border-gray-200">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $task['title'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Due {{ $task['due'] }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full {{ $priorityBadgeClass }}">
                                {{ ucfirst($task['priority']) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </x-widget>
        </div>

        <div class="space-y-6">
            <x-widget title="Hours This Week">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Logged</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $hoursThisWeek['logged'] }} / {{ $hoursThisWeek['target'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $weekProgress }}%"></div>
                    </div>
                    <div class="text-xs text-gray-500">Monthly total: {{ $hoursThisMonth }} hours</div>
                </div>
            </x-widget>

            <x-widget title="Notifications" :collapsible="true">
                <div class="space-y-2">
                    @foreach($notifications as $notification)
                        <div class="p-3 rounded-lg border border-gray-200 {{ $notification['unread'] ? 'bg-blue-50' : 'bg-white' }}">
                            <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notification['time'] }}</p>
                        </div>
                    @endforeach
                </div>
            </x-widget>
        </div>
    </div>
</div>
@endsection
