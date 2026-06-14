# Login Reference Image Match Spec

## Why
The current login page already has a polished auth design, but it does not match the newly provided reference image. The login page should be restyled to follow the same split layout, visual hierarchy, and form presentation shown in the image while preserving Syncora behavior.

## What Changes
- Redesign the login page to use a two-column layout similar to the provided image
- Add a left branded visual panel with welcome copy and supporting messaging
- Restyle the right login form area to match the reference image structure and spacing
- Preserve current login behavior, validation, links, and accessibility
- Keep Syncora branding instead of copying the reference product name directly

## Impact
- Affected specs: `redesign-syncora-login`, `adopt-stripe-auth-design`
- Affected code: `resources/views/components/layouts/auth.blade.php`, `resources/views/auth/login.blade.php`, related auth tests

## ADDED Requirements
### Requirement: Reference-Matched Split Login Layout
The system SHALL provide a login page layout that visually follows the provided reference image with a left branded panel and a right sign-in form panel.

#### Scenario: User opens the login page
- **WHEN** the user visits `/login`
- **THEN** the page shows a split layout with a branded visual area on the left and the sign-in form on the right

### Requirement: Branded Left Visual Panel
The system SHALL show a left panel inspired by the reference image with Syncora branding, a welcome headline, and supporting marketing copy.

#### Scenario: User views the branding panel
- **WHEN** the login page loads on desktop
- **THEN** the left panel shows Syncora branding, welcome messaging, and supporting text in a visual block inspired by the provided image

## MODIFIED Requirements
### Requirement: Login Form Presentation
The system SHALL present the login form in a right-side panel styled to match the provided reference image while preserving existing Syncora authentication behavior.

#### Scenario: User signs in from the redesigned page
- **WHEN** the user enters valid credentials and submits the form
- **THEN** the page authenticates using the existing login flow
- **AND** the user receives the same redirects and validation behavior as before

#### Scenario: User sees the redesigned form shell
- **WHEN** the login page renders
- **THEN** the form area shows a heading, helper text, email input, password input, forgot-password link, primary sign-in button, and sign-up prompt in a layout aligned with the reference image

## REMOVED Requirements
### Requirement: Centered Card Login Shell
**Reason**: The new target visual direction is a side-by-side reference-matched layout rather than a centered auth card.
**Migration**: Replace the centered login shell styling with the split layout while keeping the underlying form fields, links, and auth logic unchanged.
