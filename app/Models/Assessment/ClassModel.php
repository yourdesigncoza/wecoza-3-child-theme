<?php
/**
 * ClassModel.php
 *
 * Model for class/training session data
 */

namespace WeCoza\Models\Assessment;

use WeCoza\Services\Database\DatabaseService;
use WeCoza\Services\Validation\ValidationService;

class ClassModel {
    /**
     * Class properties
     */
    private $id;
    private $clientId;
    private $siteId;
    private $siteAddress;
    private $classType;
    private $classSubject;
    private $classCode;
    private $classDuration;
    private $classStartDate;
    private $courseIds = [];
    private $classNotes = [];
    private $setaFunded;
    private $setaId;
    private $examClass;
    private $examType;
    private $qaVisitDates;
    private $classAgent;
    private $projectSupervisor;
    private $learnerIds = [];
    private $deliveryDate;
    private $backupAgentIds = [];
    private $scheduleData = [];
    private $stopDates = [];
    private $restartDates = [];
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
     * Hydrate model with data
     *
     * @param array $data Data to populate model
     */
    public function hydrate($data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Get class by ID
     *
     * @param int $id Class ID
     * @return ClassModel|null
     */
    public static function getById($id) {
        try {
            $db = DatabaseService::getInstance();
            $stmt = $db->query("SELECT * FROM wecoza_classes WHERE id = ?", [$id]);

            if ($row = $stmt->fetch()) {
                $class = new self($row);

                // Load related data
                $class->loadScheduleData();
                $class->loadStopRestartDates();
                $class->loadLearners();
                $class->loadBackupAgents();
                $class->loadCourses();
                $class->loadClassNotes();

                return $class;
            }

            return null;
        } catch (\Exception $e) {
            error_log('Error fetching class: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save class data
     *
     * @return bool Success status
     */
    public function save() {
        try {
            $db = DatabaseService::getInstance();
            $db->beginTransaction();

            $now = date('Y-m-d H:i:s');
            $this->setCreatedAt($now);
            $this->setUpdatedAt($now);

            // Insert main class record
            $sql = "INSERT INTO wecoza_classes (
                client_id, site_id, site_address, class_type, class_subject, class_code, class_duration,
                class_start_date, seta_funded, seta_id, exam_class, exam_type, qa_visit_dates,
                class_agent, project_supervisor, delivery_date, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $params = [
                $this->getClientId(),
                $this->getSiteId(),
                $this->getSiteAddress(),
                $this->getClassType(),
                $this->getClassSubject(),
                $this->getClassCode(),
                $this->getClassDuration(),
                $this->getClassStartDate(),
                $this->getSetaFunded(),
                $this->getSetaId(),
                $this->getExamClass(),
                $this->getExamType(),
                $this->getQaVisitDates(),
                $this->getClassAgent(),
                $this->getProjectSupervisor(),
                $this->getDeliveryDate(),
                $this->getCreatedAt(),
                $this->getUpdatedAt()
            ];

            $db->query($sql, $params);
            $classId = $db->lastInsertId();
            $this->setId($classId);

            // Save related data
            $this->saveScheduleData($classId);
            $this->saveStopRestartDates($classId);
            $this->saveLearners($classId);
            $this->saveBackupAgents($classId);
            $this->saveCourses($classId);
            $this->saveClassNotes($classId);

            $db->commit();
            return true;
        } catch (\Exception $e) {
            if ($db->inTransaction()) {
                $db->rollback();
            }
            error_log('Error saving class: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update class data
     *
     * @return bool Success status
     */
    public function update() {
        try {
            $db = DatabaseService::getInstance();
            $db->beginTransaction();

            $this->setUpdatedAt(date('Y-m-d H:i:s'));

            // Update main class record
            $sql = "UPDATE wecoza_classes SET
                client_id = ?, site_id = ?, site_address = ?, class_type = ?,
                class_subject = ?, class_code = ?, class_duration = ?,
                class_start_date = ?, seta_funded = ?, seta_id = ?, exam_class = ?,
                exam_type = ?, qa_visit_dates = ?, class_agent = ?, project_supervisor = ?,
                delivery_date = ?, updated_at = ?
                WHERE id = ?";

            $params = [
                $this->getClientId(),
                $this->getSiteId(),
                $this->getSiteAddress(),
                $this->getClassType(),
                $this->getClassSubject(),
                $this->getClassCode(),
                $this->getClassDuration(),
                $this->getClassStartDate(),
                $this->getSetaFunded(),
                $this->getSetaId(),
                $this->getExamClass(),
                $this->getExamType(),
                $this->getQaVisitDates(),
                $this->getClassAgent(),
                $this->getProjectSupervisor(),
                $this->getDeliveryDate(),
                $this->getUpdatedAt(),
                $this->getId()
            ];

            $db->query($sql, $params);

            // Update related data - first delete existing
            $this->deleteRelatedData();

            // Then save new data
            $this->saveScheduleData($this->getId());
            $this->saveStopRestartDates($this->getId());
            $this->saveLearners($this->getId());
            $this->saveBackupAgents($this->getId());
            $this->saveCourses($this->getId());
            $this->saveClassNotes($this->getId());

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
     *
     * @return bool Success status
     */
    public function delete() {
        try {
            $db = DatabaseService::getInstance();
            $db->beginTransaction();

            // Delete related data
            $this->deleteRelatedData();

            // Delete main class record
            $db->query("DELETE FROM wecoza_classes WHERE id = ?", [$this->getId()]);

            $db->commit();
            return true;
        } catch (\Exception $e) {
            if ($db->inTransaction()) {
                $db->rollback();
            }
            error_log('Error deleting class: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete related data
     */
    private function deleteRelatedData() {
        $db = DatabaseService::getInstance();
        $classId = $this->getId();

        $db->query("DELETE FROM wecoza_class_schedule WHERE class_id = ?", [$classId]);
        $db->query("DELETE FROM wecoza_class_dates WHERE class_id = ?", [$classId]);
        $db->query("DELETE FROM wecoza_class_learners WHERE class_id = ?", [$classId]);
        $db->query("DELETE FROM wecoza_class_backup_agents WHERE class_id = ?", [$classId]);
        $db->query("DELETE FROM wecoza_class_courses WHERE class_id = ?", [$classId]);
        $db->query("DELETE FROM wecoza_class_notes WHERE class_id = ?", [$classId]);
    }

    /**
     * Load schedule data
     */
    private function loadScheduleData() {
        $db = DatabaseService::getInstance();
        $stmt = $db->query("SELECT * FROM wecoza_class_schedule WHERE class_id = ?", [$this->getId()]);
        $scheduleData = [];

        while ($row = $stmt->fetch()) {
            $scheduleData[] = [
                'day' => $row['day'],
                'date' => $row['date'],
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time'],
                'notes' => $row['notes'],
                'type' => $row['type']
            ];
        }

        $this->setScheduleData($scheduleData);
    }

    /**
     * Save schedule data
     *
     * @param int $classId Class ID
     */
    private function saveScheduleData($classId) {
        $db = DatabaseService::getInstance();
        $scheduleData = $this->getScheduleData();

        if (empty($scheduleData)) {
            return;
        }

        $sql = "INSERT INTO wecoza_class_schedule (class_id, day, date, start_time, end_time, notes, type)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        foreach ($scheduleData as $schedule) {
            $params = [
                $classId,
                $schedule['day'],
                $schedule['date'],
                $schedule['start_time'],
                $schedule['end_time'],
                $schedule['notes'],
                $schedule['type']
            ];

            $db->query($sql, $params);
        }
    }

    /**
     * Load stop/restart dates
     */
    private function loadStopRestartDates() {
        $db = DatabaseService::getInstance();
        $stmt = $db->query("SELECT * FROM wecoza_class_dates WHERE class_id = ?", [$this->getId()]);
        $stopDates = [];
        $restartDates = [];

        while ($row = $stmt->fetch()) {
            $stopDates[] = $row['stop_date'];
            $restartDates[] = $row['restart_date'];
        }

        $this->setStopDates($stopDates);
        $this->setRestartDates($restartDates);
    }

    /**
     * Save stop/restart dates
     *
     * @param int $classId Class ID
     */
    private function saveStopRestartDates($classId) {
        $db = DatabaseService::getInstance();
        $stopDates = $this->getStopDates();
        $restartDates = $this->getRestartDates();

        if (empty($stopDates) || empty($restartDates)) {
            return;
        }

        $sql = "INSERT INTO wecoza_class_dates (class_id, stop_date, restart_date) VALUES (?, ?, ?)";

        for ($i = 0; $i < count($stopDates); $i++) {
            if (empty($stopDates[$i]) || empty($restartDates[$i])) {
                continue;
            }

            $params = [
                $classId,
                $stopDates[$i],
                $restartDates[$i]
            ];

            $db->query($sql, $params);
        }
    }

    /**
     * Load learners
     */
    private function loadLearners() {
        $db = DatabaseService::getInstance();
        $stmt = $db->query("SELECT learner_id FROM wecoza_class_learners WHERE class_id = ?", [$this->getId()]);
        $learnerIds = [];

        while ($row = $stmt->fetch()) {
            $learnerIds[] = $row['learner_id'];
        }

        $this->setLearnerIds($learnerIds);
    }

    /**
     * Save learners
     *
     * @param int $classId Class ID
     */
    private function saveLearners($classId) {
        $db = DatabaseService::getInstance();
        $learnerIds = $this->getLearnerIds();

        if (empty($learnerIds)) {
            return;
        }

        $sql = "INSERT INTO wecoza_class_learners (class_id, learner_id) VALUES (?, ?)";

        foreach ($learnerIds as $learnerId) {
            $db->query($sql, [$classId, $learnerId]);
        }
    }

    /**
     * Load backup agents
     */
    private function loadBackupAgents() {
        $db = DatabaseService::getInstance();
        $stmt = $db->query("SELECT agent_id FROM wecoza_class_backup_agents WHERE class_id = ?", [$this->getId()]);
        $agentIds = [];

        while ($row = $stmt->fetch()) {
            $agentIds[] = $row['agent_id'];
        }

        $this->setBackupAgentIds($agentIds);
    }

    /**
     * Save backup agents
     *
     * @param int $classId Class ID
     */
    private function saveBackupAgents($classId) {
        $db = DatabaseService::getInstance();
        $agentIds = $this->getBackupAgentIds();

        if (empty($agentIds)) {
            return;
        }

        $sql = "INSERT INTO wecoza_class_backup_agents (class_id, agent_id) VALUES (?, ?)";

        foreach ($agentIds as $agentId) {
            $db->query($sql, [$classId, $agentId]);
        }
    }

    /**
     * Load courses
     */
    private function loadCourses() {
        $db = DatabaseService::getInstance();
        $stmt = $db->query("SELECT course_id FROM wecoza_class_courses WHERE class_id = ?", [$this->getId()]);
        $courseIds = [];

        while ($row = $stmt->fetch()) {
            $courseIds[] = $row['course_id'];
        }

        $this->setCourseIds($courseIds);
    }

    /**
     * Save courses
     *
     * @param int $classId Class ID
     */
    private function saveCourses($classId) {
        $db = DatabaseService::getInstance();
        $courseIds = $this->getCourseIds();

        if (empty($courseIds)) {
            return;
        }

        $sql = "INSERT INTO wecoza_class_courses (class_id, course_id) VALUES (?, ?)";

        foreach ($courseIds as $courseId) {
            $db->query($sql, [$classId, $courseId]);
        }
    }

    /**
     * Load class notes
     */
    private function loadClassNotes() {
        $db = DatabaseService::getInstance();
        $stmt = $db->query("SELECT note_id FROM wecoza_class_notes WHERE class_id = ?", [$this->getId()]);
        $noteIds = [];

        while ($row = $stmt->fetch()) {
            $noteIds[] = $row['note_id'];
        }

        $this->setClassNotes($noteIds);
    }

    /**
     * Save class notes
     *
     * @param int $classId Class ID
     */
    private function saveClassNotes($classId) {
        $db = DatabaseService::getInstance();
        $noteIds = $this->getClassNotes();

        if (empty($noteIds)) {
            return;
        }

        $sql = "INSERT INTO wecoza_class_notes (class_id, note_id) VALUES (?, ?)";

        foreach ($noteIds as $noteId) {
            $db->query($sql, [$classId, $noteId]);
        }
    }

    // Getters and setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
        return $this;
    }

    public function getSiteId() {
        return $this->siteId;
    }

    public function setSiteId($siteId) {
        $this->siteId = $siteId;
        return $this;
    }

    public function getSiteAddress() {
        return $this->siteAddress;
    }

    public function setSiteAddress($siteAddress) {
        $this->siteAddress = $siteAddress;
        return $this;
    }

    public function getClassType() {
        return $this->classType;
    }

    public function setClassType($classType) {
        $this->classType = $classType;
        return $this;
    }

    public function getClassSubject() {
        return $this->classSubject;
    }

    public function setClassSubject($classSubject) {
        $this->classSubject = $classSubject;
        return $this;
    }

    public function getClassCode() {
        return $this->classCode;
    }

    public function setClassCode($classCode) {
        $this->classCode = $classCode;
        return $this;
    }

    public function getClassDuration() {
        return $this->classDuration;
    }

    public function setClassDuration($classDuration) {
        $this->classDuration = $classDuration;
        return $this;
    }

    public function getClassStartDate() {
        return $this->classStartDate;
    }

    public function setClassStartDate($classStartDate) {
        $this->classStartDate = $classStartDate;
        return $this;
    }

    public function getCourseIds() {
        return $this->courseIds;
    }

    public function setCourseIds($courseIds) {
        $this->courseIds = $courseIds;
        return $this;
    }

    public function getClassNotes() {
        return $this->classNotes;
    }

    public function setClassNotes($classNotes) {
        $this->classNotes = $classNotes;
        return $this;
    }

    public function getSetaFunded() {
        return $this->setaFunded;
    }

    public function setSetaFunded($setaFunded) {
        $this->setaFunded = $setaFunded;
        return $this;
    }

    public function getSetaId() {
        return $this->setaId;
    }

    public function setSetaId($setaId) {
        $this->setaId = $setaId;
        return $this;
    }

    public function getExamClass() {
        return $this->examClass;
    }

    public function setExamClass($examClass) {
        $this->examClass = $examClass;
        return $this;
    }

    public function getExamType() {
        return $this->examType;
    }

    public function setExamType($examType) {
        $this->examType = $examType;
        return $this;
    }

    public function getQaVisitDates() {
        return $this->qaVisitDates;
    }

    public function setQaVisitDates($qaVisitDates) {
        $this->qaVisitDates = $qaVisitDates;
        return $this;
    }

    public function getClassAgent() {
        return $this->classAgent;
    }

    public function setClassAgent($classAgent) {
        $this->classAgent = $classAgent;
        return $this;
    }

    public function getProjectSupervisor() {
        return $this->projectSupervisor;
    }

    public function setProjectSupervisor($projectSupervisor) {
        $this->projectSupervisor = $projectSupervisor;
        return $this;
    }

    public function getLearnerIds() {
        return $this->learnerIds;
    }

    public function setLearnerIds($learnerIds) {
        $this->learnerIds = $learnerIds;
        return $this;
    }

    public function getDeliveryDate() {
        return $this->deliveryDate;
    }

    public function setDeliveryDate($deliveryDate) {
        $this->deliveryDate = $deliveryDate;
        return $this;
    }

    public function getBackupAgentIds() {
        return $this->backupAgentIds;
    }

    public function setBackupAgentIds($backupAgentIds) {
        $this->backupAgentIds = $backupAgentIds;
        return $this;
    }

    public function getScheduleData() {
        return $this->scheduleData;
    }

    public function setScheduleData($scheduleData) {
        $this->scheduleData = $scheduleData;
        return $this;
    }

    public function getStopDates() {
        return $this->stopDates;
    }

    public function setStopDates($stopDates) {
        $this->stopDates = $stopDates;
        return $this;
    }

    public function getRestartDates() {
        return $this->restartDates;
    }

    public function setRestartDates($restartDates) {
        $this->restartDates = $restartDates;
        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get validation rules for class data
     *
     * @return array Validation rules
     */
    public static function getValidationRules() {
        return [
            'client_id' => [
                'required' => true,
                'numeric' => true
            ],
            'site_id' => [
                'required' => true,
                'numeric' => true
            ],
            'class_type' => [
                'required' => true
            ],
            'class_subject' => [
                'required' => true
            ],
            'class_code' => [
                'required' => true
            ],
            'class_start_date' => [
                'required' => true,
                'date' => true
            ],
            'course_id' => [
                'required' => true,
                'array' => true
            ],
            'seta_funded' => [
                'required' => true,
                'in_array' => ['Yes', 'No']
            ],
            'seta_id' => [
                'required' => function($value, $data) {
                    return isset($data['seta_funded']) && $data['seta_funded'] === 'Yes';
                }
            ],
            'exam_class' => [
                'required' => true,
                'in_array' => ['Yes', 'No']
            ],
            'exam_type' => [
                'required' => function($value, $data) {
                    return isset($data['exam_class']) && $data['exam_class'] === 'Yes';
                }
            ],
            'class_agent' => [
                'required' => true,
                'numeric' => true
            ],
            'project_supervisor' => [
                'required' => true,
                'numeric' => true
            ],
            'delivery_date' => [
                'required' => true,
                'date' => true
            ],
            'add_learner' => [
                'required' => true,
                'array' => true
            ],
            'backup_agent' => [
                'required' => true,
                'array' => true
            ],
            // Add custom validation for stop/restart dates
            'stop_dates' => [
                'custom' => function($value, $data) {
                    if (!is_array($value)) {
                        return 'Stop dates must be an array';
                    }

                    if (isset($data['restart_dates']) && is_array($data['restart_dates'])) {
                        // Check that each restart date is after its corresponding stop date
                        foreach ($value as $index => $stopDate) {
                            if (empty($stopDate)) {
                                continue;
                            }

                            if (isset($data['restart_dates'][$index]) && !empty($data['restart_dates'][$index])) {
                                $stopTimestamp = strtotime($stopDate);
                                $restartTimestamp = strtotime($data['restart_dates'][$index]);

                                if ($restartTimestamp <= $stopTimestamp) {
                                    return 'Each restart date must be after its corresponding stop date';
                                }
                            }
                        }
                    }

                    return true;
                }
            ],
            // Add validation for exception dates
            'scheduleData' => [
                'custom' => function($value, $data) {
                    // If no schedule data or no class start date, skip validation
                    if (!is_array($value) || empty($data['class_start_date'])) {
                        return true;
                    }

                    // Get class start date
                    $classStartDate = $data['class_start_date'];
                    $classStartTimestamp = strtotime($classStartDate);

                    // Validate schedule start date against class original start date
                    if (isset($value['start_date']) && !empty($value['start_date'])) {
                        $scheduleStartDate = $value['start_date'];
                        $scheduleStartTimestamp = strtotime($scheduleStartDate);

                        if ($scheduleStartTimestamp < $classStartTimestamp) {
                            return 'Schedule start date cannot be before the class original start date';
                        }
                    }

                    // Check exception dates if they exist
                    if (isset($value['exception_dates'])) {
                        $exceptionDates = $value['exception_dates'];

                        // Handle JSON string
                        if (is_string($exceptionDates)) {
                            $exceptionDates = json_decode($exceptionDates, true);
                        }

                        // Validate each exception date
                        if (is_array($exceptionDates)) {
                            foreach ($exceptionDates as $exception) {
                                if (isset($exception['date']) && !empty($exception['date'])) {
                                    $exceptionTimestamp = strtotime($exception['date']);

                                    if ($exceptionTimestamp < $classStartTimestamp) {
                                        return 'Exception dates cannot be before the class start date';
                                    }
                                }
                            }
                        }
                    }

                    return true;
                }
            ]
        ];
    }

    /**
     * Validate class data
     *
     * @param array $data Data to validate
     * @return ValidationService Validation service with results
     */
    public static function validate($data) {
        $validator = new ValidationService(self::getValidationRules());
        $validator->validate($data);
        return $validator;
    }
}
