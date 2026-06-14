# Tasks

- [x] Task 1: Define the Stripe-inspired auth layout delta
  - [x] Identify which parts of the current split-screen auth shell must be removed or replaced
  - [x] Map the provided reference into reusable Syncora auth layout pieces for login and sign-up

- [x] Task 2: Redesign the shared auth shell
  - [x] Build a centered auth card layout with branded gradient background
  - [x] Ensure the shared shell works for both login and sign-up pages
  - [x] Preserve responsive behavior on mobile and desktop

- [x] Task 3: Apply the new visual direction to the login page
  - [x] Restyle login heading, inputs, links, and primary action to match the new centered-card design
  - [x] Preserve existing login behavior, validation, and redirect flow

- [x] Task 4: Apply the new visual direction to the sign-up page
  - [x] Restyle role selector, role summary, role-specific fields, and primary action inside the centered card
  - [x] Preserve role-specific field switching and existing registration behavior

- [x] Task 5: Verify auth pages after redesign
  - [x] Confirm `/login` and `/register` share the same visual system
  - [x] Confirm login still works with current validation and redirects
  - [x] Confirm role-specific sign-up still works inside the new layout
  - [x] Run focused auth page tests and preview verification

- [x] Task 6: Fix checklist gaps from verification
  - [x] Ensure auth branding renders as `Syncora` in the redesigned auth shell during live preview
  - [x] Preserve the `Remember me` checkbox state after failed login submission

- [x] Task 7: Refine auth visuals from live preview feedback
  - [x] Change the login and sign-up background treatment to a light gradient instead of a dark one
  - [x] Fix the sign-up page layout so the role selector and card content do not feel cramped or visually broken in preview

# Task Dependencies

- Task 2 depends on Task 1
- Task 3 depends on Task 2
- Task 4 depends on Task 2
- Task 5 depends on Task 3 and Task 4
- Task 6 depends on Task 5
- Task 7 depends on Task 6
