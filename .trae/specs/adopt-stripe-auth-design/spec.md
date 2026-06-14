# Stripe-Inspired Auth Design Spec

## Why
The current login and sign-up pages work, but they use a different visual language from the provided reference. Adopting a Stripe-inspired auth presentation will give Syncora a cleaner, more focused, and more modern first impression while preserving the existing auth behavior.

## What Changes
- Replace the current split-screen auth shell with a centered auth card on a branded gradient background inspired by the provided reference.
- Apply the new design language consistently to both `/login` and `/register`.
- Keep existing authentication and registration behavior intact while restyling the UI.
- Adapt the sign-up flow so role-specific fields still work inside the new centered card layout.
- Preserve accessibility, responsive behavior, and validation/error visibility in the redesigned auth pages.

## Impact
- Affected specs: authentication UX, registration UX, visual design system, responsive auth layout
- Affected code: `resources/views/components/layouts/auth.blade.php`, `resources/views/auth/login.blade.php`, `resources/views/auth/register.blade.php`, auth page tests, and any supporting auth view components

## ADDED Requirements
### Requirement: Centered Auth Card Layout
The system SHALL provide a centered auth card layout for both sign-in and sign-up pages, using a soft branded gradient background inspired by the provided design.

#### Scenario: Desktop auth page load
- **WHEN** a user opens `/login` or `/register` on desktop
- **THEN** the page shows a centered card over a branded gradient background instead of a split-screen layout

#### Scenario: Mobile auth page load
- **WHEN** a user opens `/login` or `/register` on mobile
- **THEN** the page keeps the centered card pattern, reduces surrounding visual weight, and remains easy to read and interact with

### Requirement: Stripe-Inspired Login Presentation
The system SHALL present the login form using the visual structure of the provided reference while keeping Syncora’s actual login capabilities.

#### Scenario: Login page structure
- **WHEN** a user views `/login`
- **THEN** the page shows a clean title, labeled input fields, remember-me option, forgot-password link, primary sign-in action, and sign-up link inside a refined auth card

#### Scenario: Syncora login behavior preserved
- **WHEN** a user submits the redesigned login form
- **THEN** the system preserves the existing validation, authentication, and post-login redirect behavior

### Requirement: Stripe-Inspired Sign-Up Presentation
The system SHALL present the registration flow using the same centered auth card design language while preserving role-specific registration fields.

#### Scenario: Sign-up page structure
- **WHEN** a user views `/register`
- **THEN** the page shows a centered card with a clean heading, role-selection controls, active role summary, role-specific inputs, and a primary create-account action

#### Scenario: Role-specific sign-up in redesigned layout
- **WHEN** a user switches between `Student`, `Supervisor`, and `Company`
- **THEN** the centered card updates the visible fields without breaking the new visual layout

### Requirement: Shared Auth Design Language
The system SHALL use a shared visual system across login and sign-up pages.

#### Scenario: Auth page comparison
- **WHEN** a user navigates between `/login` and `/register`
- **THEN** both pages share the same background treatment, card shape, spacing rhythm, typography direction, and action styling

### Requirement: Auth Footer and Secondary Guidance
The system SHALL provide subtle secondary guidance below or within the auth card without distracting from the primary action.

#### Scenario: Auxiliary guidance present
- **WHEN** a user views either auth page
- **THEN** the page includes subtle secondary guidance such as supporting text, account-switch link, or short trust/helper copy

## MODIFIED Requirements
### Requirement: Auth Layout
The system SHALL replace the existing split-screen auth layout with a centered card layout inspired by the provided reference while preserving Syncora branding and auth functionality.

#### Scenario: Existing auth layout replaced
- **WHEN** the redesigned auth pages are rendered
- **THEN** the previous left-branding-panel plus right-card layout is no longer used for `/login` and `/register`

### Requirement: Registration Visual Flow
The system SHALL continue supporting role-specific registration, but the visual flow must now fit a compact, centered-card auth experience instead of a wider SaaS onboarding panel.

#### Scenario: Registration review
- **WHEN** a user reviews the sign-up page
- **THEN** role selection, active role context, and required fields fit naturally within the centered card layout

## REMOVED Requirements
### Requirement: Split-Screen Auth Shell
**Reason**: The provided design direction uses a centered card with a branded background rather than a two-panel auth experience.
**Migration**: Replace the split-screen shell with a reusable centered auth shell while keeping current routes, validation, and role-specific logic intact.
