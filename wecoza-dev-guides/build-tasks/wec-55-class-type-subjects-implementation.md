# WEC-55: Class Type should Match Subjects

## Implementation Summary

This task involved updating the class types and subjects based on Mario's feedback to ensure that when a specific class type is selected, the correct class subjects are displayed.

## Changes Made

1. **Updated AET Communication & Numeracy**
   - Simplified to only 3 options as requested:
     - Communication (separate)
     - Numeracy (separate)
     - Communication & Numeracy (both)
   - The levels will now be handled per learner rather than per class

2. **Split Business Admin into Three Separate Class Types**
   - Business Admin NQF 2
   - Business Admin NQF 3
   - Business Admin NQF 4
   - Organized the subjects accordingly under each type
   - Simplified subject names to just show the LP number

3. **Kept Other Class Types As Is**
   - GETC AET - No changes needed
   - REALLL - No changes needed
   - Skill Packages - No changes needed
   - Soft Skill Courses - No changes needed

## Technical Implementation

The implementation involved updating the `ClassTypesController.php` file:

1. Modified the `getClassTypes()` method to:
   - Update the AET class type name
   - Split Business Admin into three separate class types

2. Modified the `getClassSubjects()` method to:
   - Update the AET subjects to only include the three options specified
   - Split the Business Admin subjects into three separate categories
   - Simplified the subject names for better readability

## Files Modified

- `app/Controllers/ClassTypesController.php`

## Futher Reference

=== Class Types ===
AET: AET Communication & Numeracy
GETC: GETC AET
REALLL: REALLL
BA2: Business Admin NQF 2
BA3: Business Admin NQF 3
BA4: Business Admin NQF 4
SKILL: Skill Packages
SOFT: Soft Skill Courses

=== Class Subjects ===

AET Communication & Numeracy Subjects:
  COMM: Communication (separate) (120 hours)
  NUM: Numeracy (separate) (120 hours)
  BOTH: Communication & Numeracy (both) (240 hours)

GETC AET Subjects:
  CL4: Communication level 4 (120 hours)
  NL4: Numeracy level 4 (120 hours)
  LO4: Life Orientation level 4 (90 hours)
  HSS4: Human & Social Sciences level 4 (80 hours)
  EMS4: Economic & Management Sciences level 4 (94 hours)
  NS4: Natural Sciences level 4 (60 hours)
  SMME4: Small Micro Medium Enterprises level 4 (60 hours)

REALLL Subjects:
  RLC: Communication (160 hours)
  RLN: Numeracy (160 hours)
  RLF: Finance (40 hours)

Business Admin NQF 2 Subjects:
  BA2LP9: LP9 (80 hours)
  BA2LP10: LP10 (64 hours)
  BA2LP1: LP1 (72 hours)
  BA2LP2: LP2 (56 hours)
  BA2LP3: LP3 (40 hours)
  BA2LP4: LP4 (20 hours)
  BA2LP5: LP5 (56 hours)
  BA2LP6: LP6 (60 hours)
  BA2LP7: LP7 (40 hours)
  BA2LP8: LP8 (32 hours)

Business Admin NQF 3 Subjects:
  BA3LP2: LP2 (52 hours)
  BA3LP4: LP4 (40 hours)
  BA3LP5: LP5 (36 hours)
  BA3LP6: LP6 (44 hours)
  BA3LP1: LP1 (60 hours)
  BA3LP7: LP7 (40 hours)
  BA3LP8: LP8 (44 hours)
  BA3LP9: LP9 (28 hours)
  BA3LP10: LP10 (48 hours)
  BA3LP11: LP11 (36 hours)
  BA3LP3: LP3 (44 hours)

Business Admin NQF 4 Subjects:
  BA4LP2: LP2 (104 hours)
  BA4LP3: LP3 (80 hours)
  BA4LP4: LP4 (64 hours)
  BA4LP1: LP1 (88 hours)
  BA4LP6: LP6 (84 hours)
  BA4LP5: LP5 (76 hours)
  BA4LP7: LP7 (88 hours)

Skill Packages Subjects:
  WALK: Walk Package (120 hours)
  HEXA: Hexa Package (120 hours)
  RUN: Run Package (120 hours)

Soft Skill Courses Subjects:
  IPC: Introduction to Computers (20 hours)
  EQ: Email Etiquette (6 hours)
  TM: Time Management (12 hours)
  SS: Supervisory Skills (40 hours)
  EEPDL: EEP Digital Literacy (40 hours)
  EEPPF: EEP Personal Finance (40 hours)
  EEPWI: EEP Workplace Intelligence (40 hours)
  EEPEI: EEP Emotional Intelligence (40 hours)
  EEPBI: EEP Business Intelligence (40 hours)

## Testing

The changes were tested by:
1. Creating a test script to verify the updated class types and subjects
2. Confirming that the correct subjects are displayed for each class type
3. Verifying that the existing functionality for duration calculation and class code generation still works

## Future Considerations

As noted by Mario, we should consider how to handle learner progression through different subjects within a class, particularly for GETC AET where learners start with one subject and progress to others. This will require tracking the history of subjects per learner.

## Related Issues

- This task is related to the overall class management system
- Future work may be needed to implement the per-learner level selection for AET classes
