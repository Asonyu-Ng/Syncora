# Tasks
- [x] Task 1: Baseline existing dashboard foundation
  - [x] Confirm current dashboard routes and role middleware behavior
  - [x] Confirm existing layout/sidebar/topbar components and identify gaps vs. this spec
  - [x] Decide whether unauthorized cross-role access returns 403 or redirects to role dashboard (pick one behavior and apply consistently)

- [x] Task 2: Create unified dashboard shell layout system
  - [x] Create/standardize a shared dashboard layout used by all role pages (sidebar + topbar + main content)
  - [x] Add breadcrumb slot and page title support
  - [x] Add mobile sidebar toggle behavior
  - [x] Add dark-mode-ready structure (classes/attributes; no heavy theming required)

- [x] Task 3: Build shared reusable dashboard components (functional-first)
  - [x] Notifications dropdown component (list, mark read stub, “view all” stub)
  - [x] Profile dropdown component (profile/settings/logout)
  - [x] Reusable stats card widget component (supports loading + empty values)
  - [x] Reusable table component (columns, rows, pagination, empty/loading states)
  - [x] Reusable search/filter component (query + basic filters, emits events)
  - [x] Reusable modal component (confirm + slot content)

- [x] Task 4: Scaffold Student module pages + routes
  - [x] Dashboard (widgets + activity feed stubs)
  - [x] Internship Search (search by city stub)
  - [x] Internship Details (read-only stub)
  - [x] Applications (list stub)
  - [x] Task Board (list/kanban stub)
  - [x] Logbook Submission (create/list stub)
  - [x] AI Report Generator (placeholder action + service integration stub)
  - [x] Profile Management + Settings (reuse existing profile where applicable)

- [x] Task 5: Scaffold Supervisor module pages + routes
  - [x] Dashboard (progress overview stubs)
  - [x] Students Management (list stub)
  - [x] Task Assignment (create/list stub)
  - [x] Logbook Approval (approve/reject stub)
  - [x] Student Evaluation (create/list stub)
  - [x] Internship Monitoring (table stub)
  - [x] Reports Review (list stub)
  - [x] Calendar (placeholder page)

- [x] Task 6: Scaffold Company module pages + routes
  - [x] Dashboard (intern progress stubs)
  - [x] Post Internship (create stub)
  - [x] Internship Management (list/edit stub)
  - [x] Applicants Management (list + accept/reject stub)
  - [x] Active Interns (list stub)
  - [x] Task Assignment (create/list stub)
  - [x] Intern Evaluation (create/list stub)
  - [x] Reports (list stub)
  - [x] Company Profile + Settings (placeholder or reuse profile)

- [x] Task 7: Scaffold Admin module pages + routes (admin-only)
  - [x] Dashboard (system analytics stubs)
  - [x] Users Management (list/create/edit stubs)
  - [x] Universities Management (list/create/edit stubs)
  - [x] Companies Management (list/create/edit stubs)
  - [x] Internships Monitoring (table stub)
  - [x] Analytics Dashboard (placeholder widgets)
  - [x] Reports Management (list stub)
  - [x] Notifications Management (send announcement stub)
  - [x] System Settings (placeholder)
  - [x] Activity Logs (table stub)

- [x] Task 8: Add service layer scaffolding (no heavy business logic)
  - [x] Create services: InternshipService, TaskService, LogbookService, EvaluationService, AnalyticsService, NotificationService, ReportService
  - [x] Define method signatures for key workflows (apply, assign, approve/reject, generate, aggregate)
  - [x] Wire Livewire actions to call services (stub implementations returning placeholders)

- [x] Task 9: Scaffold domain models + relationships (migrations + models)
  - [x] Add profile models: StudentProfile, SupervisorProfile, CompanyProfile
  - [x] Add domain models: Internship, Application, Task, Logbook, Evaluation, Notification, Report
  - [x] Define core relationships (user↔profiles, internship↔applications/tasks/logbooks, evaluation links)
  - [x] Ensure seeded/demo data supports viewing dashboards without errors

- [x] Task 10: Add authorization structure (middleware + policies)
  - [x] Role middleware for route protection (role groups)
  - [x] Policies for Internship, Application, Task, Logbook, Report, Evaluation (scaffold methods)
  - [x] Ensure privileged actions (admin management pages) are admin-only

- [x] Task 11: Integrate routes (role-based groups + named routes)
  - [x] Create route groups per role: /student/*, /supervisor/*, /company/*, /admin/*
  - [x] Add /dashboard redirect by role
  - [x] Ensure routes map to page components consistently

- [x] Task 12: Verification
  - [x] Feature tests: role-based access (can/cannot access dashboards)
  - [x] Smoke test: login as each seeded role and visit each page route
  - [x] Ensure no page crashes due to missing services/models

- [x] Task 13: Wire profile dropdown “Settings” entry to role settings routes

# Task Dependencies
- Task 2 depends on Task 1
- Tasks 4–7 depend on Task 2 and Task 3
- Task 8 depends on Tasks 4–7 (wiring actions)
- Task 9 depends on Task 8 (service signatures inform models)
- Tasks 10–11 depend on Tasks 4–9
- Task 12 depends on Tasks 10–11
