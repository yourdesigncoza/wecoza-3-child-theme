<?php
/**
 * FileUploadService.php
 *
 * Service for handling file uploads
 */

namespace WeCoza\Services\FileUpload;

class FileUploadService {
    /**
     * Upload directory
     */
    private $uploadDir;
    
    /**
     * Allowed file types
     */
    private $allowedTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png'
    ];
    
    /**
     * Constructor
     */
    public function __construct() {
        $uploadDir = \wp_upload_dir();
        $this->uploadDir = $uploadDir['basedir'];
    }
    
    /**
     * Upload a file
     *
     * @param array $file File data from $_FILES
     * @param string $subdir Subdirectory to upload to
     * @param array $allowedTypes Allowed file types (overrides default)
     * @param int $maxSize Maximum file size in bytes (default 5MB)
     * @return array Upload result
     */
    public function uploadFile($file, $subdir = '', $allowedTypes = [], $maxSize = 5242880) {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return [
                'success' => false,
                'message' => 'No file was uploaded.'
            ];
        }
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'message' => $this->getUploadErrorMessage($file['error'])
            ];
        }
        
        // Check file size
        if ($file['size'] > $maxSize) {
            return [
                'success' => false,
                'message' => 'File is too large. Maximum size is ' . $this->formatSize($maxSize) . '.'
            ];
        }
        
        // Use provided allowed types or default
        $types = !empty($allowedTypes) ? $allowedTypes : $this->allowedTypes;
        
        // Check file type
        $fileInfo = \wp_check_filetype($file['name']);
        $ext = $fileInfo['ext'];
        $type = $fileInfo['type'];
        
        if (!$ext || !$type || !$this->isAllowedType($type, $types)) {
            return [
                'success' => false,
                'message' => 'File type not allowed. Allowed types: ' . implode(', ', array_keys($types)) . '.'
            ];
        }
        
        // Create upload directory if it doesn't exist
        $uploadPath = $this->uploadDir;
        if (!empty($subdir)) {
            $uploadPath .= '/' . trim($subdir, '/');
            if (!file_exists($uploadPath)) {
                \wp_mkdir_p($uploadPath);
            }
        }
        
        // Generate unique filename
        $filename = \wp_unique_filename($uploadPath, $file['name']);
        $filepath = $uploadPath . '/' . $filename;
        
        // Move uploaded file
        if (!\move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'success' => false,
                'message' => 'Failed to move uploaded file.'
            ];
        }
        
        // Set correct file permissions
        $statInfo = \stat(dirname($filepath));
        $perms = $statInfo['mode'] & 0007777;
        $perms = $perms & 0000666;
        \chmod($filepath, $perms);
        
        // Return success
        return [
            'success' => true,
            'message' => 'File uploaded successfully.',
            'file_path' => (!empty($subdir) ? trim($subdir, '/') . '/' : '') . $filename,
            'file_url' => \wp_upload_dir()['baseurl'] . '/' . (!empty($subdir) ? trim($subdir, '/') . '/' : '') . $filename
        ];
    }
    
    /**
     * Check if file type is allowed
     *
     * @param string $type File MIME type
     * @param array $allowedTypes Allowed file types
     * @return bool Whether file type is allowed
     */
    private function isAllowedType($type, $allowedTypes) {
        return in_array($type, $allowedTypes);
    }
    
    /**
     * Get upload error message
     *
     * @param int $error Upload error code
     * @return string Error message
     */
    private function getUploadErrorMessage($error) {
        switch ($error) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded.';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk.';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload.';
            default:
                return 'Unknown upload error.';
        }
    }
    
    /**
     * Format file size
     *
     * @param int $size File size in bytes
     * @return string Formatted file size
     */
    private function formatSize($size) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
}
