# Student Task Submit Modal Spec

## Why
The current student task page already supports submissions, but the submission form is always visible in the page layout. The task page should instead use a clearer call to action with a `Submit` button that opens a popup flow for selecting the task, entering the write-up, and attaching evidence.

## What Changes
- Replace the always-visible submission entry area on the student task page with a `Submit` button
- Open a popup/modal when the student wants to submit task work
- Allow the student to select the target task inside the popup before submitting
- Keep the existing write-up and evidence upload workflow, including file or image evidence
- Preserve existing validation, submission status handling, and history display after submission

## Impact
- Affected specs: `implement-student-task-submission-workflow`
- Affected code: `app/Livewire/Student/TaskBoard.php`, `resources/views/livewire/student/task-board.blade.php`, focused student task tests

## ADDED Requirements
### Requirement: Task Submission Modal Entry
The system SHALL provide a dedicated `Submit` action on the student task page that opens a modal for creating a task submission.

#### Scenario: Student opens the submission popup
- **WHEN** the student clicks the `Submit` button on the task page
- **THEN** the system opens a popup/modal instead of requiring the student to use an inline form

### Requirement: Task Selection Inside Popup
The system SHALL let the student choose which of their available tasks they want to submit from inside the popup before sending the submission.

#### Scenario: Student chooses a task to submit
- **WHEN** the popup opens
- **THEN** the student can select one of their assigned tasks in the popup
- **AND** the chosen task becomes the target for the submission

## MODIFIED Requirements
### Requirement: Student Task Submission Entry
The system SHALL let students submit a task update by using a popup-based submission flow that includes task selection, a written update field, and evidence upload controls for files or images.

#### Scenario: Student submits a task update from the popup
- **WHEN** the student selects a task, enters a valid write-up, and attaches optional evidence in the popup
- **THEN** the system creates a new submission for that task
- **AND** the submission enters the `Pending` state
- **AND** the student sees success feedback on the task page

#### Scenario: Student submits with file or image evidence
- **WHEN** the student attaches supported evidence such as a document or image in the popup
- **THEN** the system validates and stores the evidence using the existing submission workflow rules

## REMOVED Requirements
### Requirement: Always-Visible Inline Submission Form
**Reason**: The task page should use a cleaner button-to-popup flow instead of keeping the submission form permanently visible in the page layout.
**Migration**: Move the existing write-up and evidence controls into the modal while preserving the current submission logic and validation behavior.
