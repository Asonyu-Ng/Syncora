<div class="space-y-6">
    @if (session('message'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-[28px] border border-neutral-200 bg-gradient-to-r from-white via-neutral-50 to-primary-50/40">
        <div class="flex flex-col gap-5 px-6 py-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <div class="flex items-start gap-4">
                <a
                    href="{{ route('company.internships.index') }}"
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-600 transition hover:bg-neutral-50"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <div class="space-y-2">
                    <h1 class="text-3xl font-bold tracking-tight text-neutral-900">Post New Internship</h1>
                    <p class="max-w-2xl text-sm text-neutral-500">Share an internship opportunity in Cameroon and attract the right student talent for your team.</p>
                </div>
            </div>

            <div class="hidden lg:flex lg:items-center lg:gap-4">
                <div class="grid h-20 w-20 place-items-center rounded-3xl bg-white/80 shadow-soft ring-1 ring-primary-100">
                    <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7V6a2 2 0 00-2-2h-3V3h-6v1H6a2 2 0 00-2 2v1m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0H4m5 5h6m-6 4h3" />
                    </svg>
                </div>
                <div class="space-y-3">
                    <div class="h-12 w-32 rounded-[22px] bg-white/70 ring-1 ring-primary-100"></div>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit="submit" class="rounded-[28px] border border-neutral-200 bg-white shadow-soft">
        <div class="space-y-10 p-6 lg:p-8">
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-neutral-200 pb-4">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-primary-50 text-primary-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10l3 3v13a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1h2z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-base font-semibold text-neutral-900">Internship Information</h2>
                        <p class="text-sm text-neutral-500">Capture the role details, work mode, and internship duration.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <div>
                        <label for="internshipTitle" class="text-sm font-semibold text-neutral-700">Internship Title <span class="text-red-500">*</span></label>
                        <input id="internshipTitle" type="text" wire:model.defer="internshipTitle" placeholder="e.g. Frontend Developer Intern" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15" />
                        @error('internshipTitle') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="department" class="text-sm font-semibold text-neutral-700">Department / Field <span class="text-red-500">*</span></label>
                        <input id="department" type="text" wire:model.defer="department" placeholder="e.g. Information Technology" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15" />
                        @error('department') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="location" class="text-sm font-semibold text-neutral-700">Location <span class="text-red-500">*</span></label>
                        <input id="location" type="text" wire:model.defer="location" placeholder="e.g. Douala, Cameroon / Remote" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15" />
                        @error('location') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="type" class="text-sm font-semibold text-neutral-700">Type <span class="text-red-500">*</span></label>
                            <select id="type" wire:model.defer="type" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15">
                                @foreach ($typeOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('type') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="durationInMonths" class="text-sm font-semibold text-neutral-700">Duration <span class="text-red-500">*</span></label>
                                <span class="text-xs font-semibold text-primary-700">{{ $durationInMonths }} {{ $durationInMonths === 1 ? 'month' : 'months' }}</span>
                            </div>
                            <div class="mt-4 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                                <input id="durationInMonths" type="range" min="1" max="5" step="1" wire:model.live="durationInMonths" class="h-2 w-full cursor-pointer appearance-none rounded-full bg-primary-100 accent-primary-600" />
                                <div class="mt-2 flex justify-between text-[11px] font-medium text-neutral-400">
                                    <span>1 month</span>
                                    <span>5 months</span>
                                </div>
                            </div>
                            @error('durationInMonths') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="flex items-center justify-between">
                            <label for="description" class="text-sm font-semibold text-neutral-700">Description <span class="text-red-500">*</span></label>
                            <span class="text-xs text-neutral-400">{{ mb_strlen($description) }}/1000</span>
                        </div>
                        <textarea id="description" rows="6" wire:model.defer="description" placeholder="Describe the role, responsibilities, and what the intern will learn in your Yaounde, Douala, or remote team." class="mt-2 w-full rounded-[24px] border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15"></textarea>
                        @error('description') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-neutral-200 pb-4">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-primary-50 text-primary-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-base font-semibold text-neutral-900">Requirements</h2>
                        <p class="text-sm text-neutral-500">Define the skills, education expectations, and any extra notes for applicants.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <div>
                        <label for="skillInput" class="text-sm font-semibold text-neutral-700">Required Skills <span class="text-red-500">*</span></label>
                        <div class="mt-2 rounded-[24px] border border-neutral-200 bg-white px-4 py-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($requiredSkills as $index => $skill)
                                    <span class="inline-flex items-center gap-2 rounded-full bg-primary-50 px-3 py-1.5 text-xs font-semibold text-primary-700">
                                        {{ $skill }}
                                        <button type="button" wire:click="removeSkill({{ $index }})" class="text-primary-500 transition hover:text-primary-700">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach
                            </div>

                            <div class="mt-3 flex gap-3">
                                <input id="skillInput" type="text" wire:model.defer="skillInput" wire:keydown.enter.prevent="addSkill" placeholder="Add skills like PHP, Laravel, UI Design" class="h-11 flex-1 rounded-2xl border border-neutral-200 bg-neutral-50 px-4 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15" />
                                <button type="button" wire:click="addSkill" class="inline-flex h-11 items-center justify-center rounded-2xl border border-neutral-200 bg-white px-4 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
                                    Add
                                </button>
                            </div>

                            <p class="mt-3 text-xs text-neutral-400">Type a skill and press Enter to add it as a tag.</p>
                        </div>
                        @error('requiredSkills') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                        @error('requiredSkills.*') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="educationLevel" class="text-sm font-semibold text-neutral-700">Education Level <span class="text-red-500">*</span></label>
                        <select id="educationLevel" wire:model.defer="educationLevel" class="mt-2 h-12 w-full rounded-2xl border border-neutral-200 bg-white px-4 text-sm text-neutral-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15">
                            <option value="">Select education level</option>
                            @foreach ($educationLevelOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('educationLevel') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="otherRequirements" class="text-sm font-semibold text-neutral-700">Other Requirements</label>
                            <span class="text-xs text-neutral-400">{{ mb_strlen($otherRequirements) }}/500</span>
                        </div>
                        <textarea id="otherRequirements" rows="4" wire:model.defer="otherRequirements" placeholder="Any other requirements for applicants in Bamenda, Buea, or remote placements?" class="mt-2 w-full rounded-[24px] border border-neutral-200 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15"></textarea>
                        @error('otherRequirements') <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-semibold text-neutral-700">Attach Files <span class="font-normal text-neutral-400">(Optional)</span></label>
                            <span class="rounded-full border border-neutral-200 bg-white px-2.5 py-1 text-[11px] font-semibold text-neutral-500">Coming soon</span>
                        </div>
                        <div class="pointer-events-none mt-2 flex min-h-[168px] items-center justify-center rounded-[24px] border border-dashed border-neutral-200 bg-neutral-50 px-6 py-8 text-center opacity-80">
                            <div class="space-y-3">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-primary-600 shadow-soft">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm font-semibold text-neutral-700">Attachments will be available soon</p>
                                    <p class="text-xs text-neutral-400">PDF, DOC, DOCX</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="flex flex-col gap-3 border-t border-neutral-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between lg:px-8">
            <button type="button" wire:click="cancel" class="inline-flex h-11 items-center justify-center rounded-2xl border border-neutral-200 bg-white px-5 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50">
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
</div>
