# Syncora Design System & UI Style Guide Spec

## Why
Syncora needs a single, consistent, premium SaaS visual language so that authentication, dashboards, and all interactive UI patterns feel unified, accessible, and scalable as the product grows.

## What Changes
- Define a complete design token system (colors, typography, spacing, radius, shadows, z-index, motion).
- Standardize layout rules for auth pages and dashboards (sidebar/topbar/content grid, responsive behavior).
- Define component-level style standards for buttons, inputs, cards, tables, modals, dropdowns, notifications, and charts.
- Define interaction standards (hover/active/focus, page transitions, loading/empty states).
- Define Tailwind conventions for implementing the system consistently across the codebase.
- Establish guidance for dark-mode readiness (structure and token mapping; not full theming unless requested).

## Impact
- Affected specs: UI consistency | component reusability | dashboard shell | forms/tables/cards | accessibility | responsive behavior
- Affected code (future implementation): Tailwind config | global CSS | Blade components | Livewire components | layout templates

## ADDED Requirements

### Requirement: Design Token System
The system SHALL define a stable set of design tokens used across all Syncora pages and UI components.

#### Scenario: Consistent usage
- **WHEN** any page is built (login, signup, dashboards, forms, tables, modals)
- **THEN** it uses only the defined Syncora tokens (colors, spacing, radius, typography, shadows)
- **AND** no ad-hoc colors or spacing values are introduced outside the token set

### Requirement: Component Consistency
The system SHALL provide a consistent look and interaction behavior for core UI components.

#### Scenario: Buttons are consistent
- **WHEN** a Primary button is used anywhere in the product
- **THEN** it uses the same size, radius, font weight, colors, and hover/active/focus behavior

#### Scenario: Inputs are consistent
- **WHEN** a form input is used anywhere in the product
- **THEN** it uses the same height, radius, border, focus ring, and validation feedback behavior

### Requirement: Layout Consistency
The system SHALL standardize layout rules across authentication pages and dashboards.

#### Scenario: Dashboard layout consistency
- **WHEN** a user navigates across Student/Supervisor/Company/Admin dashboards
- **THEN** the shell structure is consistent (sidebar, topbar, main content area)
- **AND** spacing and typography remain consistent across all modules

### Requirement: Accessibility Baseline
The system SHALL meet baseline accessibility requirements for a modern SaaS UI.

#### Scenario: Keyboard navigation and focus visibility
- **WHEN** a user navigates using keyboard only
- **THEN** interactive elements are reachable in a logical order
- **AND** focus indicators are visible and consistent (tokenized focus ring)

## MODIFIED Requirements

### Requirement: UI Styling Comes After Functionality
Syncora SHALL prioritize functionality first; the design system provides implementation guidance that can be layered onto existing functional scaffolding without blocking feature delivery.

## REMOVED Requirements
N/A

## Design Tokens (Source of Truth)

### Color System
**Brand / Primary**
- Primary Indigo: `#4F46E5`
- Primary Hover: `#4338CA`
- Primary Light: `#EEF2FF`
- Secondary Purple: `#7C3AED`
- Accent Cyan: `#06B6D4`

**Neutrals**
- Background: `#F8FAFC`
- Surface: `#FFFFFF`
- Border: `#E2E8F0`
- Muted Text: `#64748B`
- Primary Text: `#0F172A`
- Sidebar Background: `#111827`
- Sidebar Hover: `#1F2937`

**Status**
- Success: `#10B981`
- Warning: `#F59E0B`
- Danger: `#EF4444`
- Info: `#3B82F6`

### Typography
- Font family: Inter, fallback: sans-serif
- Page title: 32px / 700
- Section title: 24px / 600
- Card title: 18px / 600
- Body: 14–16px / 400–500
- Labels: 12px / 500
- Sidebar: 14px / 500

### Spacing
- Base scale (mobile-first): 4, 8, 12, 16, 24, 32, 48, 64 (px)
- Dashboard padding: desktop 24px, tablet 16px, mobile 12px
- Section gap: 24px
- Card gap: 16px

### Radius
- Buttons: rounded-xl
- Inputs: rounded-xl
- Tables: rounded-xl
- Cards: rounded-2xl
- Modals: rounded-2xl

### Shadows
- Cards: shadow-sm
- Hover: shadow-md
- Modals: shadow-xl
- Rule: avoid heavy/dark shadows

### Motion
- Standard transitions: duration-200 ease-in-out
- Page transition: fade 150–250ms
- Rule: subtle, smooth, professional; no excessive motion

## Component Style Standards (Functional UI Rules)

### Buttons
- Primary: indigo bg, white text, height 44px, rounded-xl, font-semibold, focus ring
- Secondary: white bg, border, dark text
- Danger: red bg, white text
- Ghost: transparent bg, hover surface effect
- Interaction: hover slight elevation; active press down; no flashy animations

### Inputs
- Height 48px, subtle border, light surface, rounded-xl
- Focus: indigo ring + border-indigo
- Error: red border + red helper text

### Cards
- White surface, subtle border, rounded-2xl, soft shadow
- Structure: header / body / footer
- Padding: 20–24px

### Tables
- Rounded container, subtle border, sticky header
- Header: muted background, uppercase small labels
- Row hover: subtle neutral background
- Responsive overflow for mobile; card-like fallback permitted

### Sidebar
- Width: 260px desktop; collapsible on mobile
- Background: sidebar background token
- Active link: indigo bg, white text
- Hover: sidebar hover token

### Topbar
- Height: 72px
- Contains: search, notifications, user menu, breadcrumbs
- Surface: white with subtle bottom border

### Modals
- Width: 480–720px
- Centered, blurred backdrop, rounded-2xl, shadow-xl

### Notifications
- Card: rounded-xl, left accent border, icon + message
- Dropdown: grouped list on clean surface, supports unread badge state

### Charts (Guidelines)
- Minimal grid lines, soft colors, rounded tooltips, responsive sizing
- Avoid heavy chart chrome

### Empty/Loading States
- Empty: icon, short message, CTA; centered; minimal
- Loading: skeletons preferred; spinner only when necessary

## Tailwind Conventions (Implementation Rules)
- Prefer tokens and consistent utilities over one-off values.
- Extract repeated UI patterns into components (Blade/Livewire components).
- Enforce consistent spacing using the scale; avoid arbitrary `px` values.
- Avoid random colors; use defined palette only.

