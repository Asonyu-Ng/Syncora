# Tasks
- [ ] Task 1: Audit the current company internship posting flow
  - [ ] Review `PostInternship` Livewire component, blade view, and `InternshipService`
  - [ ] Confirm which database fields already exist for internship publishing
  - [ ] Identify any missing mappings needed for type, duration, education level, and skills

- [ ] Task 2: Redesign the post internship page UI
  - [ ] Replace the stub layout with the approved single-card form structure
  - [ ] Add header area with back action, title, helper text, and lightweight visual accent
  - [ ] Add section blocks for `Internship Information` and `Requirements`
  - [ ] Preserve current dashboard shell and color system

- [ ] Task 3: Implement the new input behaviors
  - [ ] Add `Type` select with `Onsite`, `Hybrid`, and `Remote`
  - [ ] Add a `1–5 months` duration slider with visible current value
  - [ ] Add tag-style `Required Skills` entry with add/remove behavior
  - [ ] Keep the attachment area as a UI-only placeholder

- [ ] Task 4: Implement real save and validation
  - [ ] Add validation for all visible fields that are required by the page
  - [ ] Save the internship through the real posting flow instead of the current stub
  - [ ] Publish directly on submit
  - [ ] Redirect with success feedback after publish

- [ ] Task 5: Localize page examples for Cameroon
  - [ ] Replace non-Cameroon placeholder text with Cameroon-based examples
  - [ ] Ensure helper text and sample location wording remain consistent across the page

- [ ] Task 6: Verify the page safely
  - [ ] Add or update focused tests for page render and publish behavior
  - [ ] Confirm the redesigned page does not break the company dashboard shell
  - [ ] Check diagnostics for edited files

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 2
- Task 4 depends on Tasks 1 and 3
- Task 5 depends on Task 2
- Task 6 depends on Tasks 2, 3, 4, and 5
