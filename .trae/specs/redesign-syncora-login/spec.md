# Syncora Login UX/UI Redesign Spec (Laravel 13 + Livewire)

## Why
Syncora’s current auth experience needs a modern SaaS login page and a clearer, role-agnostic login flow while still supporting role-based dashboards and student matricule login.

## What Changes
- Replace the Breeze Blade login page with a production-quality Livewire login experience using a split-screen SaaS layout.
- Support authentication by **email OR student matricule** (matricule allowed only for Student users).
- Remove any role visibility or role selection from the login UI.
- Preserve and enforce automatic role-based redirect after authentication (via `/dashboard` → role dashboards).
- Add a dedicated auth layout for branding/marketing left panel + right auth card.
- Improve UX: loading states, validation states, password visibility toggle, accessible form controls.
- Keep existing security controls: CSRF, password hashing, rate limiting, validation.
- Registration (not login) is the only place roles can be chosen/assigned.

## Impact
- Affected specs: authentication UX, credential handling, student login identifier, role-based redirect flow.
- Affected code:
  - Livewire: `app/Livewire/Auth/Login.php`, `resources/views/livewire/auth/login.blade.php`
  - Layouts: `resources/views/layouts/auth.blade.php` (new) or equivalent auth layout
  - Auth routes/view wiring: `routes/auth.php` and/or `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
  - Credential validation/authentication: `app/Http/Requests/Auth/LoginRequest.php` (or Livewire-only equivalent)
  - User data: users table (add `matricule` field), registration flow (role assignment and matricule capture)

## ADDED Requirements

### Requirement: Split-Screen Login Page (Livewire)
The system SHALL provide a responsive split-screen login page.

#### Scenario: Desktop layout
- **WHEN** a user opens `/login` on desktop
- **THEN** the page shows a left branding/marketing panel and a right authentication card

#### Scenario: Mobile layout
- **WHEN** a user opens `/login` on mobile
- **THEN** the page prioritizes the authentication card and collapses/reflows the left panel content appropriately

### Requirement: No Role Display on Login
The system SHALL NOT display user roles or role selection controls anywhere on the login page.

#### Scenario: Login UI review
- **WHEN** a user views the login page
- **THEN** no role selector, role label, or “login as” options are visible

### Requirement: Email or Matricule Login
The system SHALL accept either:
- Email (all roles)
- Matricule (Students only)

#### Scenario: Email login success
- **WHEN** a user submits a valid email + password
- **THEN** the system authenticates the user and redirects to the correct dashboard based on role

#### Scenario: Matricule login success (student)
- **WHEN** a student submits a valid matricule + password
- **THEN** the system authenticates the user and redirects to `/student/dashboard`

#### Scenario: Matricule login blocked for non-students
- **WHEN** a non-student submits a matricule identifier
- **THEN** the system rejects the attempt with a generic authentication error

### Requirement: Automatic Role-Based Redirect
The system SHALL automatically redirect an authenticated user to the correct dashboard route:
- `student` → `/student/dashboard`
- `supervisor` → `/supervisor/dashboard`
- `company` → `/company/dashboard`
- `admin` → `/admin/dashboard`

#### Scenario: Redirect after login
- **WHEN** authentication succeeds
- **THEN** the user is redirected to `/dashboard` and then to the role dashboard without any role prompts

### Requirement: UX States
The system SHALL provide clear UI states for:
- default, focus, loading, error, success

#### Scenario: Loading state
- **WHEN** the user submits the login form
- **THEN** the submit button shows a loading state and prevents duplicate submissions

#### Scenario: Validation errors
- **WHEN** required fields are missing or invalid
- **THEN** errors appear inline and are accessible (labels, `aria-*`, focus management where appropriate)

### Requirement: Security Controls
The system SHALL enforce:
- CSRF protection
- Password hashing
- Rate limiting for repeated failed login attempts
- Generic authentication errors (no account enumeration)

## MODIFIED Requirements

### Requirement: Registration Role Assignment
The system SHALL assign user roles during registration only (not login), and persist role on the user model.

#### Scenario: Student registration
- **WHEN** a user registers as Student
- **THEN** the system requires a matricule and stores it

#### Scenario: Non-student registration
- **WHEN** a user registers as Supervisor/Company/Admin
- **THEN** matricule is not required and may remain null

## REMOVED Requirements

### Requirement: Role Selection at Login
**Reason**: Login must be role-agnostic for a clean SaaS UX.
**Migration**: Remove any UI role selector if present; keep role detection only after authentication.

