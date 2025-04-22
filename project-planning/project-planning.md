# 🗂 WeCoza Project Board

## Overview

| Status         | Count |
|----------------|:-----:|
| 💡 Ideas       |   1   |
| 📥 Backlog     |   0   |
| 📝 Todo        |   2   |
| 🚧 In Progress |   1   |
| 🔍 In Review   |   0   |
| ✅ Done        |  17   |
| ❌ Cancelled   |   5   |
| **Total**      | **26** |

<details>
<summary>📖 Shortcode Options Reference (click to expand)</summary>

## Shortcode Options Reference

### File References
- `(TK)` – Targets this file (`project-planning.md`)
- `(TK)(WEC-XX)` – Targets one or more specific tasks

### Task Operations
- **Move status:**
  `(TK)(WEC-XX) status=Ideas|Backlog|Todo|InProgress|InReview|Done|Cancelled`
- **Set priority:**
  `(TK)(WEC-XX) priority=Urgent|High|Medium|Low|None`
- **Labels:**
  `(TK)(WEC-XX) labels=Bug,Feature,UX`
- **Comment:**
  `(TK)(WEC-XX) comment="Your comment here"`
- **Add subtask:**
  `(TK)(WEC-XX) add-subtask="Describe subtask"`
- **Screenshot:**
  `(TK)(WEC-XX) screenshot="https://…/image.png"`
- **New task:**
  `(TK)(new WEC-YY) title="…" status=Ideas priority=Medium labels=…`
- **Delete:**
  `(TK)(WEC-XX) delete`
- **Overview:**
  `(TK)(overview)`

</details>

<details>
<summary>💡 Ideas</summary>

- [ ] WEC-18 – Batch Learner Management _(High)_
  - Description: Allow users to add multiple learners at once from a pre-defined list or template.
    Proposed solution: Add a "Select All" option and batch processing.

</details>

<details>
<summary>📥 Backlog</summary>

_No tasks_

</details>

<details>
<summary>📝 Todo</summary>

- [ ] WEC-25 – Drag‑and‑Drop Exception Date Management _(Medium)_
  - Description: Allow users to add exception dates by clicking directly on the calendar rather than using the full form.

- [ ] WEC-31 – Stepped Workflow for Classes _(None)_
  - Description: Instead of displaying the whole (full) form, break it into steps for better UX.

</details>

<details>
<summary>🚧 In Progress</summary>

- [ ] WEC-28 – Calendar Export Integration _(Medium)_
  - Description: Add functionality to export class schedules to external calendar applications.
    Proposed Solution: Implement iCalendar (.ics) export for bulk schedule export.
  - Sub‑tasks:
    - [ ] WEC-28-1: Move the export button into "View Calendar" section
    - [ ] WEC-28-2: Relocate calendar below "Class Date History"

</details>

<details>
<summary>🔍 In Review</summary>

_No tasks_

</details>

<details>
<summary>✅ Done</summary>

- [x] WEC-37 – Fix Learner Selection Popup Issue _(Urgent)_
  - Description: Fixed issue where "Please select at least one learner to add" popup appears even when learners are already selected and loaded in the background.
  - Fixed by commenting out the validation checks that were triggering the popup unnecessarily.

- [x] WEC-36: Fix jQuery error in class-capture.js
  - Fixed error: `Uncaught TypeError: $ is not a function at showCustomAlert`
  - The showCustomAlert function was using $ directly outside of the jQuery IIFE
  - Modified the function to use jQuery instead of $ in the global scope

- [x] WEC-35 – Fix validation error when selecting learners for exams _(High)_
  - Description: When selecting "Learners Taking Exam", the system shows a validation error message even though a learner is selected.
  - Fixed by improving the validation logic to properly check for selected exam learners and enhancing the UI state management.

- [x] WEC-33 – Class Types & Durations Integration _(High)_
  - Description: Rework how we integrate Class Types & Durations in the system.
    Implemented a more flexible and maintainable approach for managing class types and their associated durations, ensuring proper calculation of schedule hours and end dates.
  - Completed by creating ClassTypesController and implementing two-level selection system with automatic duration calculation.

- [x] WEC-32 – Verification issue _(Urgent)_
  - Description: ![image.png](https://uploads.linear.app/…4277b7d4-59c7-4238-8b9d-0f3174f24547)
    Under Class Learners, "Select Learners" doesn't register selections.
  - Fixed by correcting the learner-selection logic in `class-learners.php`.

- [x] WEC-27 – Class Conflict Detection _(Urgent)_
  - Description: Detect and warn about potential conflicts when scheduling classes.
  - Fixed by adding conflict‑detection logic to check overlapping schedules.

- [x] WEC-21 – Verification issue _(Urgent)_
  - Description: ![image.png](https://uploads.linear.app/…0f3174f24547)
    "Select Learners" still shows no response.
  - Fixed by ensuring the update function fires correctly.

- [x] WEC-17 – Improved Calendar Visualization _(High)_
  - Description: Enhance calendar visuals with distinct styling and hover states.

- [x] WEC-19 – Advanced Validation Feedback _(Urgent)_
  - Description: Provide more detailed, user‑friendly validation messages.

- [x] WEC-11 – Exception Dates Recalculation _(High)_
  - Description: Recalculate recurring schedules when exception dates change.

- [x] WEC-24 – View attachments in Augment _(Urgent)_
  - Description: Need to view Linear attachments from Augment, not WP.
  - Fixed by integrating Augment tools for attachment preview.

- [x] WEC-23 – Page SC _(None)_
  - Description: ![Screenshot](https://uploads.linear.app/…)
    Updated summary of changes in the Page SC component.

- [x] WEC-20 – Verification issue _(Urgent)_
  - Description: ![image.png](https://uploads.linear.app/…0f3174f24547)
    Update function wasn't firing in Class Learners.

- [x] WEC-15 – Form Validation on Submit _(High)_
  - Description: Fixed validation logic to correctly recognize completed fields.

- [x] WEC-14 – Calendar Text Readability _(High)_
  - Description: Ensured white text on events to improve contrast.

- [x] WEC-13 – Exam Learners Selection Issues _(Urgent)_
  - Description: Fixed exam learner count logic to clear validation errors.

- [x] WEC-12 – Class Learners Selection Issues _(Urgent)_
  - Description: Added hidden fields and updated logic to clear stale errors.

- [x] WEC-10 – Day of Week Restriction _(Urgent)_
  - Description: Implemented day‑of‑week consistency checks.

</details>

<details>
<summary>❌ Cancelled</summary>

- [ ] WEC-16 – Calendar Initialization in Tabs _(High)_
  - Description: Calendar may not initialize properly when switching tabs.

- [ ] WEC-22 – Calendar Initialization in Tabs _(High)_
  - Description: Calendar doesn't initialize correctly when embedded.

- [ ] WEC-26 – Recurring Schedule Templates _(High)_
  - Description: Allow saving and reusing recurring schedule templates.

- [ ] WEC-29 – Multi‑View Calendar Options _(High)_
  - Description: Add day/week/month view options to calendar.

- [ ] WEC-30 – Bulk Class Operations _(High)_
  - Description: Perform operations on multiple classes at once.

</details>

