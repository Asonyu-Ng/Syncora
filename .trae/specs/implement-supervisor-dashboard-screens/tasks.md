# Tasks

- [x] Task 1: Confirm data model and relationships for supervisor pages
  - [x] Verify the supervisor-to-internship relationship and how supervised students are derived
  - [x] Verify the `logbooks` statuses used across the app and map them to page tabs
  - [x] Verify `reports` statuses/types used by student report generation and map them to supervisor views
  - [x] Add missing indexes needed for filtering (only if required by queries)

- [x] Task 2: Implement Supervisor Logbooks screen (visual + DB + interactions)
  - [x] Replace stub data in `LogbookApproval` with DB-backed query and pagination
  - [x] Implement tabs: Pending Review / Reviewed / All Logbooks
  - [x] Implement search + dropdown filters (internship, status, week/date range)
  - [x] Implement approve/return actions that update `logbooks` status and approval metadata
  - [x] Build right summary panel (counts, donut/chart placeholder, quick actions) with responsive collapse on mobile
  - [x] Add Export button to queue an export job for the current filtered dataset

- [x] Task 3: Implement Supervisor Monitoring screen (visual + DB + interactions)
  - [x] Replace stub data in `InternshipMonitoring` with DB-backed query and pagination
  - [x] Implement status calculation (Active / Inactive 7 days / Not Active 15 days) based on last activity
  - [x] Implement search + dropdown filters (internships, companies, status)
  - [x] Build header summary cards and progress indicators (logbook progress, tasks completion)
  - [x] Add Export Report button to queue an export job for the current filtered dataset

- [x] Task 4: Implement Supervisor Reports screen (visual + DB + interactions)
  - [x] Replace stub data in `ReportsReview` with DB-backed data and report definitions
  - [x] Implement filters (date range, internships, companies, supervisors)
  - [x] Implement tabs: Standard / Custom / Saved
  - [x] Build summary metric cards and right-side report summary panel (donut/chart placeholder, popular + recent lists)
  - [x] Add Export Custom Report button to queue a report export job using current filters and selected report

- [x] Task 5: Implement queued export jobs and storage output
  - [x] Create export job classes for logbooks, monitoring, and reports exports
  - [x] Ensure jobs write output files into storage with a stable naming convention
  - [x] Add Livewire feedback (toast/flash) when exports are queued

- [x] Task 6: Add tests for supervisor screens and exports
  - [x] Add route access tests (auth + role middleware)
  - [x] Add Logbooks action tests (approve/return updates DB correctly)
  - [x] Add export dispatch tests (queue job is dispatched with expected payload)

- [x] Task 7: Verification and UI QA
  - [x] Verify desktop layout matches the provided visuals (including right summary panel)
  - [x] Verify mobile layout collapses summary panel below content without overlap
  - [x] Verify filters, tabs, and pagination work on all three screens
  - [x] Verify no new styling breaks on other dashboards/pages

# Task Dependencies

- Task 2 depends on Task 1
- Task 3 depends on Task 1
- Task 4 depends on Task 1
- Task 5 depends on Tasks 2, 3, 4
- Task 6 depends on Tasks 2, 3, 4, 5
- Task 7 depends on Tasks 2, 3, 4, 5, 6
