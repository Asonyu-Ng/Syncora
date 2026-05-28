# Tasks
- [x] Task 1: Establish token source of truth
  - [x] Confirm the required color palette, typography, spacing, radius, shadow, and motion tokens (as specified)
  - [x] Identify any existing Tailwind/theme settings that conflict with the token set

- [x] Task 2: Define layout rules for auth and dashboards
  - [x] Specify standard layout slots and spacing rules for auth pages
  - [x] Specify standard layout slots and spacing rules for dashboard shell (sidebar/topbar/content)
  - [x] Define responsive behavior for sidebar/topbar (mobile-first)

- [x] Task 3: Define component standards (functional-first)
  - [x] Buttons: primary/secondary/danger/ghost + states (hover/active/disabled/focus)
  - [x] Inputs: text/select/textarea/checkbox/radio + validation states
  - [x] Cards: header/body/footer, padding rules, density options
  - [x] Tables: header rules, row density, hover, responsive overflow, empty/loading
  - [x] Dropdowns: alignment, padding, item states, separators
  - [x] Modals: sizing, backdrop, focus trap expectations, confirm patterns
  - [x] Notifications: badge, dropdown list, read/unread styling rules
  - [x] Charts: minimal styling guidelines

- [x] Task 4: Accessibility and interaction standards
  - [x] Define focus ring and keyboard navigation expectations for all components
  - [x] Define contrast baseline expectations for text and status colors
  - [x] Define motion rules (durations, easing, reduced motion considerations)

- [x] Task 5: Tailwind conventions and usage rules
  - [x] Define how tokens map to Tailwind config (colors, font family, radius, shadows)
  - [x] Define when to use utility classes vs. extracted components
  - [x] Define “avoid list” (random spacing, ad-hoc colors, inconsistent radii)

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 1 and Task 2
- Task 4 depends on Task 3
- Task 5 depends on Tasks 1–4
