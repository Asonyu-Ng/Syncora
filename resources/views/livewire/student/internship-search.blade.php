@php
    $user = auth()->user();
    $profile = $user?->studentProfile;
    $applicationsCount = $profile?->applications()->count() ?? 0;
    $savedInternshipsCount = $profile?->savedInternships()->count() ?? 0;
    $savedSearchesCount = $profile?->savedSearches()->count() ?? 0;

    $profileFields = ['university', 'department', 'level', 'phone', 'address', 'bio'];
    $completedFields = 0;
    foreach ($profileFields as $field) {
        if ($profile && trim((string) ($profile->{$field} ?? '')) !== '') {
            $completedFields++;
        }
    }
    $profileCompletion = $profileFields !== []
        ? (int) round(($completedFields / count($profileFields)) * 100)
        : 0;
@endphp

<div class="space-y-8 dark:[&_.text-neutral-900]:text-neutral-50 dark:[&_.text-neutral-700]:text-neutral-200 dark:[&_.text-neutral-600]:text-neutral-300 dark:[&_.text-neutral-500]:text-neutral-400 dark:[&_.text-neutral-400]:text-neutral-500">
    @if(session()->has('message'))
        <div class="rounded-2xl border border-primary-100 bg-primary-50 px-5 py-4 text-sm font-semibold text-primary-800 shadow-soft">
            {{ session('message') }}
        </div>
    @endif

    <x-dashboard.page-header
        badge="Internship search"
        title="Internship Search"
        description="Search by keywords, location, work type, and other filters, then save useful searches to return faster next time."
    />

    <x-dashboard.two-column>
        <x-slot:main>
            <div class="space-y-6">
            <div x-data="{ moreFilters: false }" class="rounded-2xl border border-neutral-200 bg-white shadow-card dark:border-neutral-800 dark:bg-neutral-950">
                <form wire:submit.prevent="search" class="p-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                        <div class="md:col-span-6">
                            <label class="block text-sm font-semibold text-neutral-900" for="internship-keywords">Keywords</label>
                            <div class="mt-2">
                                <x-text-input id="internship-keywords" type="text" wire:model.defer="keywords" placeholder="e.g., Laravel, UI/UX, Data Analyst" />
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-sm font-semibold text-neutral-900" for="internship-location">Location</label>
                            <div class="mt-2">
                                <select
                                    id="internship-location"
                                    wire:model.defer="location"
                                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100"
                                >
                                    <option value="">Any location</option>
                                    <option value="Remote">Remote</option>
                                    <option value="Lagos">Lagos</option>
                                    <option value="Abuja">Abuja</option>
                                    <option value="Port Harcourt">Port Harcourt</option>
                                </select>
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-sm font-semibold text-neutral-900" for="internship-type">Work Type</label>
                            <div class="mt-2">
                                <select
                                    id="internship-type"
                                    wire:model.defer="type"
                                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100"
                                >
                                    <option value="">Any type</option>
                                    <option value="On-site">On-site</option>
                                    <option value="Hybrid">Hybrid</option>
                                    <option value="Remote">Remote</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="moreFilters" x-transition class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-12">
                        <div class="md:col-span-4">
                            <label class="block text-sm font-semibold text-neutral-900" for="internship-category">Category</label>
                            <div class="mt-2">
                                <select
                                    id="internship-category"
                                    wire:model.defer="category"
                                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                >
                                    <option value="">All categories</option>
                                    <option value="Software Engineering">Software Engineering</option>
                                    <option value="Data">Data</option>
                                    <option value="Design">Design</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Operations">Operations</option>
                                </select>
                            </div>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-sm font-semibold text-neutral-900" for="internship-duration">Duration</label>
                            <div class="mt-2">
                                <select
                                    id="internship-duration"
                                    wire:model.defer="duration"
                                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                >
                                    <option value="">Any duration</option>
                                    <option value="4 weeks">4 weeks</option>
                                    <option value="8 weeks">8 weeks</option>
                                    <option value="12 weeks">12 weeks</option>
                                    <option value="3 months">3 months</option>
                                    <option value="6 months">6 months</option>
                                </select>
                            </div>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-sm font-semibold text-neutral-900" for="internship-posted-within">Posted Within</label>
                            <div class="mt-2">
                                <select
                                    id="internship-posted-within"
                                    wire:model.defer="postedWithin"
                                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                >
                                    <option value="">Any time</option>
                                    <option value="24h">Last 24 hours</option>
                                    <option value="7d">Last 7 days</option>
                                    <option value="14d">Last 14 days</option>
                                    <option value="30d">Last 30 days</option>
                                    <option value="60d">Last 60 days</option>
                                </select>
                            </div>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-sm font-semibold text-neutral-900" for="internship-per-page">Results Per Page</label>
                            <div class="mt-2">
                                <select
                                    id="internship-per-page"
                                    wire:model.defer="perPage"
                                    class="h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                >
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <button
                            type="button"
                            @click="moreFilters = !moreFilters"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 py-2.5 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                        >
                            <span x-text="moreFilters ? 'Less Filters' : 'More Filters'"></span>
                            <svg class="h-4 w-4 text-neutral-500 transition-transform" :class="moreFilters ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <x-primary-button type="submit" wire:loading.attr="disabled">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                            </svg>
                            <span wire:loading.remove>Search</span>
                            <span wire:loading>Searching...</span>
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div class="flex flex-col gap-3 rounded-2xl border border-neutral-200 bg-white p-4 shadow-soft sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm font-semibold text-neutral-900">
                    {{ $results->total() }} internships found
                </div>

                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                    <div class="sm:w-56">
                        <label class="sr-only" for="internship-sort">Sort</label>
                        <select
                            id="internship-sort"
                            wire:model.live="sort"
                            wire:change="search"
                            class="h-11 w-full rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-900 shadow-soft focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                        >
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                        </select>
                    </div>

                    <button
                        type="button"
                        wire:click="openSaveSearchModal"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                    >
                        <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Save Search
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($results as $internship)
                    @php
                        $companyName = (string) ($internship['company_name'] ?? '');
                        $companyName = $companyName !== '' ? $companyName : 'Company';
                        $initials = collect(preg_split('/\s+/', trim($companyName), -1, PREG_SPLIT_NO_EMPTY) ?: [])
                            ->take(2)
                            ->map(fn (string $part): string => strtoupper(substr($part, 0, 1)))
                            ->implode('');
                        $initials = $initials !== '' ? $initials : 'CO';

                        $postedAt = $internship['created_at'] ?? null;
                        $postedLabel = $postedAt ? \Illuminate\Support\Carbon::parse($postedAt)->diffForHumans() : null;

                        $tags = $internship['tags'] ?? [];
                        $visibleTags = array_slice($tags, 0, 3);
                        $remainingTags = max(0, count($tags) - count($visibleTags));

                        $internshipId = (int) $internship['id'];
                        $isSaved = in_array($internshipId, $savedInternshipIds ?? [], true);
                        $isApplied = in_array($internshipId, $appliedInternshipIds ?? [], true);
                    @endphp

                    <div wire:key="internship-{{ $internship['id'] }}" class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-soft transition hover:border-neutral-300 sm:p-6">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-primary-600/10 text-sm font-semibold text-primary-700">
                                    {{ $initials }}
                                </div>

                                <div class="min-w-0">
                                    <a href="{{ route('student.internships.show', $internship['id']) }}" class="block truncate text-base font-semibold text-neutral-900 hover:text-primary-600">
                                        {{ $internship['title'] }}
                                    </a>
                                    <div class="mt-1 text-sm text-neutral-600">{{ $companyName }}</div>

                                    <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-neutral-600">
                                        <div class="inline-flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="truncate">{{ $internship['location'] ?: 'Location flexible' }}</span>
                                        </div>

                                        <div class="inline-flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4" />
                                            </svg>
                                            <span>{{ $internship['type'] ?: 'Internship' }}</span>
                                        </div>

                                        @if($postedLabel)
                                            <div class="inline-flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Posted {{ $postedLabel }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @if(!empty($internship['category']))
                                            <span class="inline-flex items-center rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700">
                                                {{ $internship['category'] }}
                                            </span>
                                        @endif

                                        @foreach($visibleTags as $tag)
                                            <span class="inline-flex items-center rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-700">
                                                {{ $tag }}
                                            </span>
                                        @endforeach

                                        @if($remainingTags > 0)
                                            <span class="inline-flex items-center rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-700">
                                                +{{ $remainingTags }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 sm:items-end">
                                <button
                                    type="button"
                                    wire:click="toggleBookmark({{ $internshipId }})"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-neutral-200 bg-white shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $isSaved ? 'text-primary-600' : 'text-neutral-500' }}"
                                    aria-label="{{ $isSaved ? 'Unsave internship' : 'Save internship' }}"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v17l-7-4-7 4V5z" />
                                    </svg>
                                </button>

                                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                                    <a
                                        href="{{ route('student.internships.show', $internship['id']) }}"
                                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-900 shadow-soft transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25"
                                    >
                                        View Details
                                    </a>
                                    <button
                                        type="button"
                                        wire:click="applyNow({{ $internshipId }})"
                                        wire:loading.attr="disabled"
                                        wire:target="applyNow({{ $internshipId }})"
                                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl px-5 text-sm font-semibold shadow-soft transition focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25 {{ $isApplied ? 'cursor-not-allowed bg-neutral-200 text-neutral-600' : 'bg-primary-600 text-white hover:bg-primary-500' }}"
                                        @disabled($isApplied)
                                    >
                                        <span wire:loading.remove wire:target="applyNow({{ $internshipId }})">{{ $isApplied ? 'Applied' : 'Apply Now' }}</span>
                                        <span wire:loading wire:target="applyNow({{ $internshipId }})">Applying...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-200 bg-white p-10 text-center shadow-soft">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-neutral-100 text-neutral-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-neutral-900">No internships found</h3>
                        <p class="mt-2 text-sm text-neutral-600">
                            {{ $searched ? 'Try adjusting your keywords or filters to broaden the results.' : 'Start by searching for internships using the filters above.' }}
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="pt-2">
                {{ $results->withQueryString()->onEachSide(1)->links() }}
            </div>
            </div>
        </x-slot:main>

        <x-slot:aside>
            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Quick Actions</h2>
                <div class="mt-4 space-y-3">
                    <a href="{{ route('student.applications.index') }}" class="flex items-center justify-between rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm font-semibold text-neutral-900 transition hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        <span class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v13a2 2 0 01-2 2z" />
                            </svg>
                            My Applications
                        </span>
                        <span class="inline-flex h-6 items-center rounded-full bg-white px-2 text-xs font-semibold text-neutral-700 shadow-soft">{{ $applicationsCount }}</span>
                    </a>

                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-900">
                        <span class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v17l-7-4-7 4V5z" />
                            </svg>
                            Saved Internships
                        </span>
                        <span class="inline-flex h-6 items-center rounded-full bg-neutral-100 px-2 text-xs font-semibold text-neutral-700">{{ $savedInternshipsCount }}</span>
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-900">
                        <span class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Saved Searches
                        </span>
                        <span class="inline-flex h-6 items-center rounded-full bg-neutral-100 px-2 text-xs font-semibold text-neutral-700">{{ $savedSearchesCount }}</span>
                    </div>

                    <a href="{{ route('student.profile') }}" class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white px-4 py-3 text-sm font-semibold text-neutral-900 transition hover:bg-neutral-50 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        <span class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.657-1.343 3-3 3S6 12.657 6 11s1.343-3 3-3 3 1.343 3 3zm0 0c0 1.657 1.343 3 3 3s3-1.343 3-3-1.343-3-3-3-3 1.343-3 3zm-9 9a9 9 0 0118 0H3z" />
                            </svg>
                            Application Tips
                        </span>
                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <h2 class="text-sm font-semibold text-neutral-900">Recommended Filters</h2>
                <p class="mt-1 text-sm text-neutral-600">One tap presets to refine your search.</p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <button type="button" wire:click="$set('type', 'Remote'); search()" class="inline-flex items-center rounded-full bg-neutral-100 px-4 py-2 text-xs font-semibold text-neutral-700 transition hover:bg-neutral-200 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        Remote
                    </button>
                    <button type="button" wire:click="$set('type', 'Hybrid'); search()" class="inline-flex items-center rounded-full bg-neutral-100 px-4 py-2 text-xs font-semibold text-neutral-700 transition hover:bg-neutral-200 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        Hybrid
                    </button>
                    <button type="button" wire:click="$set('location', 'Lagos'); search()" class="inline-flex items-center rounded-full bg-neutral-100 px-4 py-2 text-xs font-semibold text-neutral-700 transition hover:bg-neutral-200 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        Lagos
                    </button>
                    <button type="button" wire:click="$set('category', 'Software Engineering'); search()" class="inline-flex items-center rounded-full bg-neutral-100 px-4 py-2 text-xs font-semibold text-neutral-700 transition hover:bg-neutral-200 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        Engineering
                    </button>
                    <button type="button" wire:click="$set('postedWithin', '7d'); search()" class="inline-flex items-center rounded-full bg-neutral-100 px-4 py-2 text-xs font-semibold text-neutral-700 transition hover:bg-neutral-200 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        Posted in 7 days
                    </button>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-900">Complete Your Profile</h2>
                        <p class="mt-1 text-sm text-neutral-600">Profiles with more detail stand out to recruiters.</p>
                    </div>
                    <div class="rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700">{{ $profileCompletion }}%</div>
                </div>

                <div class="mt-4">
                    <div class="h-2 w-full overflow-hidden rounded-full bg-neutral-100">
                        <div class="h-2 rounded-full bg-primary-600 transition-all" style="width: {{ $profileCompletion }}%"></div>
                    </div>
                </div>

                <div class="mt-4 space-y-2 text-sm text-neutral-700">
                    @foreach($profileFields as $field)
                        @php
                            $filled = $profile && trim((string) ($profile->{$field} ?? '')) !== '';
                            $label = match ($field) {
                                'university' => 'University',
                                'department' => 'Department',
                                'level' => 'Level',
                                'phone' => 'Phone number',
                                'address' => 'Address',
                                default => 'Bio',
                            };
                        @endphp
                        <div class="flex items-center justify-between gap-3">
                            <span>{{ $label }}</span>
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full {{ $filled ? 'bg-success-50 text-success-700' : 'bg-neutral-100 text-neutral-400' }}">
                                @if($filled)
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('student.profile') }}" class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                    Update Profile
                </a>
            </div>
        </x-slot:aside>
    </x-dashboard.two-column>

    <x-modal name="save-search" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-neutral-900">Save this search</h2>
            <p class="mt-2 text-sm text-neutral-600">Give your search a name so you can revisit it later.</p>

            <div class="mt-4">
                <label class="block text-sm font-semibold text-neutral-900" for="saved-search-name">Search name</label>
                <div class="mt-2">
                    <x-text-input id="saved-search-name" type="text" wire:model.defer="savedSearchName" />
                    <x-input-error :messages="$errors->get('savedSearchName')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button type="button" @click="$dispatch('close-modal', 'save-search')">
                    Cancel
                </x-secondary-button>
                <x-primary-button type="button" wire:click="saveSearch" wire:loading.attr="disabled">
                    Save
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
