# 🗂 WeCoza Project Board

## Overview

| Status        | Count |
|---------------|:-----:|
| 💡 Ideas      |   1   |
| 📥 Backlog    |   1   |
| 📝 Todo       |   2   |
| 🚧 In Progress|   0   |
| 🔍 In Review  |   0   |
| ✅ Done       |  14   |
| ❌ Cancelled  |   5   |
| **Total**     | **23** |

<details> <summary>📖 Shortcode Options Reference (click to expand)</summary>
## Shortcode Options Reference

| Field / Command      | Purpose                                           | Accepted Values / Format                                                      |
|----------------------|---------------------------------------------------|--------------------------------------------------------------------------------|
| `(TK)`               | File reference – targets **project‑planning.md**  | —                                                                              |
| **Task IDs**         | Specify which task(s) to act on                   | One or more comma‑separated IDs, e.g. `WEC‑30` or `WEC‑30,WEC‑28`              |
| `status=`            | Change a task’s status                            | `Ideas` · `Backlog` · `Todo` · `InProgress` · `InReview` · `Done` · `Cancelled` |
| `priority=`          | Set a task’s priority                             | `Urgent` · `High` · `Medium` · `Low` · `None`                                   |
| `labels=`            | (Over)write a task’s labels                       | Comma‑separated labels, e.g. `Bug,Feature,UX`                                  |
| `comment=`           | Append a comment or summary                       | Freeform string (in quotes if it contains spaces)                             |
| `add-subtask=`       | Add a new sub‑task under the task                  | Sub‑task description                                                           |
| `screenshot=`        | Attach an image URL                               | Any valid URL                                                                  |
| `(new <ID>)`         | Create a brand‑new task with the next sequential ID | e.g. `(TK)(new WEC‑23) title="..." status=Ideas priority=Medium`              |
| `delete`             | Remove the specified task(s)                      | —                                                                              |
| `(overview)`         | Emit the status‑count summary table               | —                                                                              |
</details>


<details>
<summary>💡 Ideas</summary>

- [ ] **WEC-18 – Batch Learner Management** _(Priority: High)_
    - Description: Allow users to add multiple learners at once from a pre-defined list or template.
      Proposed solution: Add a “Select All” option and batch processing.



</details>

<details>
<summary>📥 Backlog</summary>

- [ ] **WEC-32 – Verification issue** _(Priority: Urgent)_
    - Description: ![image.png](https://uploads.linear.app/650f44…4277b7d4-59c7-4238-8b9d-0f3174f24547)
      Under Class Learners section, when I “Select Learners” and add at least one learner, even though I have selected several.

</details>

<details>
<summary>📝 Todo</summary>

- [ ] **WEC-25 – Drag-and-Drop Exception Date Management** _(Priority: Medium)_
    - Description: Allow users to add exception dates by clicking directly on the calendar rather than using the full form.

- [ ] **WEC-31 – Stepped Workflow for Classes** _(Priority: No priority)_
    - Description: Instead of displaying the whole (full) form, break it into steps for better UX.

</details>

<details>
<summary>🚧 In Progress</summary>

_No tasks_

</details>

<details>
<summary>🔍 In Review</summary>

_No tasks_

</details>

<details>
<summary>✅ Done</summary>

- [ ] **WEC-28 – Calendar Export Integration** _(Priority: Medium)_
    - Description: Add functionality to export class schedules to external calendar applications.
      Proposed Solution: Implement iCalendar (.ics) export functionality for bulk export of class schedules with Google Calendar compatibility.

- [ ] **WEC-27 – Class Conflict Detection** _(Priority: Urgent)_
    - Description: Implement a system to detect and warn about potential conflicts when scheduling classes.
      Proposed Solution: Add conflict‑detection logic that checks for overlapping schedules with the same learners, agents, or resources.

- [ ] **WEC-21 – Verification issue** _(Priority: Urgent)_
    - Description: ![image.png](https://uploads.linear.app/650f44…0f3174f24547)
      Under Class Learners section, when I “Select Learners” nothing happens even though learners are selected.

- [ ] **WEC-17 – Improved Calendar Visualization** _(Priority: High)_
    - Description: Enhance the calendar visualization with better visual indicators and responsive layout.

- [ ] **WEC-19 – Advanced Validation Feedback** _(Priority: Urgent)_
    - Description: Provide more detailed and user‑friendly validation error messages with clear visual cues.

- [ ] **WEC-11 – Exception Dates Recalculation** _(Priority: High)_
    - Description: When exception dates are added or removed, the system correctly recalculates recurring schedules.

- [ ] **WEC-24 – This solution makes no sense, as we need to find a way to view attachments and use it inside of “Augment” not the actual WP project** _(Priority: Urgent)_
    - Description: ## Problem
      We need a way to view Linear attachments directly from Augment, not the WP dashboard, and leverage a set of tools for that.

- [ ] **WEC-23 – Page SC** _(Priority: No priority)_
    - Description: ![Screenshot from 2025-04-21 18-03-39.png](https://uploads.linear.app/…)
      Summary of changes in the Page SC component.

- [ ] **WEC-20 – Verification issue** _(Priority: Urgent)_
    - Description: ![image.png](https://uploads.linear.app/650f44…0f3174f24547)
      Under Class Learners section, the update function was not firing correctly.

- [ ] **WEC-15 – Form Validation on Submit** _(Priority: High)_
    - Description: Form validation may still show errors for fields that are actually valid.

- [ ] **WEC-14 – Calendar Text Readability** _(Priority: High)_
    - Description: Text on calendar entries is difficult to read due to poor contrast; fixed by ensuring white text on colored backgrounds.

- [ ] **WEC-13 – Exam Learners Selection Issues** _(Priority: Urgent)_
    - Description: Similar to the class‑learners issue, users receive error notifications about incomplete exam learner selection even when learners are selected.

- [ ] **WEC-12 – Class Learners Selection Issues** _(Priority: Urgent)_
    - Description: Users receive error notifications about incomplete learner selection even when learners have been added.

- [ ] **WEC-10 – Day of Week Restriction** _(Priority: Urgent)_
    - Description: When a day of the week is selected (e.g., Tuesday), ensure consistency between the selected day and the actual date.

</details>

<details>
<summary>❌ Cancelled</summary>

- [ ] **WEC-16 – Calendar Initialization in Tabs** _(Priority: High)_
    - Description: Calendar may not initialize properly when switching tabs.

- [ ] **WEC-22 – Calendar Initialization in Tabs** _(Priority: High)_
    - Description: The calendar doesn’t initialize properly when embedded in certain contexts.

- [ ] **WEC-26 – Recurring Schedule Templates** _(Priority: High)_
    - Description: Allow users to save and reuse common recurring schedule templates.

- [ ] **WEC-29 – Multi-View Calendar Options** _(Priority: High)_
    - Description: Enhance the calendar with additional view options (day, week, month).

- [ ] **WEC-30 – Bulk Class Operations** _(Priority: High)_
    - Description: Add functionality for performing operations on multiple classes at once.

</details>
