<?php
/**
 * Application configuration
 */

return [
    /**
     * Application name
     */
    'name' => 'WeCoza 3 Child Theme',

    /**
     * Application version
     */
    'version' => '1.0.0',

    /**
     * Debug mode
     */
    'debug' => false,

    /**
     * Database configuration
     */
    'database' => [
        'driver' => 'mysql',
        'host' => DB_HOST,
        'name' => DB_NAME,
        'user' => DB_USER,
        'password' => DB_PASSWORD,
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => 'wecoza_',
    ],

    /**
     * File upload configuration
     */
    'uploads' => [
        'max_size' => 10 * 1024 * 1024, // 10MB
        'allowed_types' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],
        'path' => WP_CONTENT_DIR . '/uploads/wecoza',
        'url' => content_url() . '/uploads/wecoza',
    ],

    /**
     * Controllers
     */
    'controllers' => [
        'WeCoza\\Controllers\\MainController',
        'WeCoza\\Controllers\\LearnerController',
        'WeCoza\\Controllers\\AssessmentController',
        'WeCoza\\Controllers\\NavigationController',
        'WeCoza\\Controllers\\ShortcodeListController',
    ],
];
