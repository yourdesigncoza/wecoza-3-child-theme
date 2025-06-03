/**
 * WeCoza Class Code Generator Utility
 *
 * Isolated function for generating unique class codes based on client ID, class type and subject selections.
 * Format: [ClientID]-[ClassType]-[SubjectID]-[YYYY]-[MM]-[DD]-[HH]-[MM]
 *
 * Example output: 11-REALLL-RLN-2025-06-25-02-14
 * Where:
 * - 11 = Client ID
 * - REALLL = Class Type
 * - RLN = Subject ID
 * - 2025-06-25-02-14 = DateTime stamp (YYYY-MM-DD-HH-MM format)
 *
 * @author WeCoza Development Team
 * @version 2.0.0
 */

/**
 * Generate a class code based on client ID, class type and subject
 *
 * @param {string} clientId The selected client ID (e.g., "11")
 * @param {string} classType The selected class type (e.g., "REALLL")
 * @param {string} subjectId The selected subject ID (e.g., "RLN")
 * @return {string} The generated class code (e.g., "11-REALLL-RLN-2025-06-25-02-14")
 */
function generateClassCode(clientId, classType, subjectId) {
    // Format: [ClientID]-[ClassType]-[SubjectID]-[YYYY]-[MM]-[DD]-[HH]-[MM]
    // Example: 11-REALLL-RLN-2025-06-25-02-14
    const now = new Date();

    // Create readable datetime components
    const year = now.getFullYear(); // Full year (2025)
    const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Month (01-12)
    const day = now.getDate().toString().padStart(2, '0'); // Day (01-31)
    const hour = now.getHours().toString().padStart(2, '0'); // Hour (00-23)
    const minute = now.getMinutes().toString().padStart(2, '0'); // Minute (00-59)

    return `${clientId}-${classType}-${subjectId}-${year}-${month}-${day}-${hour}-${minute}`;
}

/**
 * Alternative implementation for server-side PHP usage
 * This can be converted to PHP syntax for backend processing
 *
 * PHP equivalent:
 * function generateClassCode($clientId, $classType, $subjectId) {
 *     $now = new DateTime();
 *
 *     $year = $now->format('Y');
 *     $month = $now->format('m');
 *     $day = $now->format('d');
 *     $hour = $now->format('H');
 *     $minute = $now->format('i');
 *
 *     return $clientId . '-' . $classType . '-' . $subjectId . '-' . $year . '-' . $month . '-' . $day . '-' . $hour . '-' . $minute;
 * }
 */

// Export for module usage (if using ES6 modules)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { generateClassCode };
}

// Make available globally for direct script inclusion
if (typeof window !== 'undefined') {
    window.generateClassCode = generateClassCode;
}
