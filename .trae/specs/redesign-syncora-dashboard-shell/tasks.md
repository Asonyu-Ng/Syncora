# Tasks
- [x] Task 1: Audit current dashboard shell usage
  - [x] Identify all pages using `layouts.dashboard`
  - [x] Identify any role pages that render their own shell styling

- [x] Task 2: Redesign sidebar component (light theme)
  - [x] Implement light sidebar background + border + spacing using design tokens
  - [x] Implement active state as indigo pill and consistent hover states
  - [x] Align icons + labels and standardize vertical rhythm
  - [x] Ensure mobile collapse and backdrop behavior still works

- [x] Task 3: Redesign topbar component
  - [x] Implement 72px height and updated spacing
  - [x] Add responsive search slot styling consistent with design system inputs
  - [x] Ensure notification badge + user identity block matches the reference style
  - [x] Ensure breadcrumbs/page title behavior is responsive

- [x] Task 4: Standardize content container + remove layout gutters
  - [x] Apply consistent content padding rules across breakpoints
  - [x] Ensure sidebar + content sit flush with no blank strip
  - [x] Ensure `min-w-0` rules prevent overflow in content area

- [x] Task 5: Align role dashboards to the new shell
  - [x] Confirm Student/Supervisor/Company/Admin dashboards render correctly without overlap
  - [x] Ensure cards/tables/widgets follow the spacing grid (section gap 24px, card gap 16px)

- [x] Task 6: Verification
  - [x] Visual smoke: login as each role and confirm shell consistency
  - [x] Responsive smoke: verify mobile sidebar toggle + topbar layout
  - [x] Run `php artisan test`

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 1
- Task 4 depends on Tasks 2–3
- Task 5 depends on Task 4
- Task 6 depends on Task 5
