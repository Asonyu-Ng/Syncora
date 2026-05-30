# Syncora Student Internship Search Redesign Spec

## Why
The Student “Find Internships” screen needs a premium, modern SaaS UI and a fully working search + filtering workflow that matches the provided reference design while staying consistent with the Syncora design system.

## What Changes
- Redesign **Student-only** internship search page UI to match the screenshot (layout, cards, filters, right-side panels).
- Implement a working end-to-end flow for:
  - keyword search
  - filters (category, location, type, duration, posted-within + “more filters” expansion)
  - sort (newest first at minimum)
  - pagination
  - save search
  - save internship (bookmark)
  - apply now (creates an application)
- Ensure the page uses Syncora design tokens (primary/neutral palette, spacing, radius, shadows, focus rings).

## Impact
- Affected specs: create-syncora-design-system, redesign-syncora-dashboard-shell
- Affected code:
  - Student route: `/student/internships` (`student.internships.search`)
  - Livewire page: `App\Livewire\Student\InternshipSearch`
  - Blade view: `resources/views/livewire/student/internship-search.blade.php`
  - Services: `App\Services\InternshipService`
  - Models/migrations/seeders: `Internship`, `Application`, plus new “saved”/“saved search” persistence

## ADDED Requirements

### Requirement: Student Internship Search Page UI
The system SHALL render a Student-only “Find Internships” page that matches the reference layout.

#### Layout (desktop)
- Left: existing dashboard sidebar + topbar (shared shell)
- Main content:
  - Page title “Find Internships” + subtitle
  - Filter card with:
    - Keywords input
    - Category select
    - Location select
    - Type select
    - Duration select
    - Posted Within select
    - “More Filters” toggle (expands additional controls; see below)
    - Primary Search button
  - Results header row:
    - “N internships found”
    - Sort dropdown (default: Newest First)
  - Results list: internship result rows/cards with:
    - Company logo/initials block
    - Title + company name
    - Meta row (location, type, posted time)
    - Skill tags/chips (truncate with “+N”)
    - Bookmark icon button
    - “View Details” and “Apply Now” actions
- Right rail:
  - Quick Actions card (My Applications, Saved Internships, Application Tips)
  - Recommended Filters list (clickable chips)
  - “Complete Your Profile” card (progress bar; can be derived or stubbed)

#### Layout (mobile)
- Filters collapse to a stacked layout, with “More Filters” expanding inline.
- Right rail content moves below results or becomes collapsible sections (no horizontal overflow).

### Requirement: Working Search + Filters
The system SHALL apply filters and sorting to the internship results list.

#### Filters (minimum)
- keywords: matches internship title, company name, and optional tags/skills field
- category: matches internship category field
- location: matches city (and optionally region/country if present)
- type: matches internship type (e.g., on-site/remote/hybrid)
- duration: matches internship duration bucket (e.g., 1–3 months, 3–6 months)
- postedWithin: filters by created_at window (e.g., 24h, 7d, 30d)

#### Sorting (minimum)
- Newest First (default): `created_at desc`
- Oldest First: `created_at asc`

#### Pagination
- Results SHALL be paginated (default 10 per page) and preserve filters/sort in query state.

### Requirement: Save Search
The system SHALL allow a student to save the current search criteria.

#### Scenario: Save search
- **WHEN** a student clicks “Save Search”
- **THEN** the system stores the current filter payload for that student
- **AND** the UI confirms success

### Requirement: Save Internship (Bookmark)
The system SHALL allow a student to bookmark an internship from the results list.

#### Scenario: Toggle bookmark
- **WHEN** a student clicks the bookmark icon on a result
- **THEN** the internship is saved (or unsaved) for that student
- **AND** the icon state updates immediately

### Requirement: Apply Now
The system SHALL allow a student to apply to an internship from the results list.

#### Scenario: Apply now creates an application
- **WHEN** a student clicks “Apply Now”
- **THEN** an `applications` record is created for the student profile and internship
- **AND** duplicate applications are prevented (unique constraint)
- **AND** the UI reflects applied state (button disabled or “Applied”)

### Requirement: Seed/Demo Data Supports UI
The system SHALL include seed/demo data so the Student “Find Internships” screen can be viewed and interacted with locally without manual DB setup.

#### Scenario: Demo results visible
- **WHEN** the Demo seeders are run
- **THEN** the student user has a `student_profiles` record
- **AND** a realistic set of internships exist with categories/locations/types/tags

## MODIFIED Requirements

### Requirement: Student Internship Search Page Is Student-Only
The system SHALL restrict access to the Student “Find Internships” page to the student role via existing role middleware.

## REMOVED Requirements
N/A

## UI Style Rules (from Syncora Design System)
- Use token-based colors (`primary-*`, `neutral-*`, status colors); no ad-hoc hex.
- Use whitespace-heavy spacing (section gap 24px, card gap 16px).
- Use rounded modern cards and inputs (`rounded-2xl` for panels/cards; `rounded-xl` for controls).
- Use soft shadows (`shadow-card` or `shadow-soft`) and subtle borders (`border-neutral-200`).
- Maintain accessible focus rings (primary ring) and keyboard navigation.

