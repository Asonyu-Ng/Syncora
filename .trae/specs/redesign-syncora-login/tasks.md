# Tasks

- [x] Task 1: Define data model for student matricule login
  - [x] Update user model fillables/casts as needed
  - [x] Add/update seeders so demo students have a matricule value
- [x] Task 2: Update registration to be the only place roles exist pre-auth
  - [x] Add role selection to registration UI (Student/Supervisor/Company/Admin)
  - [x] Require matricule only when role = student
  - [x] Persist role and matricule on user creation
- [x] Task 3: Implement Livewire login component + view
  - [x] Create `app/Livewire/Auth/Login.php` with validation, loading state, and error handling
  - [x] Create `resources/views/livewire/auth/login.blade.php` using SaaS split-screen layout
  - [x] Add password visibility toggle (accessible)
  - [x] Ensure no role selector appears on login page
- [x] Task 4: Add auth layout and wire `/login` to Livewire UX
  - [x] Create `resources/views/layouts/auth.blade.php` (left branding panel + right auth card)
  - [x] Update login routing/controller to render the Livewire login experience
  - [x] Ensure mobile-first behavior and correct typography/colors (purple/indigo accents, rounded-xl, soft shadows)
- [x] Task 5: Implement email-or-matricule authentication logic with rate limiting
  - [x] Accept “Email or Matricule” identifier in login
  - [x] If identifier matches matricule pattern, authenticate only against student accounts
  - [x] Preserve Breeze-compatible rate limiting and generic auth errors
- [x] Task 6: Ensure post-auth role detection and redirect is correct
  - [x] On successful login redirect to `/dashboard`
  - [x] Verify `/dashboard` redirects to correct role dashboard without showing role UI
  - [x] Verify unauthorized role access redirects appropriately
- [x] Task 7: Validation + UX verification
  - [x] Verify error states (invalid credentials, missing fields)
  - [x] Verify loading states prevent double-submit
  - [x] Verify keyboard accessibility and visible focus rings

# Task Dependencies

- Task 3 depends on Task 4 for final layout integration
- Task 5 depends on Task 1 (matricule field) and Task 3 (login component)
- Task 6 depends on Task 5
