# Syncora Dashboard Shell Redesign Spec

## Why
The current dashboard shell (sidebar + topbar + content scaffolding) does not match the desired premium, minimal SaaS look. A unified redesign is needed so every role dashboard feels consistent, modern, and lightweight.

## What Changes
- Redesign the shared dashboard shell to match the provided Student dashboard reference style.
- Apply the same shell to Student, Supervisor, Company, and Admin dashboards (no role-specific shell styling).
- Standardize sidebar navigation visuals (light sidebar, pill active state, consistent icons, spacing).
- Standardize topbar visuals (search, notification badge, user identity block).
- Ensure the content container and spacing rules are consistent and responsive (mobile-first).

## Impact
- Affected specs: create-syncora-design-system (tokens and component rules), syncora-dashboard-system (shared layout + components)
- Affected code (implementation targets):
  - `resources/views/layouts/dashboard.blade.php`
  - `resources/views/components/dashboard/sidebar.blade.php`
  - `resources/views/components/dashboard/navbar.blade.php`
  - Role dashboard pages under `resources/views/livewire/dashboard/*` and module dashboards under `resources/views/livewire/*/dashboard.blade.php` (for alignment only)

## ADDED Requirements

### Requirement: Unified Dashboard Shell
The system SHALL render all role dashboards inside the same redesigned dashboard shell.

#### Scenario: Role dashboards share shell
- **WHEN** a user visits any role dashboard (`/student/dashboard`, `/supervisor/dashboard`, `/company/dashboard`, `/admin/dashboard`)
- **THEN** the sidebar and topbar match the same layout, spacing, and visual style
- **AND** role differences are limited to navigation items and page content

### Requirement: Sidebar Redesign (Light + Minimal)
The system SHALL implement a light sidebar consistent with premium SaaS UI patterns.

#### Sidebar visuals
- Background: uses the Background token (`#F8FAFC`) with a subtle surface panel
- Width: 260px desktop, collapsible on mobile
- Active item: pill style with primary indigo background and white text
- Hover item: subtle neutral surface hover
- Icon + label alignment: consistent spacing and baseline

#### Scenario: Sidebar interaction
- **WHEN** the viewport is mobile (< 640px)
- **THEN** the sidebar is hidden by default and toggled via the topbar hamburger
- **AND** a backdrop closes the sidebar on click

### Requirement: Topbar Redesign (Search + Notifications + Identity)
The system SHALL implement a topbar consistent with the reference design.

#### Topbar layout
- Height: 72px
- Left: breadcrumbs (or page title on small screens)
- Center/right: search input (responsive width)
- Right: notifications button with badge + user identity block (avatar, name, role)

#### Scenario: Topbar responsiveness
- **WHEN** the viewport is mobile (< 640px)
- **THEN** breadcrumbs collapse to page title
- **AND** search shrinks or moves to a second row if needed without overflow

### Requirement: Content Container & Spacing
The system SHALL standardize dashboard content spacing so the page never shows unintended gutters.

#### Container rules
- Default content padding: 24px desktop, 16px tablet, 12px mobile
- Section gaps: 24px
- Card gaps: 16px
- Content width: fluid with a max width container (e.g., `max-w-7xl`) and centered

#### Scenario: No blank gutter beside sidebar
- **WHEN** the sidebar is visible on desktop
- **THEN** the main content begins immediately adjacent to the sidebar (no empty strip)

## MODIFIED Requirements

### Requirement: Dashboard Shell Must Use Design Tokens
The dashboard shell SHALL use the design tokens defined in the design system for colors, spacing, radius, and shadows.

## REMOVED Requirements
N/A

