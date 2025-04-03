<?php
define('WECOZA_VERSION_MAJOR', '1');
define('WECOZA_VERSION_MINOR', '0');
define('WECOZA_VERSION_PATCH', '0');
define('WECOZA_VERSION', WECOZA_VERSION_MAJOR . '.' . WECOZA_VERSION_MINOR . '.' . WECOZA_VERSION_PATCH);

function wecoza_get_version() {
    return WECOZA_VERSION;
}

function wecoza_update_version_history($version, $description) {
    $history = get_option('wecoza_version_history', array());
    $history[] = array(
        'version' => $version,
        'date' => current_time('mysql'),
        'description' => $description
    );
    update_option('wecoza_version_history', $history);
}