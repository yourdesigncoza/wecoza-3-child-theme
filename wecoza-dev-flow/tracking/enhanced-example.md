# Public Holiday Override Feature

## Description
Implement a feature that allows users to selectively override public holidays when scheduling classes. Currently, the system automatically excludes public holidays from class schedules, but some clients occasionally need to conduct training on specific public holidays.

This feature will provide a user interface to:
1. Detect when a class schedule includes public holidays
2. Prompt users with options to include or exclude specific public holidays
3. Visually indicate in the calendar which public holidays have been overridden
4. Adjust end date calculations accordingly

As shown in the UI:
- A notification or prompt when scheduling classes that overlap with public holidays
- A list of affected public holidays with checkboxes to include/exclude each one
- Visual indicators in the calendar for overridden public holidays (different styling)
- Updated class schedule information reflecting the overrides

## Implementation Sequence
1. First implement WEC-50-1 (Public Holiday Conflict Detection) - This provides the foundation for identifying holidays in schedules
2. Then implement WEC-50-3 (Data Storage for Holiday Overrides) - This creates the data structure needed for overrides
3. Next implement WEC-50-2 (Public Holiday Override UI) - UI depends on both detection and data structure
4. Then implement WEC-50-4 (End Date Calculation Updates) - Relies on all previous components
5. Next implement WEC-50-5 (Calendar Visualization Enhancements) - Builds on all previous components
6. Finally implement WEC-50-6 (Testing and Documentation) - Comprehensive testing of the complete feature

## Subtasks

- [ ] WEC-50-1: Public Holiday Conflict Detection
  - **Test Criteria (TDD):**
    - Unit tests for detecting holidays within a date range
    - Tests for conflict detection with various scheduling patterns (weekly, biweekly, monthly)
    - Edge case tests for schedules that start or end exactly on holidays
    - Acceptance criteria: System correctly identifies all holidays in any given date range
  - **Implementation Details:**
    - Enhance the class scheduling form to detect when selected dates include public holidays
    - Create a mechanism to identify all public holidays within a class schedule date range
    - Add conflict detection to both initial scheduling and rescheduling workflows
    - Implement detection for all scheduling patterns (weekly, biweekly, monthly)
    - Add appropriate hooks for the conflict resolution UI
  - **Status Transitions:**
    - Not Started → In Progress: When tests for holiday detection are created
    - In Progress → Testing: When detection implementation is complete
    - Testing → Completed: When all detection tests pass and edge cases are handled

- [ ] WEC-50-2: Public Holiday Override UI
  - **Test Criteria (TDD):**
    - Unit tests for UI component rendering with various holiday lists
    - Tests for checkbox state management and event handling
    - Integration tests for UI interaction with the detection system
    - Acceptance criteria: UI clearly displays all detected holidays with working override controls
  - **Implementation Details:**
    - Create a modal dialog that appears when public holidays are detected in a schedule
    - List all affected public holidays with name, date, and override checkbox
    - Add "Override All" and "Skip All" convenience buttons
    - Implement "Remember my choice" option for the current session
    - Design clear, user-friendly messaging explaining the implications of overrides
  - **Status Transitions:**
    - Not Started → In Progress: When UI component tests are created
    - In Progress → Testing: When UI implementation is complete
    - Testing → Completed: When all UI tests pass and user experience is verified

- [ ] WEC-50-3: Data Storage for Holiday Overrides
  - **Test Criteria (TDD):**
    - Unit tests for data format validation
    - Tests for saving and loading override data
    - Tests for data integrity with various combinations of overrides
    - Acceptance criteria: Override data is correctly stored and retrieved with the class schedule
  - **Implementation Details:**
    - Extend the class schedule data structure to store holiday override information
    - Create a data format that records which specific holidays are overridden
    - Implement database schema updates if needed
    - Ensure overrides are properly saved with the class schedule
    - Add data validation and sanitization for the override data
  - **Status Transitions:**
    - Not Started → In Progress: When data structure tests are created
    - In Progress → Testing: When data storage implementation is complete
    - Testing → Completed: When all data persistence tests pass

- [ ] WEC-50-4: End Date Calculation Updates
  - **Test Criteria (TDD):**
    - Unit tests for end date calculation with various override combinations
    - Tests for date calculation with different scheduling patterns
    - Edge case tests for schedules with all holidays overridden or none overridden
    - Acceptance criteria: End dates are correctly calculated accounting for overridden holidays
  - **Implementation Details:**
    - Modify the end date calculation logic to account for holiday overrides
    - Update the `recalculateEndDate()` function to check for overridden holidays
    - Ensure the `isExceptionDate()` function respects holiday overrides
    - Test with various scheduling patterns and override combinations
    - Verify correct end date calculation with partial holiday overrides
  - **Status Transitions:**
    - Not Started → In Progress: When calculation tests are created
    - In Progress → Testing: When calculation implementation is complete
    - Testing → Completed: When all calculation tests pass with various scenarios

- [ ] WEC-50-5: Calendar Visualization Enhancements
  - **Test Criteria (TDD):**
    - Unit tests for calendar event rendering with overridden holidays
    - Tests for correct styling application
    - Visual tests for different calendar views (month, week, day)
    - Acceptance criteria: Overridden holidays are visually distinct and properly labeled
  - **Implementation Details:**
    - Create distinct visual styling for overridden public holidays in the calendar
    - Update the calendar event rendering to show special status for overridden holidays
    - Add tooltip information explaining that a holiday has been overridden
    - Ensure the calendar legend includes the new override status
    - Test visualization across different calendar views (month, week, day)
  - **Status Transitions:**
    - Not Started → In Progress: When visualization tests are created
    - In Progress → Testing: When calendar enhancements are implemented
    - Testing → Completed: When all visualization tests pass across different views

- [ ] WEC-50-6: Testing and Documentation
  - **Test Criteria (TDD):**
    - Integration tests for the complete feature workflow
    - Performance tests to ensure no significant slowdowns
    - User acceptance test criteria and scenarios
    - Acceptance criteria: Feature is fully documented and passes all integration tests
  - **Implementation Details:**
    - Create comprehensive test cases for the override feature
    - Test with various scheduling patterns and holiday combinations
    - Document the feature for end users
    - Update developer documentation
    - Create visual guides for the override workflow
  - **Status Transitions:**
    - Not Started → In Progress: When test plan is created
    - In Progress → Testing: When all tests are implemented
    - Testing → Completed: When documentation is complete and all tests pass

## Files
- `app/Controllers/PublicHolidaysController.php`
- `app/Controllers/ClassController.php`
- `app/Models/PublicHoliday/PublicHolidayModel.php`
- `app/Models/Class/ClassModel.php`
- `app/Models/Class/ClassScheduleModel.php`
- `public/js/class-schedule-form.js`
- `public/js/class-capture.js`
- `public/js/class-calendar-init.js`
- `includes/css/ydcoza-styles.css`
- `app/Views/class/schedule-form.php`
- `app/Views/class/holiday-override-modal.php` (new file)
- `tests/Unit/PublicHolidayDetectionTest.php` (new file)
- `tests/Unit/HolidayOverrideDataTest.php` (new file)
- `tests/Unit/EndDateCalculationTest.php` (new file)
- `tests/Integration/HolidayOverrideWorkflowTest.php` (new file)

## Related Issues
- WEC-50: Public Holidays Integration
- WEC-87: Public Holidays Implementation

## Technical Approach

### Data Structure
We'll extend the class schedule data to include holiday override information:
```json
{
  "holiday_overrides": [
    {
      "date": "2025-04-18",
      "name": "Good Friday",
      "override": true
    },
    {
      "date": "2025-05-01",
      "name": "Workers' Day",
      "override": false
    }
  ]
}
```

### Test-First Implementation Plan

#### 1. Public Holiday Detection Tests
```php
public function testHolidayDetectionInDateRange()
{
    // Given a date range containing known holidays
    $startDate = '2025-04-15';
    $endDate = '2025-05-05';
    
    // When we detect holidays in this range
    $holidays = $this->holidayDetector->getHolidaysInRange($startDate, $endDate);
    
    // Then we should find exactly 2 holidays (Good Friday and Workers' Day)
    $this->assertCount(2, $holidays);
    $this->assertEquals('Good Friday', $holidays[0]['name']);
    $this->assertEquals('Workers\' Day', $holidays[1]['name']);
}

public function testNoHolidaysDetected()
{
    // Given a date range with no holidays
    $startDate = '2025-06-01';
    $endDate = '2025-06-07';
    
    // When we detect holidays in this range
    $holidays = $this->holidayDetector->getHolidaysInRange($startDate, $endDate);
    
    // Then we should find no holidays
    $this->assertEmpty($holidays);
}

public function testDetectionWithWeeklyPattern()
{
    // Given a weekly class schedule starting on a specific date
    $startDate = '2025-04-14';
    $pattern = 'weekly';
    $occurrences = 10;
    
    // When we detect holidays in this schedule
    $holidays = $this->holidayDetector->getHolidaysInSchedule($startDate, $pattern, $occurrences);
    
    // Then we should find the correct holidays
    $this->assertCount(2, $holidays);
}
```

#### 2. Data Storage Tests
```php
public function testHolidayOverrideStorageFormat()
{
    // Given a schedule with holiday overrides
    $schedule = new ClassSchedule();
    $overrides = [
        ['date' => '2025-04-18', 'name' => 'Good Friday', 'override' => true],
        ['date' => '2025-05-01', 'name' => 'Workers\' Day', 'override' => false]
    ];
    
    // When we set the holiday overrides
    $schedule->setHolidayOverrides($overrides);
    
    // Then the schedule should store them correctly
    $this->assertEquals($overrides, $schedule->getHolidayOverrides());
}

public function testHolidayOverridePersistence()
{
    // Given a schedule with holiday overrides
    $schedule = new ClassSchedule();
    $overrides = [
        ['date' => '2025-04-18', 'name' => 'Good Friday', 'override' => true]
    ];
    $schedule->setHolidayOverrides($overrides);
    
    // When we save and retrieve the schedule
    $scheduleId = $this->scheduleRepository->save($schedule);
    $retrievedSchedule = $this->scheduleRepository->find($scheduleId);
    
    // Then the overrides should be preserved
    $this->assertEquals($overrides, $retrievedSchedule->getHolidayOverrides());
}
```

#### 3. End Date Calculation Tests
```php
public function testEndDateWithNoOverrides()
{
    // Given a schedule with holidays but no overrides
    $startDate = '2025-04-14';
    $pattern = 'weekly';
    $occurrences = 5;
    $schedule = new ClassSchedule($startDate, $pattern, $occurrences);
    
    // When we calculate the end date
    $endDate = $this->calculator->calculateEndDate($schedule);
    
    // Then the end date should account for holidays (pushing it later)
    $this->assertEquals('2025-05-19', $endDate);
}

public function testEndDateWithAllOverrides()
{
    // Given a schedule with all holidays overridden
    $startDate = '2025-04-14';
    $pattern = 'weekly';
    $occurrences = 5;
    $schedule = new ClassSchedule($startDate, $pattern, $occurrences);
    $schedule->setHolidayOverrides([
        ['date' => '2025-04-18', 'name' => 'Good Friday', 'override' => true],
        ['date' => '2025-05-01', 'name' => 'Workers\' Day', 'override' => true]
    ]);
    
    // When we calculate the end date
    $endDate = $this->calculator->calculateEndDate($schedule);
    
    // Then the end date should not account for holidays (earlier date)
    $this->assertEquals('2025-05-12', $endDate);
}
```

### UI Flow
1. User selects class schedule parameters (start date, pattern, etc.)
2. System detects public holidays in the date range
3. If holidays are detected, system shows override modal
4. User selects which holidays to override (if any)
5. System saves selections and updates the schedule
6. Calendar displays overridden holidays with special styling
