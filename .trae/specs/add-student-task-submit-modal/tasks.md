# Tasks
- [x] Task 1: Review the current student task submission entry flow
  - [x] Confirm how the current task page exposes the submission form and selected task state
  - [x] Identify which existing submission logic can be reused without changing backend behavior

- [x] Task 2: Add a modal-based submit entry on the student task page
  - [x] Replace the inline submission entry point with a visible `Submit` button
  - [x] Open and close a popup/modal from the student task page
  - [x] Add task selection inside the popup

- [x] Task 3: Move submission inputs into the popup
  - [x] Show the write-up field inside the popup
  - [x] Show the evidence upload control inside the popup
  - [x] Preserve support for file and image evidence
  - [x] Reuse the current validation and submission behavior

- [x] Task 4: Keep task context and feedback clear after submission
  - [x] Show success or validation feedback in the updated flow
  - [x] Ensure the selected task and submission history still make sense after popup submission

- [x] Task 5: Verify the modal submission flow
  - [x] Update focused tests for the popup-based submit flow
  - [x] Verify file and image evidence handling still works
  - [x] Check diagnostics for edited files

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 2
- Task 4 depends on Task 3
- Task 5 depends on Tasks 3 and 4
