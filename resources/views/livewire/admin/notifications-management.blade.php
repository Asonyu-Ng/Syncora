<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Notifications Management</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Send announcement stub</p>
    </div>

    <x-widget title="Send Announcement (stub)" :collapsible="true">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-1">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Audience</label>
                <select
                    wire:model="audience"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="all">All</option>
                    <option value="students">Students</option>
                    <option value="supervisors">Supervisors</option>
                    <option value="companies">Companies</option>
                </select>
            </div>

            <div class="md:col-span-1">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Subject</label>
                <input
                    type="text"
                    wire:model="subject"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Announcement subject"
                />
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Message</label>
                <textarea
                    rows="4"
                    wire:model="message"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Message body (stub)"
                ></textarea>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button
                    type="button"
                    wire:click="send"
                    class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors"
                >
                    Send
                </button>
            </div>
        </div>
    </x-widget>

    <x-widget title="Recently Sent (stub)" :collapsible="true">
        <x-dashboard.table
            :columns="[
                ['label' => 'Subject', 'key' => 'subject'],
                ['label' => 'Audience', 'key' => 'audience'],
                ['label' => 'Sent', 'key' => 'time'],
            ]"
            :rows="$sent"
            emptyMessage="No announcements yet."
        />
    </x-widget>
</div>
