# Tasks
- [x] Task 1: Audit the current student task domain and review surfaces
  - [x] Review the current student task board component and task-related data model
  - [x] Identify where supervisor and company reviewers should access task submissions
  - [x] Confirm whether existing task tables can support submissions or if a dedicated submission table is needed

- [x] Task 2: Design persistence for task submissions and feedback
  - [x] Add the data structure for task submissions, reviewer feedback, status, and evidence files
  - [x] Support multiple submissions per task with chronological history
  - [x] Ensure the workflow supports `Pending`, `Reviewed`, and `Rework`

- [x] Task 3: Implement the student task submission experience
  - [x] Add a submission form to the student task screen
  - [x] Support written updates and evidence file attachments
  - [x] Show submission history with status, timestamps, and reviewer feedback
  - [x] Allow resubmission without removing previous records

- [x] Task 4: Implement reviewer actions for supervisors and companies
  - [x] Surface task submissions in the appropriate reviewer screens
  - [x] Add actions to mark submissions as `Reviewed` or `Rework`
  - [x] Add reviewer feedback input and display

- [x] Task 5: Add validation, access control, and notifications
  - [x] Ensure only the assigned student can submit to their task
  - [x] Ensure only authorized supervisor/company reviewers can review
  - [x] Validate written updates and file uploads
  - [x] Add user feedback or alerts around submission/review events if appropriate

- [x] Task 6: Verify the workflow end to end
  - [x] Add focused tests for student submission, reviewer feedback, and resubmission
  - [x] Verify the status flow `Pending -> Reviewed/Rework`
  - [x] Verify submission history and evidence links render correctly
  - [x] Check diagnostics for edited files

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 2
- Task 4 depends on Tasks 1 and 2
- Task 5 depends on Tasks 3 and 4
- Task 6 depends on Tasks 3, 4, and 5
