<?php
/**
 * ClassTypesController.php
 *
 * Controller for handling class types and durations
 */

namespace WeCoza\Controllers;

class ClassTypesController {
    /**
     * Get all class types (main categories)
     *
     * @return array List of class types
     */
    public static function getClassTypes() {
        return [
            ['id' => 'AET', 'name' => 'AET Communication & Numeracy'],
            ['id' => 'GETC', 'name' => 'GETC AET'],
            ['id' => 'REALLL', 'name' => 'REALLL'],
            ['id' => 'BA', 'name' => 'Business Admin'],
            ['id' => 'SKILL', 'name' => 'Skill Packages'],
            ['id' => 'SOFT', 'name' => 'Soft Skill Courses'],
        ];
    }

    /**
     * Get all class subjects based on class type
     *
     * @param string $classTypeId Class type ID
     * @return array List of subjects for the given class type
     */
    public static function getClassSubjects($classTypeId = '') {
        $allSubjects = [
            'AET' => [
                ['id' => 'CL1B', 'name' => 'Communication level 1 Basic', 'duration' => 120],
                ['id' => 'CL1', 'name' => 'Communication level 1', 'duration' => 120],
                ['id' => 'CL2', 'name' => 'Communication level 2', 'duration' => 120],
                ['id' => 'CL3', 'name' => 'Communication level 3', 'duration' => 120],
                ['id' => 'CL4', 'name' => 'Communication level 4', 'duration' => 120],
                ['id' => 'NL1B', 'name' => 'Numeracy level 1 Basic', 'duration' => 120],
                ['id' => 'NL1', 'name' => 'Numeracy level 1', 'duration' => 120],
                ['id' => 'NL2', 'name' => 'Numeracy level 2', 'duration' => 120],
                ['id' => 'NL3', 'name' => 'Numeracy level 3', 'duration' => 120],
                ['id' => 'NL4', 'name' => 'Numeracy level 4', 'duration' => 120],
            ],
            'GETC' => [
                ['id' => 'CL4', 'name' => 'Communication level 4', 'duration' => 120],
                ['id' => 'NL4', 'name' => 'Numeracy level 4', 'duration' => 120],
                ['id' => 'LO4', 'name' => 'Life Orientation level 4', 'duration' => 90],
                ['id' => 'HSS4', 'name' => 'Human & Social Sciences level 4', 'duration' => 80],
                ['id' => 'EMS4', 'name' => 'Economic & Management Sciences level 4', 'duration' => 94],
                ['id' => 'NS4', 'name' => 'Natural Sciences level 4', 'duration' => 60],
                ['id' => 'SMME4', 'name' => 'Small Micro Medium Enterprises level 4', 'duration' => 60],
            ],
            'REALLL' => [
                ['id' => 'RLC', 'name' => 'Communication', 'duration' => 160],
                ['id' => 'RLN', 'name' => 'Numeracy', 'duration' => 160],
                ['id' => 'RLF', 'name' => 'Finance', 'duration' => 40],
            ],
            'BA' => [
                // NQF 2
                ['id' => 'BA2LP9', 'name' => 'Business Admin (NQF 2) LP9', 'duration' => 80],
                ['id' => 'BA2LP10', 'name' => 'Business Admin (NQF 2) LP10', 'duration' => 64],
                ['id' => 'BA2LP1', 'name' => 'Business Admin (NQF 2) LP1', 'duration' => 72],
                ['id' => 'BA2LP2', 'name' => 'Business Admin (NQF 2) LP2', 'duration' => 56],
                ['id' => 'BA2LP3', 'name' => 'Business Admin (NQF 2) LP3', 'duration' => 40],
                ['id' => 'BA2LP4', 'name' => 'Business Admin (NQF 2) LP4', 'duration' => 20],
                ['id' => 'BA2LP5', 'name' => 'Business Admin (NQF 2) LP5', 'duration' => 56],
                ['id' => 'BA2LP6', 'name' => 'Business Admin (NQF 2) LP6', 'duration' => 60],
                ['id' => 'BA2LP7', 'name' => 'Business Admin (NQF 2) LP7', 'duration' => 40],
                ['id' => 'BA2LP8', 'name' => 'Business Admin (NQF 2) LP8', 'duration' => 32],
                // NQF 3
                ['id' => 'BA3LP2', 'name' => 'Business Admin (NQF 3) LP2', 'duration' => 52],
                ['id' => 'BA3LP4', 'name' => 'Business Admin (NQF 3) LP4', 'duration' => 40],
                ['id' => 'BA3LP5', 'name' => 'Business Admin (NQF 3) LP5', 'duration' => 36],
                ['id' => 'BA3LP6', 'name' => 'Business Admin (NQF 3) LP6', 'duration' => 44],
                ['id' => 'BA3LP1', 'name' => 'Business Admin (NQF 3) LP1', 'duration' => 60],
                ['id' => 'BA3LP7', 'name' => 'Business Admin (NQF 3) LP7', 'duration' => 40],
                ['id' => 'BA3LP8', 'name' => 'Business Admin (NQF 3) LP8', 'duration' => 44],
                ['id' => 'BA3LP9', 'name' => 'Business Admin (NQF 3) LP9', 'duration' => 28],
                ['id' => 'BA3LP10', 'name' => 'Business Admin (NQF 3) LP10', 'duration' => 48],
                ['id' => 'BA3LP11', 'name' => 'Business Admin (NQF 3) LP11', 'duration' => 36],
                ['id' => 'BA3LP3', 'name' => 'Business Admin (NQF 3) LP3', 'duration' => 44],
                // NQF 4
                ['id' => 'BA4LP2', 'name' => 'Business Admin (NQF 4) LP2', 'duration' => 104],
                ['id' => 'BA4LP3', 'name' => 'Business Admin (NQF 4) LP3', 'duration' => 80],
                ['id' => 'BA4LP4', 'name' => 'Business Admin (NQF 4) LP4', 'duration' => 64],
                ['id' => 'BA4LP1', 'name' => 'Business Admin (NQF 4) LP1', 'duration' => 88],
                ['id' => 'BA4LP6', 'name' => 'Business Admin (NQF 4) LP6', 'duration' => 84],
                ['id' => 'BA4LP5', 'name' => 'Business Admin (NQF 4) LP5', 'duration' => 76],
                ['id' => 'BA4LP7', 'name' => 'Business Admin (NQF 4) LP7', 'duration' => 88],
            ],
            'SKILL' => [
                ['id' => 'WALK', 'name' => 'Walk Package', 'duration' => 120],
                ['id' => 'HEXA', 'name' => 'Hexa Package', 'duration' => 120],
                ['id' => 'RUN', 'name' => 'Run Package', 'duration' => 120],
            ],
            'SOFT' => [
                ['id' => 'IPC', 'name' => 'Introduction to Computers', 'duration' => 20],
                ['id' => 'EQ', 'name' => 'Email Etiquette', 'duration' => 6],
                ['id' => 'TM', 'name' => 'Time Management', 'duration' => 12],
                ['id' => 'SS', 'name' => 'Supervisory Skills', 'duration' => 40],
                ['id' => 'EEPDL', 'name' => 'EEP Digital Literacy', 'duration' => 40],
                ['id' => 'EEPPF', 'name' => 'EEP Personal Finance', 'duration' => 40],
                ['id' => 'EEPWI', 'name' => 'EEP Workplace Intelligence', 'duration' => 40],
                ['id' => 'EEPEI', 'name' => 'EEP Emotional Intelligence', 'duration' => 40],
                ['id' => 'EEPBI', 'name' => 'EEP Business Intelligence', 'duration' => 40],
            ],
        ];

        // If no class type specified, return all subjects
        if (empty($classTypeId)) {
            return $allSubjects;
        }

        // Return subjects for the specified class type
        return isset($allSubjects[$classTypeId]) ? $allSubjects[$classTypeId] : [];
    }

    /**
     * Get class duration by subject ID
     *
     * @param string $subjectId Subject ID
     * @return int Duration in hours
     */
    public static function getClassDuration($subjectId) {
        $allSubjects = self::getClassSubjects();
        
        // Flatten the array of subjects
        $subjects = [];
        foreach ($allSubjects as $typeSubjects) {
            $subjects = array_merge($subjects, $typeSubjects);
        }
        
        // Find the subject by ID
        foreach ($subjects as $subject) {
            if ($subject['id'] === $subjectId) {
                return $subject['duration'];
            }
        }
        
        // Default duration if subject not found
        return 120;
    }
}
