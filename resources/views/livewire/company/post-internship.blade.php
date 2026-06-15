@php
    $checklist = [
        ['label' => 'Internship title', 'done' => trim($internshipTitle) !== ''],
        ['label' => 'Department', 'done' => trim($department) !== ''],
        ['label' => 'Location', 'done' => trim($location) !== ''],
        ['label' => 'Type', 'done' => trim($type) !== ''],
        ['label' => 'Duration', 'done' => (int) $durationInMonths > 0],
        ['label' => 'Description', 'done' => trim($description) !== ''],
        ['label' => 'Education level', 'done' => trim($educationLevel) !== ''],
        ['label' => 'Skills', 'done' => count($requiredSkills) > 0],
    ];
    $completedSteps = collect($checklist)->where('done', true)->count();
    $totalSteps = count($checklist);
    $progressPercent = $totalSteps > 0 ? (int) round(($completedSteps / $totalSteps) * 100) : 0;
@endphp

<div class="space-y-6">
    @if (session('message'))
        <div class="rounded-2xl border border-success-200 bg-success-50 px-4 py-3 text-sm font-medium text-success-700 dark:border-success-500/20 dark:bg-success-500/10 dark:text-success-200">
            {{ session('message') }}
        </div>
    @endif

    <x-dashboard.page-header
        badge="Internship publishing"
        title="Post New Internship"
        description="Share an internship opportunity in Cameroon and attract the right student talent for your team."
    >
        <x-slot:actions>
            <a
                href="{{ route('company.internships.index') }}"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-700 shadow-soft transition hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <x-dashboard.two-column>
        <x-slot:main>
            <form wire:submit="submit" class="rounded-[28px] border border-neutral-200 bg-white shadow-soft dark:border-neutral-800 dark:bg-neutral-950">
                <div class="space-y-8 p-6 lg:p-8">
                    <section class="space-y-5">
                        <div class="flex items-center gap-3 border-b border-neutral-200 pb-4 dark:border-neutral-800">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-200">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10l3 3v13a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1h2z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">Internship Information</h2>
                                <p class="text-[14px] leading-6 text-neutral-500 dark:text-neutral-400">Capture the role details, work mode, and internship duration.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                            <div>
                                <label for="internshipTitle" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Internship Title <span class="text-danger-500">*</span></label>
                                <input id="internshipTitle" type="text" wire:model.defer="internshipTitle" placeholder="e.g. Frontend Developer Intern" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500" />
                                @error('internshipTitle') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="department" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Department / Field <span class="text-danger-500">*</span></label>
                                <input id="department" type="text" wire:model.defer="department" placeholder="e.g. Information Technology" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500" />
                                @error('department') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="location" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Location <span class="text-danger-500">*</span></label>
                                <input id="location" type="text" wire:model.defer="location" placeholder="e.g. Douala, Cameroon / Remote" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500" />
                                @error('location') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="type" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Type <span class="text-danger-500">*</span></label>
                                    <select id="type" wire:model.defer="type" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100">
                                        @foreach ($typeOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('type') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <div class="flex items-center justify-between">
                                        <label for="durationInMonths" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Duration <span class="text-danger-500">*</span></label>
                                        <span class="text-xs font-semibold text-primary-700 dark:text-primary-200">{{ $durationInMonths }} {{ $durationInMonths === 1 ? 'month' : 'months' }}</span>
                                    </div>
                                    <div class="mt-4 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4 dark:border-neutral-800 dark:bg-neutral-900/60">
                                        <input id="durationInMonths" type="range" min="1" max="5" step="1" wire:model.live="durationInMonths" class="h-2 w-full cursor-pointer appearance-none rounded-full bg-primary-100 accent-primary-600 dark:bg-primary-500/20 dark:accent-primary-400" />
                                        <div class="mt-2 flex justify-between text-[11px] font-medium text-neutral-400 dark:text-neutral-500">
                                            <span>1 month</span>
                                            <span>5 months</span>
                                        </div>
                                    </div>
                                    @error('durationInMonths') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="flex items-center justify-between">
                                    <label for="description" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Description <span class="text-danger-500">*</span></label>
                                    <span class="text-xs text-neutral-400 dark:text-neutral-500">{{ mb_strlen($description) }}/1000</span>
                                </div>
                                <textarea id="description" rows="6" wire:model.defer="description" placeholder="Describe the role, responsibilities, and what the intern will learn in your Yaounde, Douala, or remote team." class="mt-2 w-full rounded-[24px] border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500"></textarea>
                                @error('description') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </section>

                    <section class="space-y-5">
                        <div class="flex items-center gap-3 border-b border-neutral-200 pb-4 dark:border-neutral-800">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-200">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">Requirements</h2>
                                <p class="text-[14px] leading-6 text-neutral-500 dark:text-neutral-400">Define the skills, education expectations, and any extra notes for applicants.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                            <div>
                                <label for="skillInput" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Required Skills <span class="text-danger-500">*</span></label>
                                <div class="mt-2 rounded-[24px] border border-neutral-200 bg-white px-4 py-4 dark:border-neutral-800 dark:bg-neutral-950">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($requiredSkills as $index => $skill)
                                            <span class="inline-flex items-center gap-2 rounded-full bg-primary-50 px-3 py-1.5 text-xs font-semibold text-primary-700 dark:bg-primary-500/10 dark:text-primary-200">
                                                {{ $skill }}
                                                <button type="button" wire:click="removeSkill({{ $index }})" class="text-primary-500 transition hover:text-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:text-primary-200 dark:hover:text-primary-100">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </span>
                                        @endforeach
                                    </div>

                                    <div class="mt-3 flex gap-3">
                                        <input id="skillInput" type="text" wire:model.defer="skillInput" wire:keydown.enter.prevent="addSkill" placeholder="Add skills like PHP, Laravel, UI Design" class="h-11 flex-1 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-900/60 dark:text-neutral-100 dark:placeholder:text-neutral-500" />
                                        <button type="button" wire:click="addSkill" class="inline-flex h-11 items-center justify-center rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900">
                                            Add
                                        </button>
                                    </div>

                                    <p class="mt-3 text-[12px] leading-5 text-neutral-400 dark:text-neutral-500">Type a skill and press Enter to add it as a tag.</p>
                                </div>
                                @error('requiredSkills') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                                @error('requiredSkills.*') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="educationLevel" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Education Level <span class="text-danger-500">*</span></label>
                                <select id="educationLevel" wire:model.defer="educationLevel" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100">
                                    <option value="">Select education level</option>
                                    @foreach ($educationLevelOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('educationLevel') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="otherRequirements" class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Other Requirements</label>
                                    <span class="text-xs text-neutral-400 dark:text-neutral-500">{{ mb_strlen($otherRequirements) }}/500</span>
                                </div>
                                <textarea id="otherRequirements" rows="4" wire:model.defer="otherRequirements" placeholder="Any other requirements for applicants in Bamenda, Buea, or remote placements?" class="mt-2 w-full rounded-[24px] border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:placeholder:text-neutral-500"></textarea>
                                @error('otherRequirements') <p class="mt-2 text-xs font-medium text-danger-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Attach Files <span class="font-normal text-neutral-400 dark:text-neutral-500">(Optional)</span></label>
                                    <span class="rounded-full border border-neutral-200 bg-white px-2.5 py-1 text-[11px] font-semibold text-neutral-500 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-400">Coming soon</span>
                                </div>
                                <div class="pointer-events-none mt-2 flex min-h-[160px] items-center justify-center rounded-[24px] border border-dashed border-neutral-200 bg-neutral-50 px-6 py-7 text-center opacity-80 dark:border-neutral-800 dark:bg-neutral-900/60">
                                    <div class="space-y-3">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-primary-600 shadow-soft dark:bg-neutral-950 dark:text-primary-200">
                                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Attachments will be available soon</p>
                                            <p class="text-xs text-neutral-400 dark:text-neutral-500">PDF, DOC, DOCX</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="flex flex-col gap-3 border-t border-neutral-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between lg:px-8 dark:border-neutral-800">
                    <button type="button" wire:click="cancel" class="inline-flex h-11 items-center justify-center rounded-2xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-200 dark:hover:bg-neutral-900">
                        Cancel
                    </button>

                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-2xl bg-primary-600 px-5 text-sm font-semibold text-white shadow-soft transition hover:bg-primary-500 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-primary-500/25">
                        Publish Internship
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6l6 6-6 6" />
                        </svg>
                    </button>
                </div>
            </form>
        </x-slot:main>

        <x-slot:aside>
            <x-widget title="Publishing checklist" :collapsible="false">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">{{ $completedSteps }} of {{ $totalSteps }} completed</p>
                    <span class="rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700 ring-1 ring-inset ring-primary-100 dark:bg-primary-500/10 dark:text-primary-200 dark:ring-primary-500/20">
                        {{ $progressPercent }}%
                    </span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-neutral-100 dark:bg-neutral-900">
                    <div class="h-full rounded-full bg-primary-600" style="width: {{ $progressPercent }}%"></div>
                </div>
                <div class="space-y-2">
                    @foreach($checklist as $step)
                        <div class="flex items-center justify-between gap-3 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                            <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">{{ $step['label'] }}</span>
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full {{ $step['done'] ? 'bg-success-50 text-success-700 ring-1 ring-inset ring-success-100 dark:bg-success-500/10 dark:text-success-200 dark:ring-success-500/20' : 'bg-neutral-100 text-neutral-500 ring-1 ring-inset ring-neutral-200 dark:bg-neutral-900 dark:text-neutral-400 dark:ring-neutral-800' }}">
                                @if($step['done'])
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                                    </svg>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </x-widget>

            <x-widget title="Preview summary" :collapsible="false">
                <div class="space-y-3 text-sm">
                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400 dark:text-neutral-500">Title</p>
                        <p class="mt-2 font-semibold text-neutral-900 dark:text-neutral-50">{{ $internshipTitle !== '' ? $internshipTitle : 'Add a title to preview' }}</p>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400 dark:text-neutral-500">Location</p>
                            <p class="mt-2 font-semibold text-neutral-900 dark:text-neutral-50">{{ $location !== '' ? $location : '—' }}</p>
                        </div>
                        <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400 dark:text-neutral-500">Work mode</p>
                            <p class="mt-2 font-semibold text-neutral-900 dark:text-neutral-50">{{ $type !== '' ? $type : '—' }}</p>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-3 dark:border-neutral-800 dark:bg-neutral-900/60">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-neutral-400 dark:text-neutral-500">Skills tags</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @if(count($requiredSkills) === 0)
                                <span class="text-sm text-neutral-500 dark:text-neutral-400">Add at least one required skill.</span>
                            @else
                                @foreach(array_slice($requiredSkills, 0, 6) as $skill)
                                    <span class="rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-700 dark:bg-primary-500/10 dark:text-primary-200">{{ $skill }}</span>
                                @endforeach
                                @if(count($requiredSkills) > 6)
                                    <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-600 dark:bg-neutral-900 dark:text-neutral-400">+{{ count($requiredSkills) - 6 }}</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </x-widget>

            <x-widget title="Guidelines" :collapsible="false">
                <div class="space-y-3 text-sm leading-6 text-neutral-600 dark:text-neutral-300">
                    <p>Keep the internship title specific and include the stack (e.g., Laravel, UI Design, Data). Candidates respond better to clarity than generic titles.</p>
                    <p>Use the description to explain what the intern will learn, how they’ll be supervised, and what a successful internship looks like.</p>
                </div>
            </x-widget>
        </x-slot:aside>
    </x-dashboard.two-column>
</div>
