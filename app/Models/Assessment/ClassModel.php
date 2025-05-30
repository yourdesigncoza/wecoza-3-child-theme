<?php
/**
 * ClassesModel_beta.php
 *
 * Beta version of ClassModel optimized for the new single-table schema
 * Uses the optimized 'classes' table with JSONB columns instead of separate tables
 */

namespace WeCoza\Models\Assessment;

use WeCoza\Services\Database\DatabaseService;

class ClassModel {
    /**
     * Class properties - mapped to optimized schema
     */
    private $id;
    private $clientId;
    private $siteId;
    private $classAddressLine;
    private $classType;
    private $classSubject;
    private $classCode;
    private $classDuration;
    private $originalStartDate;
    private $setaFunded;
    private $seta;
    private $examClass;
    private $examType;
    private $qaVisitDates;
    private $qaReports = [];
    private $classAgent;
    private $initialClassAgent;
    private $initialAgentStartDate;
    private $projectSupervisorId;
    private $deliveryDate;
    private $learnerIds = [];
    private $backupAgentIds = [];
    private $scheduleData = [];
    private $stopRestartDates = [];
    private $classNotesData = [];
    private $createdAt;
    private $updatedAt;

    /**
     * Constructor
     */
    public function __construct($data = null) {
        if ($data) {
            $this->hydrate($data);
        }
    }

    /**
     * Hydrate model from database row or form data
     */
    private function hydrate($data) {
        // Map database fields to properties
        $this->setId($data['class_id'] ?? $data['id'] ?? null);
        $this->setClientId($data['client_id'] ?? null);
        $this->setSiteId($data['site_id'] ?? null);
        $this->setClassAddressLine($data['class_address_line'] ?? $data['site_address'] ?? null);
        $this->setClassType($data['class_type'] ?? null);
        $this->setClassSubject($data['class_subject'] ?? null);
        $this->setClassCode($data['class_code'] ?? null);
        $this->setClassDuration($data['class_duration'] ?? null);
        $this->setOriginalStartDate($data['original_start_date'] ?? $data['class_start_date'] ?? null);
        $this->setSetaFunded($data['seta_funded'] ?? null);
        $this->setSeta($data['seta'] ?? $data['seta_id'] ?? null);
        $this->setExamClass($data['exam_class'] ?? null);
        $this->setExamType($data['exam_type'] ?? null);
        $this->setQaVisitDates($data['qa_visit_dates'] ?? null);
        $this->setQaReports($this->parseJsonField($data['qa_reports'] ?? []));
        $this->setClassAgent($data['class_agent'] ?? null);
        $this->setInitialClassAgent($data['initial_class_agent'] ?? null);
        $this->setInitialAgentStartDate($data['initial_agent_start_date'] ?? null);
        $this->setProjectSupervisorId($data['project_supervisor_id'] ?? $data['project_supervisor'] ?? null);
        $this->setDeliveryDate($data['delivery_date'] ?? null);
        $this->setCreatedAt($data['created_at'] ?? null);
        $this->setUpdatedAt($data['updated_at'] ?? null);

        // Handle JSONB arrays - support both snake_case and camelCase
        error_log('ClassModel constructor - learner data check:');
        error_log('  learner_ids: ' . (isset($data['learner_ids']) ? print_r($data['learner_ids'], true) : 'NOT SET'));
        error_log('  learnerIds: ' . (isset($data['learnerIds']) ? print_r($data['learnerIds'], true) : 'NOT SET'));
        error_log('  add_learner: ' . (isset($data['add_learner']) ? print_r($data['add_learner'], true) : 'NOT SET'));

        $this->setLearnerIds($this->parseJsonField($data['learner_ids'] ?? $data['learnerIds'] ?? $data['add_learner'] ?? []));
        $this->setBackupAgentIds($this->parseJsonField($data['backup_agent_ids'] ?? $data['backupAgentIds'] ?? $data['backup_agent'] ?? []));
        $this->setScheduleData($this->parseJsonField($data['schedule_data'] ?? $data['scheduleData'] ?? []));
        $this->setStopRestartDates($this->parseJsonField($data['stop_restart_dates'] ?? []));
        $this->setClassNotesData($this->parseJsonField($data['class_notes_data'] ?? $data['classNotes'] ?? $data['class_notes'] ?? []));
    }

    /**
     * Parse JSON field from database or form data
     */
    private function parseJsonField($field) {
        if (is_string($field)) {
            return json_decode($field, true) ?: [];
        }
        return is_array($field) ? $field : [];
    }

    /**
     * Get class by ID
     */
    public static function getById($id) {
        try {
            $db = DatabaseService::getInstance();
            $stmt = $db->query("SELECT * FROM classes WHERE class_id = ?", [$id]);

            if ($row = $stmt->fetch()) {
                return new self($row);
            }

            return null;
        } catch (\Exception $e) {
            error_log('Error fetching class: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save class data to optimized schema
     */
    public function save() {
        error_log('=== ClassModel::save() START ===');
        try {
            $db = DatabaseService::getInstance();
            error_log('Database instance obtained');

            $db->beginTransaction();
            error_log('Transaction started');

            $now = date('Y-m-d H:i:s');
            $this->setCreatedAt($now);
            $this->setUpdatedAt($now);

            // Prepare stop/restart dates as JSONB
            $stopRestartJson = $this->prepareStopRestartDates();
            error_log('Stop/restart dates prepared: ' . $stopRestartJson);

            // Insert into single classes table
            $sql = "INSERT INTO classes (
                client_id, site_id, class_address_line, class_type, class_subject,
                class_code, class_duration, original_start_date, seta_funded, seta,
                exam_class, exam_type, qa_visit_dates, qa_reports, class_agent, initial_class_agent,
                initial_agent_start_date, project_supervisor_id, delivery_date,
                learner_ids, backup_agent_ids, schedule_data, stop_restart_dates,
                class_notes_data, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Debug the specific parameters we're focusing on
            error_log('=== DEBUGGING PARAMETERS [19] and [21] ===');
            error_log('Parameter [19] - BackupAgentIds raw: ' . print_r($this->getBackupAgentIds(), true));
            error_log('Parameter [19] - BackupAgentIds JSON: ' . json_encode($this->getBackupAgentIds()));
            error_log('Parameter [21] - StopRestartDates raw: ' . print_r($this->getStopRestartDates(), true));
            error_log('Parameter [21] - StopRestartJson: ' . $stopRestartJson);

            $params = [
                $this->getClientId(),                               // [0]
                $this->getSiteId(),                                 // [1]
                $this->getClassAddressLine(),                       // [2]
                $this->getClassType(),                              // [3]
                $this->getClassSubject(),                           // [4]
                $this->getClassCode(),                              // [5]
                $this->getClassDuration(),                          // [6]
                $this->getOriginalStartDate(),                      // [7]
                $this->getSetaFunded(),                             // [8]
                $this->getSeta(),                                   // [9]
                $this->getExamClass(),                              // [10]
                $this->getExamType(),                               // [11]
                $this->getQaVisitDates(),                           // [12]
                json_encode($this->getQaReports()),                 // [13] - NEW QA REPORTS
                $this->getClassAgent(),                             // [14]
                $this->getInitialClassAgent(),                      // [15]
                $this->getInitialAgentStartDate(),                  // [16]
                $this->getProjectSupervisorId(),                    // [17]
                $this->getDeliveryDate(),                           // [18]
                json_encode($this->getLearnerIds()),                // [19]
                json_encode($this->getBackupAgentIds()),            // [20] - FOCUS PARAMETER
                json_encode($this->getScheduleData()),              // [21]
                $stopRestartJson,                                   // [22] - FOCUS PARAMETER
                json_encode($this->getClassNotesData()),            // [23]
                $this->getCreatedAt(),                              // [24]
                $this->getUpdatedAt()                               // [25]
            ];

            error_log('Executing SQL: ' . $sql);
            error_log('With params: ' . print_r($params, true));

            $db->query($sql, $params);
            $classId = $db->lastInsertId();
            $this->setId($classId);

            error_log('Class inserted with ID: ' . $classId);

            $db->commit();
            error_log('Transaction committed successfully');
            return true;
        } catch (\Exception $e) {
            error_log('Exception in ClassModel::save(): ' . $e->getMessage());
            error_log('Exception trace: ' . $e->getTraceAsString());
            if ($db->inTransaction()) {
                $db->rollback();
                error_log('Transaction rolled back');
            }
            error_log('Error saving class: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update class data
     */
    public function update() {
        try {
            $db = DatabaseService::getInstance();
            $db->beginTransaction();

            $this->setUpdatedAt(date('Y-m-d H:i:s'));
            $stopRestartJson = $this->prepareStopRestartDates();

            $sql = "UPDATE classes SET
                client_id = ?, site_id = ?, class_address_line = ?, class_type = ?,
                class_subject = ?, class_code = ?, class_duration = ?, original_start_date = ?,
                seta_funded = ?, seta = ?, exam_class = ?, exam_type = ?, qa_visit_dates = ?, qa_reports = ?,
                class_agent = ?, initial_class_agent = ?, initial_agent_start_date = ?,
                project_supervisor_id = ?, delivery_date = ?, learner_ids = ?, backup_agent_ids = ?,
                schedule_data = ?, stop_restart_dates = ?, class_notes_data = ?, updated_at = ?
                WHERE class_id = ?";

            $params = [
                $this->getClientId(), $this->getSiteId(), $this->getClassAddressLine(),
                $this->getClassType(), $this->getClassSubject(), $this->getClassCode(),
                $this->getClassDuration(), $this->getOriginalStartDate(), $this->getSetaFunded(),
                $this->getSeta(), $this->getExamClass(), $this->getExamType(),
                $this->getQaVisitDates(), json_encode($this->getQaReports()), $this->getClassAgent(), $this->getInitialClassAgent(),
                $this->getInitialAgentStartDate(), $this->getProjectSupervisorId(),
                $this->getDeliveryDate(), json_encode($this->getLearnerIds()),
                json_encode($this->getBackupAgentIds()), json_encode($this->getScheduleData()),
                $stopRestartJson, json_encode($this->getClassNotesData()),
                $this->getUpdatedAt(), $this->getId()
            ];

            $db->query($sql, $params);
            $db->commit();
            return true;
        } catch (\Exception $e) {
            if ($db->inTransaction()) {
                $db->rollback();
            }
            error_log('Error updating class: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete class
     */
    public function delete() {
        try {
            $db = DatabaseService::getInstance();
            $db->query("DELETE FROM classes WHERE class_id = ?", [$this->getId()]);
            return true;
        } catch (\Exception $e) {
            error_log('Error deleting class: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Prepare stop/restart dates for JSONB storage
     */
    private function prepareStopRestartDates() {
        $stopDates = $this->getStopDates();
        $restartDates = $this->getRestartDates();
        $combined = [];

        if (!empty($stopDates) && !empty($restartDates)) {
            for ($i = 0; $i < max(count($stopDates), count($restartDates)); $i++) {
                if (!empty($stopDates[$i]) || !empty($restartDates[$i])) {
                    $combined[] = [
                        'stop_date' => $stopDates[$i] ?? null,
                        'restart_date' => $restartDates[$i] ?? null
                    ];
                }
            }
        }

        return json_encode($combined);
    }

    // Getters and Setters for all properties
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }

    public function getClientId() { return $this->clientId; }
    public function setClientId($clientId) {
        $this->clientId = is_numeric($clientId) ? intval($clientId) : null;
        return $this;
    }

    public function getSiteId() { return $this->siteId; }
    public function setSiteId($siteId) {
        $this->siteId = is_string($siteId) || is_numeric($siteId) ? $siteId : null;
        return $this;
    }

    public function getClassAddressLine() { return $this->classAddressLine; }
    public function setClassAddressLine($classAddressLine) { $this->classAddressLine = $classAddressLine; return $this; }

    public function getClassType() { return $this->classType; }
    public function setClassType($classType) { $this->classType = $classType; return $this; }

    public function getClassSubject() { return $this->classSubject; }
    public function setClassSubject($classSubject) { $this->classSubject = $classSubject; return $this; }

    public function getClassCode() { return $this->classCode; }
    public function setClassCode($classCode) { $this->classCode = $classCode; return $this; }

    public function getClassDuration() { return $this->classDuration; }
    public function setClassDuration($classDuration) { $this->classDuration = $classDuration; return $this; }

    public function getOriginalStartDate() { return $this->originalStartDate; }
    public function setOriginalStartDate($originalStartDate) { $this->originalStartDate = $originalStartDate; return $this; }

    public function getSetaFunded() { return $this->setaFunded; }
    public function setSetaFunded($setaFunded) {
        // Convert Yes/No to boolean for database
        if ($setaFunded === 'Yes') {
            $this->setaFunded = true;
        } elseif ($setaFunded === 'No') {
            $this->setaFunded = false;
        } else {
            $this->setaFunded = is_bool($setaFunded) ? $setaFunded : null;
        }
        return $this;
    }

    public function getSeta() { return $this->seta; }
    public function setSeta($seta) {
        $this->seta = is_string($seta) ? $seta : null;
        return $this;
    }

    public function getExamClass() { return $this->examClass; }
    public function setExamClass($examClass) {
        // Convert Yes/No to boolean for database
        if ($examClass === 'Yes') {
            $this->examClass = true;
        } elseif ($examClass === 'No') {
            $this->examClass = false;
        } else {
            $this->examClass = is_bool($examClass) ? $examClass : null;
        }
        return $this;
    }

    public function getExamType() { return $this->examType; }
    public function setExamType($examType) { $this->examType = $examType; return $this; }

    public function getQaVisitDates() { return $this->qaVisitDates; }
    public function setQaVisitDates($qaVisitDates) { $this->qaVisitDates = $qaVisitDates; return $this; }

    public function getQaReports() { return $this->qaReports; }
    public function setQaReports($qaReports) { $this->qaReports = is_array($qaReports) ? $qaReports : []; return $this; }

    public function getClassAgent() { return $this->classAgent; }
    public function setClassAgent($classAgent) {
        $this->classAgent = is_numeric($classAgent) ? intval($classAgent) : null;
        return $this;
    }

    public function getInitialClassAgent() { return $this->initialClassAgent; }
    public function setInitialClassAgent($initialClassAgent) {
        $this->initialClassAgent = is_numeric($initialClassAgent) ? intval($initialClassAgent) : null;
        return $this;
    }

    public function getInitialAgentStartDate() { return $this->initialAgentStartDate; }
    public function setInitialAgentStartDate($initialAgentStartDate) {
        $this->initialAgentStartDate = is_string($initialAgentStartDate) ? $initialAgentStartDate : null;
        return $this;
    }

    public function getProjectSupervisorId() { return $this->projectSupervisorId; }
    public function setProjectSupervisorId($projectSupervisorId) {
        $this->projectSupervisorId = is_numeric($projectSupervisorId) ? intval($projectSupervisorId) : null;
        return $this;
    }

    public function getDeliveryDate() { return $this->deliveryDate; }
    public function setDeliveryDate($deliveryDate) { $this->deliveryDate = $deliveryDate; return $this; }

    public function getLearnerIds() { return $this->learnerIds; }
    public function setLearnerIds($learnerIds) { $this->learnerIds = is_array($learnerIds) ? $learnerIds : []; return $this; }

    public function getBackupAgentIds() { return $this->backupAgentIds; }
    public function setBackupAgentIds($backupAgentIds) { $this->backupAgentIds = is_array($backupAgentIds) ? $backupAgentIds : []; return $this; }

    public function getScheduleData() { return $this->scheduleData; }
    public function setScheduleData($scheduleData) { $this->scheduleData = is_array($scheduleData) ? $scheduleData : []; return $this; }

    public function getStopRestartDates() { return $this->stopRestartDates; }
    public function setStopRestartDates($stopRestartDates) { $this->stopRestartDates = is_array($stopRestartDates) ? $stopRestartDates : []; return $this; }

    // Helper methods for stop/restart dates (for backward compatibility)
    public function getStopDates() {
        return array_column($this->stopRestartDates, 'stop_date');
    }

    public function setStopDates($stopDates) {
        // This will be handled by prepareStopRestartDates()
        return $this;
    }

    public function getRestartDates() {
        return array_column($this->stopRestartDates, 'restart_date');
    }

    public function setRestartDates($restartDates) {
        // This will be handled by prepareStopRestartDates()
        return $this;
    }

    public function getClassNotesData() { return $this->classNotesData; }
    public function setClassNotesData($classNotesData) { $this->classNotesData = is_array($classNotesData) ? $classNotesData : []; return $this; }

    public function getCreatedAt() { return $this->createdAt; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; return $this; }

    public function getUpdatedAt() { return $this->updatedAt; }
    public function setUpdatedAt($updatedAt) { $this->updatedAt = $updatedAt; return $this; }

    /**
     * Get validation rules for class data - DEPRECATED
     * Server-side validation has been removed. All validation is handled on the frontend.
     * This method is kept for backward compatibility but returns empty array.
     */
    public static function getValidationRules() {
        // Server-side validation disabled - using frontend validation only
        return [];
    }

    /**
     * Validate class data - DEPRECATED
     * Server-side validation has been removed. All validation is handled on the frontend.
     * This method always returns true for backward compatibility.
     */
    public static function validate($data) {
        // Server-side validation disabled - using frontend validation only
        return true;
    }

    /**
     * Get all classes (for listing)
     */
    public static function getAll($limit = null, $offset = 0) {
        try {
            $db = DatabaseService::getInstance();
            $sql = "SELECT * FROM classes ORDER BY created_at DESC";

            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
                $stmt = $db->query($sql, [$limit, $offset]);
            } else {
                $stmt = $db->query($sql);
            }

            $classes = [];
            while ($row = $stmt->fetch()) {
                $classes[] = new self($row);
            }

            return $classes;
        } catch (\Exception $e) {
            error_log('Error fetching classes: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Search classes by criteria
     */
    public static function search($criteria = []) {
        try {
            $db = DatabaseService::getInstance();
            $where = [];
            $params = [];

            if (!empty($criteria['client_id'])) {
                $where[] = "client_id = ?";
                $params[] = $criteria['client_id'];
            }

            if (!empty($criteria['class_type'])) {
                $where[] = "class_type = ?";
                $params[] = $criteria['class_type'];
            }

            if (!empty($criteria['class_agent'])) {
                $where[] = "class_agent = ?";
                $params[] = $criteria['class_agent'];
            }

            $sql = "SELECT * FROM classes";
            if (!empty($where)) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            $sql .= " ORDER BY created_at DESC";

            $stmt = $db->query($sql, $params);
            $classes = [];

            while ($row = $stmt->fetch()) {
                $classes[] = new self($row);
            }

            return $classes;
        } catch (\Exception $e) {
            error_log('Error searching classes: ' . $e->getMessage());
            return [];
        }
    }
}
