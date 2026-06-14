# Role-Specific Sign Up Fields Spec

## Why
The sign-up page needs to match the provided visual and collect the right information for each role without showing irrelevant inputs. A role-specific form will make registration clearer for Student, Supervisor, and Company users.

## What Changes
- Update the registration experience so each selectable role reveals its own required input fields.
- Keep shared fields aligned with the provided sign-up visual and role cards.
- Validate and persist the correct data set for Student, Supervisor, and Company registrations.
- Remove one-size-fits-all registration inputs that do not belong to the selected role.

## Impact
- Affected specs: authentication UX, registration flow, role assignment, profile capture
- Affected code: `resources/views/auth/register.blade.php`, `app/Http/Controllers/Auth/RegisteredUserController.php`, validation rules, user/profile persistence for student, supervisor, and company roles

## ADDED Requirements
### Requirement: Role-Specific Registration Form
The system SHALL provide a sign-up page where the selected role determines which input fields are shown and required.

#### Scenario: Student role selected
- **WHEN** the user selects `Student` on the sign-up page
- **THEN** the form shows these fields: `Full Name`, `Email Address`, `Institution`, `Department`, and `Password`

#### Scenario: Supervisor role selected
- **WHEN** the user selects `Supervisor` on the sign-up page
- **THEN** the form shows these fields: `Full Name`, `Institution`, `Position`, `Department`, `Email Address`, and `Password`

#### Scenario: Company role selected
- **WHEN** the user selects `Company` on the sign-up page
- **THEN** the form shows these fields: `Company Name`, `Industry Type`, `Email Address`, `Company Location`, and `Password`

### Requirement: Role-Specific Validation
The system SHALL validate only the fields required for the currently selected role and reject submissions with missing required values.

#### Scenario: Student submission missing department
- **WHEN** a Student registration is submitted without `Department`
- **THEN** the system rejects the submission and shows a validation error for `Department`

#### Scenario: Supervisor submission missing position
- **WHEN** a Supervisor registration is submitted without `Position`
- **THEN** the system rejects the submission and shows a validation error for `Position`

#### Scenario: Company submission missing location
- **WHEN** a Company registration is submitted without `Company Location`
- **THEN** the system rejects the submission and shows a validation error for `Company Location`

### Requirement: Role-Specific Data Persistence
The system SHALL save the selected role and its role-specific registration fields in the appropriate user/profile records.

#### Scenario: Student registration succeeds
- **WHEN** a Student registration passes validation
- **THEN** the system stores the user as `student` and persists `Full Name`, `Email Address`, `Institution`, and `Department`

#### Scenario: Supervisor registration succeeds
- **WHEN** a Supervisor registration passes validation
- **THEN** the system stores the user as `supervisor` and persists `Full Name`, `Institution`, `Position`, `Department`, `Email Address`, and `Password`

#### Scenario: Company registration succeeds
- **WHEN** a Company registration passes validation
- **THEN** the system stores the user as `company` and persists `Company Name`, `Industry Type`, `Email Address`, `Company Location`, and `Password`

### Requirement: Dynamic Role Switching
The system SHALL update the visible form fields immediately when the user changes the selected role.

#### Scenario: Switching from Student to Company
- **WHEN** the user changes the selected role from `Student` to `Company`
- **THEN** the student-only inputs are hidden and the company-specific inputs are shown before submission

## MODIFIED Requirements
### Requirement: Registration Role Assignment
The system SHALL continue assigning the role during registration, but the registration page must now present a distinct field set for each supported role instead of a mostly shared form with minimal role differences.

#### Scenario: Registration UI review
- **WHEN** a user reviews the sign-up page
- **THEN** each role card maps to a different required field set that matches the provided visual and content list

## REMOVED Requirements
### Requirement: Generic Registration Input Set
**Reason**: A generic registration form does not capture the correct information for each role and does not match the requested sign-up design.
**Migration**: Replace generic shared registration inputs with role-specific field groups while preserving role selection during registration.
