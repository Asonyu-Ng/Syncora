# Supervisor Dashboard Screens Spec

## Why
Supervisors need dedicated, data-backed workflows for logbook review, monitoring student engagement, and generating/reviewing reports. The current pages are stub tables and do not reflect the provided UI visuals or real database records.

## What Changes
- Build three supervisor pages to match the provided visuals and use real database data:
  - Logbooks (logbook review/approval)
  - Monitoring (monitor students/internships)
  - Reports (report generation/review hub)
- Add functional filters, tabs, and pagination powered by Livewire.
- Add “Export” actions that queue a background job and provide user feedback.
- Keep the existing dashboard shell behavior and existing color tokens (no palette changes).

## Impact
- Affected specs: supervisor workflow, dashboard UI, reporting/exporting, data integrity
- Affected code:
  - Livewire: `app/Livewire/Supervisor/LogbookApproval.php`, `InternshipMonitoring.php`, `ReportsReview.php`
  - Views: `resources/views/livewire/supervisor/logbook-approval.blade.php`, `internship-monitoring.blade.php`, `reports-review.blade.php`
  - Routes: `routes/supervisor.php` (no route changes expected)
  - Models/tables already present: `logbooks`, `reports`, `internships`, `tasks`, `evaluations`, `student_profiles`, `supervisor_profiles`
  - New: queued export jobs and storage output for exports

## ADDED Requirements

### Requirement: Supervisor Logbooks Screen (DB-backed)
The system SHALL render a supervisor Logbooks screen that matches the provided “Logbooks” visual layout and is backed by the `logbooks` table.

#### Scenario: View logbooks by tab
- **WHEN** the supervisor opens `/supervisor/logbooks`
- **THEN** the system shows tabs:
  - Pending Review (submitted and awaiting action)
  - Reviewed (approved/returned)
  - All Logbooks
- **AND** switching tabs filters the table results.

#### Scenario: Filter and search logbooks
- **WHEN** the supervisor uses search (intern name or title/content keywords)
- **THEN** the table results update accordingly.
- **WHEN** the supervisor selects filters (internship, status, week/date range)
- **THEN** the table results update accordingly.

#### Scenario: Approve / return logbook
- **WHEN** the supervisor approves a submitted logbook entry
- **THEN** `logbooks.status` becomes `approved`
- **AND** `logbooks.approved_by_user_id` is set to the current user
- **AND** `logbooks.approved_at` is set
- **AND** the row moves out of “Pending Review”.
- **WHEN** the supervisor returns a submitted logbook entry
- **THEN** `logbooks.status` becomes `returned`
- **AND** approval fields are cleared.

#### Scenario: Logbooks summary panel
- **WHEN** the page loads on desktop
- **THEN** the right-side panel shows:
  - Logbook Summary counts for the selected period (This Week selector)
  - Review Statistics (reviewed vs in-review vs pending)
  - Quick Actions shortcuts
- **AND** on smaller screens the panel collapses below the table.

#### Scenario: Export logbooks
- **WHEN** the supervisor clicks Export
- **THEN** the system queues an export job using the active filters
- **AND** the UI confirms the export request was queued.

### Requirement: Supervisor Monitoring Screen (DB-backed)
The system SHALL render a supervisor Monitoring screen that matches the provided “Monitor Students” visual layout and is backed by `internships`, `logbooks`, and `tasks`.

#### Scenario: View monitored students
- **WHEN** the supervisor opens `/supervisor/monitoring`
- **THEN** a table lists students under the supervisor’s internships, including:
  - Student identity
  - Internship and company
  - Status (Active / Inactive 7 days / Not Active 15 days)
  - Last Active (relative time)
  - Activity Summary (recent activity)
  - Logbook progress and Tasks completion indicators

#### Scenario: Monitoring status calculation
- **WHEN** the page computes engagement status
- **THEN** it SHALL derive “last active” from the most recent activity timestamp across:
  - latest submitted/updated logbook entry_date
  - latest task update timestamp
- **AND** “Active” is last activity within 7 days
- **AND** “Inactive (7+ days)” is last activity within 8–15 days
- **AND** “Not Active (15+ days)” is last activity older than 15 days.

#### Scenario: Monitoring summary cards
- **WHEN** the page loads
- **THEN** the header cards show counts for:
  - Active Students
  - Inactive (7+ days)
  - Not Active (15+ days)
  - Logbooks This Week
  - Tasks Completed This Week

#### Scenario: Export monitoring report
- **WHEN** the supervisor clicks Export Report
- **THEN** the system queues an export job for the current monitoring dataset and filters
- **AND** the UI confirms the export request was queued.

### Requirement: Supervisor Reports Screen (DB-backed)
The system SHALL render a supervisor Reports screen that matches the provided “Reports” visual layout and uses both persisted `reports` and available report definitions.

#### Scenario: Filter reports
- **WHEN** the supervisor applies date range and dropdown filters (internships, companies, supervisors)
- **THEN** the summary cards, charts, and report lists update accordingly.

#### Scenario: Report tabs
- **WHEN** the supervisor switches between:
  - Standard Reports
  - Custom Reports
  - Saved Reports
- **THEN** the main list area changes content while keeping filters and right panel consistent.

#### Scenario: Report summaries and lists
- **WHEN** the page loads
- **THEN** it shows:
  - Summary metric cards (total interns, active, inactive, tasks completed, avg evaluation score)
  - A main reports list (definitions and/or generated reports, depending on tab)
  - A right-side panel with Report Summary, Popular Reports, and Recent Reports

#### Scenario: Export custom report (queued)
- **WHEN** the supervisor clicks “Export Custom Report”
- **THEN** the system queues a report export job
- **AND** the UI confirms the export request was queued.

### Requirement: Export Jobs
The system SHALL implement export actions as queued jobs.

#### Scenario: Export job output
- **WHEN** an export job runs
- **THEN** it generates an output file (CSV or JSON) into application storage
- **AND** it uses a stable naming convention including date/time and supervisor id
- **AND** it does not block the web request.

## MODIFIED Requirements

### Requirement: Replace Stub Supervisor Pages
The system SHALL replace the stub arrays and placeholder tables on supervisor Logbooks/Monitoring/Reports pages with DB-backed queries and UI matching the provided visuals.

## REMOVED Requirements
None

