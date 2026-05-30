# Tasks
- [x] Task 1: Add persistence for saved searches and saved internships
  - [x] Create migrations + models for `saved_searches` and `saved_internships` (student-scoped)
  - [x] Add relationships on StudentProfile (or User) for saved searches/bookmarks

- [x] Task 2: Add demo seed data for internships and student profile
  - [x] Create a seeder that generates realistic internships (category/location/type/duration/tags)
  - [x] Ensure demo student user(s) have a StudentProfile to support applications

- [x] Task 3: Implement InternshipService filtering/sorting/pagination
  - [x] Replace the current stub `searchInternships($city)` with a filter payload API
  - [x] Implement query builder logic for keywords/category/location/type/duration/postedWithin
  - [x] Return a paginator result compatible with Livewire rendering

- [x] Task 4: Redesign Student InternshipSearch Livewire page UI to match reference
  - [x] Build the filter card layout (keywords + dropdowns + more filters + search button)
  - [x] Build results header (count + sort)
  - [x] Build result row/card UI (tags, bookmark, view details, apply now)
  - [x] Build right-rail panels (quick actions, recommended filters, profile completion)
  - [x] Ensure mobile-first responsiveness and no horizontal overflow

- [x] Task 5: Wire interactions (fully working)
  - [x] Live search + filter submit behavior (updates results)
  - [x] Sort + pagination (preserve filters)
  - [x] Save Search action (stores current filter payload)
  - [x] Bookmark toggle action (save/unsave internship)
  - [x] Apply Now action (creates Application; prevents duplicates; updates UI state)

- [x] Task 6: Verification
  - [x] Feature tests for student access + search filtering + apply/bookmark behavior
  - [x] Smoke test in browser: student can search/filter/sort/paginate/save/apply
  - [x] Run `php artisan test`

# Task Dependencies
- Task 3 depends on Tasks 1–2
- Task 4 depends on Task 3
- Task 5 depends on Task 4
- Task 6 depends on Task 5
