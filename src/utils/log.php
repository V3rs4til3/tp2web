<?php

namespace utils;

class log {
    public static function write($message, $type = 'info') {
        $log_file = '/vav/www/html' . HOME_PATH . 'logs/'. $type . '.txt';
        $message = date('Y-m-d H:i:s') . ' - ' . $type . ': ' . $message . "\n";
        file_put_contents($log_file, $message, FILE_APPEND);
    }
}