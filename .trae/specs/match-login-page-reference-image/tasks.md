# Tasks
- [x] Task 1: Review the current login layout against the new reference image
  - [x] Identify which parts of the current auth shell conflict with the target split-screen layout
  - [x] Map the reference image into reusable Syncora login page sections

- [x] Task 2: Rebuild the shared login shell to match the reference structure
  - [x] Create the left branded visual panel with Syncora copy and reference-inspired styling
  - [x] Rework the right panel structure for the sign-in form
  - [x] Preserve responsive behavior for mobile and desktop

- [x] Task 3: Restyle the login form content to match the image
  - [x] Update heading, helper text, field spacing, and primary button hierarchy
  - [x] Preserve forgot-password and sign-up affordances in the new layout
  - [x] Keep validation, accessibility, and existing login behavior intact

- [x] Task 4: Verify the redesigned login page
  - [x] Update focused login page tests if needed
  - [x] Check that `/login` still authenticates and redirects correctly
  - [x] Check diagnostics for edited files

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 2
- Task 4 depends on Tasks 2 and 3
