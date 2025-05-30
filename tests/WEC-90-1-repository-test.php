<?php
/**
 * WEC-90-1 Repository Pattern Test
 *
 * Basic test to verify the repository pattern implementation works correctly
 * This test can be run to validate the data layer optimization
 */

// Include WordPress and theme bootstrap
require_once __DIR__ . '/../app/bootstrap.php';

use WeCoza\Repositories\ClassRepository;
use WeCoza\Services\ClassService;
use WeCoza\Validators\ClassValidator;

class RepositoryPatternTest {
    
    private $repository;
    private $service;
    private $validator;
    
    public function __construct() {
        $this->repository = new ClassRepository();
        $this->validator = new ClassValidator();
        $this->service = new ClassService($this->repository, $this->validator);
    }
    
    /**
     * Run all tests
     */
    public function runTests() {
        echo "=== WEC-90-1 Repository Pattern Tests ===\n\n";
        
        $this->testRepositoryInstantiation();
        $this->testServiceInstantiation();
        $this->testValidatorInstantiation();
        $this->testRepositoryMethods();
        $this->testServiceMethods();
        $this->testValidation();
        
        echo "\n=== All Tests Completed ===\n";
    }
    
    /**
     * Test repository instantiation
     */
    private function testRepositoryInstantiation() {
        echo "Testing Repository Instantiation...\n";
        
        if ($this->repository instanceof ClassRepository) {
            echo "✅ ClassRepository instantiated successfully\n";
        } else {
            echo "❌ ClassRepository instantiation failed\n";
        }
        
        echo "\n";
    }
    
    /**
     * Test service instantiation
     */
    private function testServiceInstantiation() {
        echo "Testing Service Instantiation...\n";
        
        if ($this->service instanceof ClassService) {
            echo "✅ ClassService instantiated successfully\n";
        } else {
            echo "❌ ClassService instantiation failed\n";
        }
        
        echo "\n";
    }
    
    /**
     * Test validator instantiation
     */
    private function testValidatorInstantiation() {
        echo "Testing Validator Instantiation...\n";
        
        if ($this->validator instanceof ClassValidator) {
            echo "✅ ClassValidator instantiated successfully\n";
        } else {
            echo "❌ ClassValidator instantiation failed\n";
        }
        
        echo "\n";
    }
    
    /**
     * Test repository methods
     */
    private function testRepositoryMethods() {
        echo "Testing Repository Methods...\n";
        
        // Test method existence
        $methods = ['findById', 'findAll', 'create', 'update', 'delete', 'exists', 'count'];
        
        foreach ($methods as $method) {
            if (method_exists($this->repository, $method)) {
                echo "✅ Repository method '{$method}' exists\n";
            } else {
                echo "❌ Repository method '{$method}' missing\n";
            }
        }
        
        // Test findAll method (should not throw errors)
        try {
            $classes = $this->repository->findAll();
            echo "✅ Repository findAll() executed successfully (returned " . count($classes) . " classes)\n";
        } catch (Exception $e) {
            echo "❌ Repository findAll() failed: " . $e->getMessage() . "\n";
        }
        
        echo "\n";
    }
    
    /**
     * Test service methods
     */
    private function testServiceMethods() {
        echo "Testing Service Methods...\n";
        
        // Test method existence
        $methods = ['createClass', 'updateClass', 'getClass', 'getAllClasses', 'deleteClass'];
        
        foreach ($methods as $method) {
            if (method_exists($this->service, $method)) {
                echo "✅ Service method '{$method}' exists\n";
            } else {
                echo "❌ Service method '{$method}' missing\n";
            }
        }
        
        // Test getAllClasses method
        try {
            $classes = $this->service->getAllClasses();
            echo "✅ Service getAllClasses() executed successfully (returned " . count($classes) . " classes)\n";
        } catch (Exception $e) {
            echo "❌ Service getAllClasses() failed: " . $e->getMessage() . "\n";
        }
        
        echo "\n";
    }
    
    /**
     * Test validation
     */
    private function testValidation() {
        echo "Testing Validation...\n";
        
        // Test valid data
        $validData = [
            'client_id' => 1,
            'site_id' => 1,
            'class_type' => 'Test Type',
            'class_subject' => 'Test Subject',
            'original_start_date' => '2024-12-01',
            'class_duration' => 40,
            'seta_funded' => 'true',
            'seta' => 'Test SETA',
            'exam_class' => 'true',
            'exam_type' => 'Practical'
        ];
        
        if ($this->validator->validateCreate($validData)) {
            echo "✅ Valid data passed validation\n";
        } else {
            echo "❌ Valid data failed validation: " . $this->validator->getErrorMessages() . "\n";
        }
        
        // Test invalid data
        $invalidData = [
            'client_id' => '', // Missing required field
            'class_type' => 'Test Type',
            'original_start_date' => 'invalid-date'
        ];
        
        if (!$this->validator->validateCreate($invalidData)) {
            echo "✅ Invalid data correctly failed validation\n";
        } else {
            echo "❌ Invalid data incorrectly passed validation\n";
        }
        
        echo "\n";
    }
}

// Run the tests if this file is executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    try {
        $test = new RepositoryPatternTest();
        $test->runTests();
    } catch (Exception $e) {
        echo "❌ Test execution failed: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
}
