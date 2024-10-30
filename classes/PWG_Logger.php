<?php 
class PWG_Logger {
    private static function log($message, $level = 'info') {
        if (WP_DEBUG === true) {
            $timestamp = date('Y-m-d H:i:s');
            $formatted_message = sprintf(
                '[%s] [%s] [PWG Golf] %s',
                $timestamp,
                strtoupper($level),
                is_array($message) || is_object($message) ? print_r($message, true) : $message
            );
            error_log($formatted_message);
        }
    }

    public static function info($message) {
        self::log($message, 'info');
    }

    public static function error($message) {
        self::log($message, 'error');
    }

    public static function debug($message) {
        self::log($message, 'debug');
    }
}
/*
// Usage in  golf club class:
PWG_Logger::info('New golf club created: ' . $this->name);
PWG_Logger::error('Failed to save golf club: ' . $error_message);
PWG_Logger::debug($this->facilities);
**/