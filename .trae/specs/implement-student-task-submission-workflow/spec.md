# Student Task Submission Workflow Spec

## Why
The current student task screen focuses on assigned work but does not yet provide a structured submission and review workflow. Students need a clear way to submit updates and evidence, while supervisors and companies need review and feedback tools that improve communication and performance tracking.

## What Changes
- Add a task submission workflow to the student task screen.
- Allow students to submit a written update plus evidence files for assigned tasks.
- Allow supervisors and companies to review submissions and provide feedback.
- Support the review states `Pending`, `Reviewed`, and `Rework`.
- Allow multiple submissions and resubmissions per task with visible history.

## Impact
- Affected specs: student dashboard workflow, task management, supervisor review workflow, company review workflow
- Affected code:
  - `app/Livewire/Student/TaskBoard.php`
  - `resources/views/livewire/student/task-board.blade.php`
  - task-related models, migrations, and review/submission persistence
  - supervisor/company task review screens where submission review is surfaced

## ADDED Requirements
### Requirement: Student Task Submission
The system SHALL allow a student to submit progress updates for assigned tasks.

#### Scenario: Student submits an update
- **WHEN** a student opens an assigned task
- **THEN** the task view SHALL provide a submission form with:
  - a written update field
  - one or more evidence file attachments
- **AND** the student SHALL be able to submit the update against that task.

#### Scenario: Student sees submission history
- **WHEN** a task has one or more submissions
- **THEN** the task view SHALL display a submission timeline or history list
- **AND** each item SHALL show the submitted update, attached evidence, timestamp, and review outcome.

### Requirement: Review Workflow
The system SHALL provide a review workflow for supervisors and companies on task submissions.

#### Scenario: Submission enters pending review
- **WHEN** a student submits a task update
- **THEN** the submission status SHALL become `Pending`
- **AND** the task SHALL be visible to the appropriate reviewer(s).

#### Scenario: Reviewer marks submission reviewed
- **WHEN** a supervisor or company reviewer accepts the submission
- **THEN** the submission status SHALL become `Reviewed`
- **AND** the reviewer MAY add feedback for the student.

#### Scenario: Reviewer requests rework
- **WHEN** a supervisor or company reviewer determines the submission needs changes
- **THEN** the submission status SHALL become `Rework`
- **AND** the reviewer SHALL be able to provide feedback explaining what needs improvement.

### Requirement: Resubmission Support
The system SHALL allow multiple submissions on the same task.

#### Scenario: Student resubmits after feedback
- **WHEN** a task has an earlier submission marked `Rework`
- **THEN** the student SHALL be able to submit a new update for the same task
- **AND** prior submissions SHALL remain visible in the submission history
- **AND** the latest submission SHALL become the active one for review.

#### Scenario: Student submits multiple progress updates
- **WHEN** the workflow expects ongoing updates for the same task
- **THEN** the student SHALL be allowed to submit additional updates without deleting previous records
- **AND** the system SHALL preserve chronological history.

### Requirement: Reviewer Feedback Visibility
The system SHALL show reviewer feedback to students inside the task workflow.

#### Scenario: Student views feedback
- **WHEN** a reviewer leaves feedback on a submission
- **THEN** the student SHALL see the reviewer identity or role, status, timestamp, and feedback message in the task submission history.

### Requirement: Evidence Files
The system SHALL support evidence file uploads on task submissions.

#### Scenario: Student attaches files
- **WHEN** a student submits a task update
- **THEN** the submission form SHALL allow attaching evidence files
- **AND** the stored submission SHALL preserve the file metadata and retrieval path for later review.

## MODIFIED Requirements
### Requirement: Student Task Screen
The system SHALL extend the student task screen from a task-viewing experience into a task submission and review workflow that supports progress evidence, reviewer feedback, and resubmission history.

## REMOVED Requirements
None
