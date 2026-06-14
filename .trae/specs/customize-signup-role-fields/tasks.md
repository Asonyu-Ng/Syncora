# Tasks

- [x] Task 1: Map the requested sign-up fields to the registration domain model
  - [x] Confirm where each role-specific field is stored for Student, Supervisor, and Company users
  - [x] Identify any existing generic registration fields that must be replaced or hidden

- [x] Task 2: Update the sign-up UI to match the role-specific visual behavior
  - [x] Keep the role selector visible on the sign-up page
  - [x] Show Student fields only when `Student` is selected
  - [x] Show Supervisor fields only when `Supervisor` is selected
  - [x] Show Company fields only when `Company` is selected

- [x] Task 3: Implement backend validation for each role
  - [x] Require `Full Name`, `Email Address`, `Institution`, `Department`, and `Password` for Student
  - [x] Require `Full Name`, `Institution`, `Position`, `Department`, `Email Address`, and `Password` for Supervisor
  - [x] Require `Company Name`, `Industry Type`, `Email Address`, `Company Location`, and `Password` for Company

- [x] Task 4: Persist role-specific registration data
  - [x] Save the selected role consistently with the existing auth flow
  - [x] Store role-specific fields in the correct user/profile records
  - [x] Ensure unused fields from other roles are not required during submission

- [x] Task 5: Verify the registration experience end to end
  - [x] Confirm role switching updates visible inputs without page confusion
  - [x] Confirm each role can register successfully with its own required field set
  - [x] Confirm validation errors appear for missing role-specific required inputs

# Task Dependencies

- Task 2 depends on Task 1
- Task 3 depends on Task 1
- Task 4 depends on Task 3
- Task 5 depends on Task 2, Task 3, and Task 4
