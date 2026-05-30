# Tasks
- [x] Task 1: Ensure demo applications exist for student users
  - [x] Add a seeder that creates applications for the demo student profile across multiple statuses
  - [x] Ensure internships exist (reuse existing DemoInternshipsSeeder)

- [x] Task 2: Implement real data query + counts for Applications page
  - [x] Update `App\Livewire\Student\Applications` to load student-scoped applications
  - [x] Add status tab filtering, search query, and pagination (preserve state)
  - [x] Compute counts per status for tabs + summary card

- [x] Task 3: Redesign Applications page UI to match reference
  - [x] Build header (title/subtitle + “Find Internships” CTA)
  - [x] Build status tabs row with counts (scrollable on mobile)
  - [x] Build table-like list with responsive fallback (stacked cards on mobile)
  - [x] Build actions area (View Details, View Offer for accepted, dropdown menu)
  - [x] Build right rail panels (summary + tips + promo)

- [x] Task 4: Wire actions
  - [x] View Details navigates to internship details route
  - [x] Withdraw updates status to `withdrawn` and refreshes counts/list
  - [x] Accepted “View Offer” placeholder (modal or route)

- [x] Task 5: Verification
  - [x] Feature tests for student-only access + filtering + withdraw behavior
  - [x] Smoke test in browser: tabs/search/pagination/actions work
  - [x] Run `php artisan test`

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 2
- Task 4 depends on Task 3
- Task 5 depends on Task 4
