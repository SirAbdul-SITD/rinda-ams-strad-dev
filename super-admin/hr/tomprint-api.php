<?php
require_once '../settings.php';
require_once 'tomprint-config.php';

class TomprintAPI {
    private $pdo;
    private $apiUrl;
    private $apiKey;
    private $deviceId;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->apiUrl = TOMPRINT_API_URL;
        $this->apiKey = TOMPRINT_API_KEY;
        $this->deviceId = TOMPRINT_DEVICE_ID;
    }

    // Get attendance logs from Tomprint device
    public function getAttendanceLogs($startDate = null, $endDate = null) {
        try {
            $url = $this->apiUrl . '/logs';
            $params = [
                'device_id' => $this->deviceId,
                'api_key' => $this->apiKey
            ];

            if ($startDate) {
                $params['start_date'] = $startDate;
            }
            if ($endDate) {
                $params['end_date'] = $endDate;
            }

            $response = $this->makeRequest('GET', $url, $params);
            return $this->processLogs($response);
        } catch (Exception $e) {
            error_log("Error fetching Tomprint logs: " . $e->getMessage());
            return false;
        }
    }

    // Process and store attendance logs
    private function processLogs($logs) {
        if (!$logs || !is_array($logs)) {
            return false;
        }

        $processed = 0;
        foreach ($logs as $log) {
            try {
                // Extract staff ID from fingerprint data
                $staffId = $this->getStaffIdFromFingerprint($log['fingerprint_id']);
                if (!$staffId) {
                    continue;
                }

                // Determine log type (check-in or check-out)
                $logType = $this->determineLogType($staffId, $log['timestamp']);

                // Store the log
                $this->storeLog($staffId, $log['timestamp'], $logType, $log);
                $processed++;

                // Update attendance record
                $this->updateAttendance($staffId, $log['timestamp'], $logType);
            } catch (Exception $e) {
                error_log("Error processing log: " . $e->getMessage());
                continue;
            }
        }

        return $processed;
    }

    // Get staff ID from fingerprint ID
    private function getStaffIdFromFingerprint($fingerprintId) {
        $stmt = $this->pdo->prepare("SELECT staff_id FROM staff_fingerprints WHERE fingerprint_id = ?");
        $stmt->execute([$fingerprintId]);
        return $stmt->fetchColumn();
    }

    // Determine if the log is check-in or check-out
    private function determineLogType($staffId, $timestamp) {
        $date = date('Y-m-d', strtotime($timestamp));
        $time = date('H:i:s', strtotime($timestamp));

        // Check if there's already a check-in for today
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM staffs_attendance 
            WHERE staff_id = ? AND date = ? AND check_in IS NOT NULL
        ");
        $stmt->execute([$staffId, $date]);
        $hasCheckIn = $stmt->fetchColumn() > 0;

        return $hasCheckIn ? 'check_out' : 'check_in';
    }

    // Store the log in the database
    private function storeLog($staffId, $timestamp, $logType, $rawData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO " . TOMPRINT_LOGS_TABLE . " 
            (staff_id, log_time, log_type, device_id, status, raw_data)
            VALUES (?, ?, ?, ?, 'success', ?)
        ");
        return $stmt->execute([
            $staffId,
            $timestamp,
            $logType,
            $this->deviceId,
            json_encode($rawData)
        ]);
    }

    // Update attendance record
    private function updateAttendance($staffId, $timestamp, $logType) {
        $date = date('Y-m-d', strtotime($timestamp));
        $time = date('H:i:s', strtotime($timestamp));

        // Check if attendance record exists
        $stmt = $this->pdo->prepare("
            SELECT id FROM staffs_attendance 
            WHERE staff_id = ? AND date = ?
        ");
        $stmt->execute([$staffId, $date]);
        $attendanceId = $stmt->fetchColumn();

        if ($attendanceId) {
            // Update existing record
            if ($logType === 'check_out') {
                $stmt = $this->pdo->prepare("
                    UPDATE staffs_attendance 
                    SET check_out = ?, working_hours = TIMESTAMPDIFF(HOUR, check_in, ?)
                    WHERE id = ?
                ");
                $stmt->execute([$time, $time, $attendanceId]);
            }
        } else {
            // Create new record
            $status = $this->determineStatus($time);
            $stmt = $this->pdo->prepare("
                INSERT INTO staffs_attendance 
                (staff_id, date, status, check_in, check_out)
                VALUES (?, ?, ?, ?, NULL)
            ");
            $stmt->execute([$staffId, $date, $status, $time]);
        }
    }

    // Determine attendance status based on check-in time
    private function determineStatus($time) {
        if ($time <= WORK_START_TIME) {
            return 'present';
        } elseif ($time <= LATE_THRESHOLD) {
            return 'late';
        } else {
            return 'absent';
        }
    }

    // Make HTTP request to Tomprint API
    private function makeRequest($method, $url, $params = []) {
        $ch = curl_init();
        
        if ($method === 'GET' && !empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("CURL Error: " . $error);
        }

        return json_decode($response, true);
    }
} 