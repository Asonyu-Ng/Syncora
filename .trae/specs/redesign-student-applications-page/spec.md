# Syncora Student Applications Page Redesign Spec

## Why
The Student “My Applications” page needs to match the provided premium SaaS visual design and be fully functional with real application records: status tabs, counts, pagination, and actions.

## What Changes
- Redesign the **Student-only** Applications page UI to match the screenshot layout (tabs, table/list, right rail).
- Replace the current stub list with real `applications` data joined to `internships`.
- Implement working filters via status tabs, search, pagination, and counts.
- Implement actions: View Details, Withdraw, and Accepted “View Offer” placeholder.
- Ensure styling follows the Syncora design system tokens and the redesigned dashboard shell.

## Impact
- Affected specs: redesign-syncora-dashboard-shell, create-syncora-design-system
- Affected code:
  - Student route: `/student/applications` (`student.applications.index`)
  - Livewire page: `App\Livewire\Student\Applications`
  - Blade view: `resources/views/livewire/student/applications.blade.php`
  - Models: `Application`, `Internship`, `StudentProfile`
  - Seeders: ensure demo applications exist so the page is usable locally

## ADDED Requirements

### Requirement: Applications Page UI (Student-only)
The system SHALL render a Student “My Applications” page matching the reference layout.

#### Layout (desktop)
- Page header: “My Applications” + subtitle and a CTA button “Find Internships”
- Status tabs row (with counts):
  - All Applications
  - Pending
  - Under Review
  - Accepted
  - Rejected
  - Withdrawn
- Main list as a table-like card:
  - Columns: Internship, Company, Status, Applied On, Actions
  - Row shows company logo/initials, internship title, meta (type/location), company name/category, status badge + helper text, applied date
  - Actions: View Details, optional View Offer (accepted), kebab menu with Withdraw (if not terminal)
- Right rail:
  - Application Summary card with counts per status
  - Tips for Success card (static content is acceptable)
  - “Improve Your Chances” promo card (static content is acceptable)

#### Layout (mobile)
- Tabs become horizontally scrollable.
- The table becomes a stacked card list per application (no horizontal overflow).
- Right rail moves below the list.

### Requirement: Real Data + Filtering
The system SHALL load applications from the database for the authenticated student.

#### Data rules
- Applications are scoped to the student’s `student_profile_id`.
- The list includes internship details via relationship.

#### Filtering
- **WHEN** a status tab is selected
- **THEN** the list is filtered by `applications.status`.
- All Applications shows all statuses.

#### Search
- **WHEN** the user enters a search query
- **THEN** it filters by internship title and company name.

#### Pagination
- The list SHALL be paginated (default 10 per page).
- Filter + search state MUST be preserved across pagination.

### Requirement: Accurate Counts
The system SHALL compute counts per status for:
- Tabs (e.g., “Pending (4)”)
- Application Summary card

### Requirement: Actions
The system SHALL provide the following actions:

#### View Details
- **WHEN** a user clicks “View Details”
- **THEN** navigate to the internship details page for that application’s internship.

#### Withdraw
- **WHEN** a user chooses Withdraw
- **THEN** set the application status to `withdrawn`
- **AND** update counts and list immediately
- **AND** prevent withdrawing if the application is already rejected/withdrawn.

#### View Offer (placeholder)
- **WHEN** an application is `accepted`
- **THEN** display a “View Offer” button that can route to a placeholder (or open a modal placeholder).

### Requirement: Seed/Demo Data Supports UI
The system SHALL seed demo applications for the demo student so the page shows realistic data locally.

## MODIFIED Requirements

### Requirement: Student Applications Page Is Student-Only
The system SHALL restrict access to the applications page to authenticated users with role `student` via existing middleware.

## REMOVED Requirements
N/A

## UI Style Rules
- Use Syncora tokens (`primary-*`, `neutral-*`, status colors) and spacing rules (section gap 24px, card gap 16px).
- Status badges use subtle tinted backgrounds with matching text (e.g., warning for Pending, info for Under Review, success for Accepted, danger for Rejected, neutral for Withdrawn).
- Buttons match design system sizing and radius (`h-11`, `rounded-xl`).

