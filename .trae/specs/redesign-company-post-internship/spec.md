# Company Post Internship Spec

## Why
The current company `Post Internship` page is still a stub and does not match the proposed product visual. Companies need a cleaner, production-ready form that feels consistent with the dashboard while still saving real internship records.

## What Changes
- Redesign the company `Post Internship` screen to match the provided visual direction.
- Keep the existing dashboard shell and current Syncora color system.
- Implement real form persistence instead of the current stub submit flow.
- Support work mode options: `Onsite`, `Hybrid`, and `Remote`.
- Use a duration slider from `1` to `5` months.
- Make `Required Skills` behave like tag entry chips.
- Keep the attachment area visible as a UI placeholder only for the first version.
- Use Cameroon-based placeholder and helper copy instead of Nigeria-based examples.

## Impact
- Affected specs: company dashboard workflow, internship publishing, dashboard form UX
- Affected code:
  - `app/Livewire/Company/PostInternship.php`
  - `resources/views/livewire/company/post-internship.blade.php`
  - `app/Services/InternshipService.php`
  - related company internship routes/views if save/redirect behavior needs alignment

## ADDED Requirements
### Requirement: Redesigned Company Post Internship Page
The system SHALL provide a redesigned company `Post Internship` page that matches the supplied visual direction and works inside the current dashboard shell.

#### Scenario: Open post internship page
- **WHEN** a company user opens the post internship page
- **THEN** the page shows:
  - a back action
  - a page title and helper text
  - a clean single-card form layout
  - section headers for `Internship Information` and `Requirements`
  - a bottom action row with `Cancel` and `Publish Internship`

### Requirement: Internship Form Fields
The system SHALL support the visible form fields from the approved mockup.

#### Scenario: Fill internship information
- **WHEN** a company user completes the form
- **THEN** the page SHALL provide these inputs:
  - `Internship Title`
  - `Department / Field`
  - `Location`
  - `Type`
  - `Duration`
  - `Description`
  - `Required Skills`
  - `Education Level`
  - `Other Requirements`
  - `Attach Files` placeholder area

### Requirement: Work Mode Options
The system SHALL support all three work mode options requested by the user.

#### Scenario: Select internship type
- **WHEN** the company opens the `Type` field
- **THEN** the selectable options SHALL include:
  - `Onsite`
  - `Hybrid`
  - `Remote`

### Requirement: Duration Slider
The system SHALL use a slider control for internship duration.

#### Scenario: Select internship duration
- **WHEN** the company adjusts the duration control
- **THEN** the page SHALL allow selecting a value from `1` to `5`
- **AND** the selected duration SHALL be displayed in months
- **AND** the saved value SHALL remain consistent with the selected slider value.

### Requirement: Skill Tag Input
The system SHALL allow required skills to be entered as tags.

#### Scenario: Add required skills
- **WHEN** the company types a skill and confirms it
- **THEN** the skill SHALL appear as a removable tag chip
- **AND** the user SHALL be able to add multiple skills
- **AND** the saved internship record SHALL preserve all entered skills.

### Requirement: Real Publish Flow
The system SHALL save a real internship record from the redesigned page.

#### Scenario: Publish internship
- **WHEN** the company clicks `Publish Internship` with valid input
- **THEN** the internship SHALL be saved through the application’s internship publishing flow
- **AND** the new posting SHALL be created as published
- **AND** the company SHALL receive success feedback
- **AND** the page SHALL redirect to the appropriate company internship destination.

### Requirement: Attachment Placeholder
The system SHALL visually include the file upload area without processing files in the first version.

#### Scenario: View attachment section
- **WHEN** the company views the form
- **THEN** the upload area SHALL appear in the layout
- **AND** it SHALL clearly read as optional
- **AND** it SHALL not block publish if no file is attached.

### Requirement: Cameroon-Based Copy
The system SHALL use Cameroon-based examples and helper text on the page.

#### Scenario: Read placeholders and examples
- **WHEN** the company views helper copy or sample locations
- **THEN** examples SHALL use Cameroon-based wording such as `Douala`, `Yaounde`, `Bamenda`, or `Remote`
- **AND** Nigeria-based placeholder content SHALL not appear on this screen.

## MODIFIED Requirements
### Requirement: Replace Stub Post Internship Flow
The system SHALL replace the current stub-only `Post Internship` screen with a redesigned UI and real save behavior while keeping the existing company dashboard structure intact.

## REMOVED Requirements
### Requirement: Stub Publish Interaction
**Reason**: The page should no longer behave as a temporary placeholder.
**Migration**: Replace the stub submit/message flow with real validation, persistence, and success handling.
