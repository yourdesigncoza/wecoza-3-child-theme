Here’s a complete list of all the form fields (inputs & selects) in `#classes-form`, with their `name`, `type` (or element), and `id` where present:

| name                        | element    | type         | id                                            |
| --------------------------- | ---------- | ------------ | --------------------------------------------- |
| `class_id`                  | `<input>`  | hidden       | `class_id`                                    |
| `redirect_url`              | `<input>`  | hidden       | `redirect_url`                                |
| `nonce`                     | `<input>`  | hidden       | `nonce`                                       |
| `client_id`                 | `<select>` | select       | `client_id`                                   |
| `site_id`                   | `<select>` | select       | `site_id`                                     |
| `site_address`              | `<input>`  | text         | `site_address`                                |
| `class_type`                | `<select>` | select       | `class_type`                                  |
| `class_subject`             | `<select>` | select       | `class_subject`                               |
| `class_duration`            | `<input>`  | number       | `class_duration`                              |
| `class_code`                | `<input>`  | text         | `class_code`                                  |
| `class_start_date`          | `<input>`  | date         | `class_start_date`                            |
| `schedule_pattern`          | `<select>` | select       | `schedule_pattern`                            |
| `schedule_days[]`           | `<input>`  | checkbox     | `schedule_day_monday` … `schedule_day_sunday` |
| `schedule_day_of_month`     | `<select>` | select       | `schedule_day_of_month`                       |
| `schedule_start_time`       | `<select>` | select       | `schedule_start_time`                         |
| `schedule_end_time`         | `<select>` | select       | `schedule_end_time`                           |
| `schedule_duration`         | `<input>`  | text         | `schedule_duration`                           |
| `schedule_start_date`       | `<input>`  | date         | `schedule_start_date`                         |
| `schedule_end_date`         | `<input>`  | date         | `schedule_end_date`                           |
| `schedule_total_hours`      | `<input>`  | text         | *(no id)*                                     |
| `exception_dates[]`         | `<input>`  | date         | *(multiple rows, no id)*                      |
| `exception_reasons[]`       | `<select>` | select       | *(multiple rows, no id)*                      |
| `holiday_overrides`         | `<input>`  | hidden       | `holiday_overrides`                           |
| `add_learner[]`             | `<select>` | multi-select | `add_learner`                                 |
| `class_learners_data`       | `<input>`  | hidden       | `class_learners_data`                         |
| `exam_learner_select[]`     | `<select>` | multi-select | `exam_learner_select`                         |
| `exam_learners`             | `<input>`  | hidden       | `exam_learners`                               |
| `class_notes[]`             | `<select>` | multi-select | `class_notes`                                 |
| `qa_visit_dates[]`          | `<input>`  | date         | *(multiple rows, no id)*                      |
| `qa_reports[]`              | `<input>`  | file         | *(multiple rows, no id)*                      |
| `stop_dates[]`              | `<input>`  | date         | *(template only, no id)*                      |
| `restart_dates[]`           | `<input>`  | date         | *(template only, no id)*                      |
| `initial_class_agent`       | `<select>` | select       | `initial_class_agent`                         |
| `initial_agent_start_date`  | `<input>`  | date         | `initial_agent_start_date`                    |
| `replacement_agent_ids[]`   | `<select>` | select       | *(template only, no id)*                      |
| `replacement_agent_dates[]` | `<input>`  | date         | *(template only, no id)*                      |
| `project_supervisor`        | `<select>` | select       | `project_supervisor`                          |
| `backup_agent_ids[]`        | `<select>` | select       | *(multiple rows, no id)*                      |
| `backup_agent_dates[]`      | `<input>`  | date         | *(multiple rows, no id)*                      |

* `[]` indicates a repeatable/array field.
* Fields inside “template” rows or dynamically added lists share the same `name` but are instantiated multiple times at runtime.
