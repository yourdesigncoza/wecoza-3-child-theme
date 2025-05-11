# Test-Driven Development Guide for WECOZA-DEV

This guide explains how to implement Test-Driven Development (TDD) in your WECOZA-DEV workflow.

## What is Test-Driven Development?

Test-Driven Development is a software development approach where tests are written before the actual code. The process follows these steps:

1. **Write a Test** - Create a test that defines a function or improvements of a function
2. **Run the Test** - The test should fail because the function isn't implemented yet
3. **Write the Code** - Write the minimum amount of code necessary to pass the test
4. **Run the Test Again** - If the test passes, the code meets the requirements
5. **Refactor** - Clean up the code while ensuring the test still passes

## TDD in the WECOZA-DEV Workflow

### 1. Define Test Criteria First

For each task component in your WEC document, first define the test criteria:

```markdown
- [ ] WEC-XX-1: [Component Name]
  - **Test Criteria (TDD):**
    - Unit tests for [specific functionality]
    - Integration tests for [specific interactions]
    - Edge case tests for [specific scenarios]
    - Acceptance criteria: [measurable outcomes]
  - **Implementation Details:**
    - [Implementation details come after test criteria]
```

### 2. Create a Test Checklist

Before starting implementation, create a comprehensive test checklist:

```markdown
# Test Checklist for [Feature]

## Component: [Component Name]

### Unit Tests
- [ ] Test [specific behavior 1]
- [ ] Test [specific behavior 2]
- [ ] Test edge case: [description]

### Integration Tests
- [ ] Test integration with [other component]
- [ ] Test [specific interaction]
```

### 3. Write the Tests

Implement the tests first. Here's an example in PHPUnit:

```php
public function testHolidayDetectionInDateRange()
{
    // Given a date range containing known holidays
    $startDate = '2025-04-15';
    $endDate = '2025-05-05';
    
    // When we detect holidays in this range
    $holidays = $this->holidayDetector->getHolidaysInRange($startDate, $endDate);
    
    // Then we should find exactly 2 holidays
    $this->assertCount(2, $holidays);
    $this->assertEquals('Good Friday', $holidays[0]['name']);
    $this->assertEquals('Workers\' Day', $holidays[1]['name']);
}
```

### 4. Implement to Make Tests Pass

After writing tests, implement the minimum code needed to make them pass:

```php
public function getHolidaysInRange($startDate, $endDate)
{
    $holidays = [];
    
    // Convert to DateTime objects for comparison
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    
    // Check if Good Friday falls within the range
    $goodFriday = new DateTime('2025-04-18');
    if ($goodFriday >= $start && $goodFriday <= $end) {
        $holidays[] = [
            'date' => '2025-04-18',
            'name' => 'Good Friday'
        ];
    }
    
    // Check if Workers' Day falls within the range
    $workersDay = new DateTime('2025-05-01');
    if ($workersDay >= $start && $workersDay <= $end) {
        $holidays[] = [
            'date' => '2025-05-01',
            'name' => 'Workers\' Day'
        ];
    }
    
    return $holidays;
}
```

### 5. Refactor While Maintaining Tests

Once tests pass, refactor the code for better design, performance, or readability:

```php
public function getHolidaysInRange($startDate, $endDate)
{
    // Convert to DateTime objects for comparison
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    
    // Get all holidays for the year
    $allHolidays = $this->getAllHolidays();
    
    // Filter holidays within the range
    return array_filter($allHolidays, function($holiday) use ($start, $end) {
        $holidayDate = new DateTime($holiday['date']);
        return $holidayDate >= $start && $holidayDate <= $end;
    });
}

private function getAllHolidays()
{
    // This could later be fetched from a database
    return [
        ['date' => '2025-04-18', 'name' => 'Good Friday'],
        ['date' => '2025-05-01', 'name' => 'Workers\' Day'],
        // More holidays...
    ];
}
```

## TDD Benefits in WECOZA-DEV

1. **Clearer Requirements** - Test criteria clarify what the code should do
2. **Better Design** - Writing tests first leads to more modular, testable code
3. **Regression Prevention** - Tests catch issues when changes are made
4. **Documentation** - Tests serve as executable documentation
5. **Confidence** - High test coverage ensures code works as expected

## TDD Status Workflow Integration

TDD directly integrates with the status workflow:

- **Not Started → In Progress**: Transition when you begin writing tests
- **In Progress → Testing**: Transition when implementation is complete and tests pass
- **Testing → Completed**: Transition when all edge cases are covered and code is refactored

## Common TDD Patterns for PHP

### 1. Arrange-Act-Assert

Structure your tests with:
- **Arrange**: Set up the test conditions
- **Act**: Execute the function being tested
- **Assert**: Verify the results

```php
public function testEndDateCalculation()
{
    // Arrange
    $schedule = new ClassSchedule('2025-04-14', 'weekly', 5);
    $calculator = new EndDateCalculator();
    
    // Act
    $endDate = $calculator->calculateEndDate($schedule);
    
    // Assert
    $this->assertEquals('2025-05-19', $endDate);
}
```

### 2. Test Doubles

Use test doubles to isolate the component being tested:

- **Stubs**: Provide predefined responses
- **Mocks**: Verify interactions and method calls
- **Fakes**: Simplified working implementations
- **Spies**: Record calls made during test execution

```php
public function testHolidayOverrideWithMockedRepository()
{
    // Create a mock repository
    $repository = $this->createMock(HolidayRepository::class);
    
    // Configure the mock
    $repository->method('getHolidays')
              ->willReturn([
                  ['date' => '2025-04-18', 'name' => 'Good Friday'],
                  ['date' => '2025-05-01', 'name' => 'Workers\' Day']
              ]);
    
    // Inject the mock
    $detector = new HolidayDetector($repository);
    
    // Test with the mock
    $holidays = $detector->getHolidaysInRange('2025-04-15', '2025-05-05');
    $this->assertCount(2, $holidays);
}
```

### 3. Data Providers

Use data providers for testing multiple cases:

```php
/**
 * @dataProvider schedulePatternProvider
 */
public function testEndDateWithDifferentPatterns($pattern, $occurrences, $expectedEndDate)
{
    $schedule = new ClassSchedule('2025-04-14', $pattern, $occurrences);
    $calculator = new EndDateCalculator();
    
    $endDate = $calculator->calculateEndDate($schedule);
    
    $this->assertEquals($expectedEndDate, $endDate);
}

public function schedulePatternProvider()
{
    return [
        ['weekly', 5, '2025-05-19'],
        ['biweekly', 3, '2025-06-09'],
        ['monthly', 2, '2025-06-16']
    ];
}
```

## Implementing TDD in Existing Projects

1. **Start Small** - Begin with a single component or feature
2. **Increase Coverage Gradually** - Add tests for existing code over time
3. **Use TDD for All New Features** - Apply TDD principles to all new development
4. **Create Test Checklists Retroactively** - Add test plans for existing features

## TDD Resources

- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Test Doubles](https://phpunit.readthedocs.io/en/9.5/test-doubles.html)
- [Mockery](http://docs.mockery.io/en/latest/) - A mock object framework for PHP
- [PHP Testing with Martin Fowler's Patterns](https://martinfowler.com/articles/mocksArentStubs.html)
