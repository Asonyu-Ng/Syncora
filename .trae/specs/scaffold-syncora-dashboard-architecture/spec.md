# Syncora Complete Dashboard Architecture Spec

## Why
Syncora needs a production-grade, multi-role dashboard foundation that supports internship workflows (management, tracking, verification, reporting) while keeping business logic out of Livewire views and enabling long-term scalability.

## What Changes
- Create a complete, role-based dashboard shell (sidebar + topbar + content) with reusable Livewire/Blade components.
- Add feature-based, role-based page scaffolding for Student, Supervisor, Company, and Admin dashboards.
- Establish a modular service layer for core workflows (internships, tasks, logbooks, evaluations, analytics, notifications, reports).
- Scaffold core domain models and relationships for internship management.
- Add middleware + policies + route groups to enforce role-based access and future permissions.
- Add reusable UI building blocks (widgets, tables, dropdowns, empty/loading states) prioritizing functionality over styling.

## Impact
- Affected specs: role-based dashboards | navigation | routing | authorization | workflow services | domain models
- Affected code: routes/web.php, app/Http/Middleware, app/Policies, app/Models, app/Livewire, resources/views

## ADDED Requirements

### Requirement: Role-Based Dashboard Shell
The system SHALL provide a shared dashboard shell layout used by all role dashboards.

#### Scenario: Dashboard shell renders
- **WHEN** an authenticated user visits any dashboard route
- **THEN** the page renders a sidebar, topbar, and main content area
- **AND** the sidebar contains role-appropriate navigation entries
- **AND** the topbar contains search, breadcrumbs, notifications dropdown, and profile dropdown
- **AND** the mobile sidebar is accessible from a hamburger button

### Requirement: Role-Based Routing & Access
The system SHALL protect all dashboard routes with authentication and role authorization.

#### Scenario: Correct dashboard redirect
- **WHEN** a user visits `/dashboard`
- **THEN** the user is redirected to their role dashboard route

#### Scenario: Cross-role access denied
- **WHEN** a Student tries to access `/admin/*`
- **THEN** the request is denied and the user is redirected to the Student dashboard (or receives a 403 if configured)

### Requirement: Feature-Based Page Scaffolding
The system SHALL scaffold functional pages for each role as Livewire components following a feature-based organization.

#### Scenario: Student functional pages exist
- **WHEN** a developer navigates the codebase
- **THEN** the Student pages exist under `app/Livewire/Student/*`
- **AND** each page has a route, a component class, and a view

#### Scenario: Supervisor functional pages exist
- **WHEN** a developer navigates the codebase
- **THEN** the Supervisor pages exist under `app/Livewire/Supervisor/*`
- **AND** each page has a route, a component class, and a view

#### Scenario: Company functional pages exist
- **WHEN** a developer navigates the codebase
- **THEN** the Company pages exist under `app/Livewire/Company/*`
- **AND** each page has a route, a component class, and a view

#### Scenario: Admin functional pages exist
- **WHEN** a developer navigates the codebase
- **THEN** the Admin pages exist under `app/Livewire/Admin/*`
- **AND** each page has a route, a component class, and a view

### Requirement: Reusable Shared Components
The system SHALL provide reusable components to build dashboards consistently across roles.

#### Scenario: Shared components are reusable
- **WHEN** building any role dashboard page
- **THEN** developers can use shared components for stats cards, tables, dropdowns, modals, pagination, empty states, loading states, and sidebar/header

### Requirement: Service Layer for Workflows
The system SHALL provide service classes for core workflows and keep workflow logic out of Livewire components.

#### Scenario: Workflow logic lives in services
- **WHEN** a Livewire component performs an action (apply to internship, assign task, approve logbook, generate report)
- **THEN** the component delegates business logic to a service class

### Requirement: Domain Models & Relationships
The system SHALL provide domain models and relationships required for internship management and verification.

#### Scenario: Internship application data model
- **WHEN** a student applies to an internship
- **THEN** an Application record links the student user (or StudentProfile) to an Internship
- **AND** the status is tracked for review by Company/Supervisor

#### Scenario: Logbook verification data model
- **WHEN** a student submits a logbook entry
- **THEN** a Logbook record links to the student and the internship
- **AND** a Supervisor can approve/reject the entry

## MODIFIED Requirements

### Requirement: Existing Dashboard System Spec Alignment
This change SHALL extend the existing dashboard foundation (layout, routing, middleware, role dashboards) and expand it with full role page scaffolding, services, models, and authorization structure.

## REMOVED Requirements
N/A

