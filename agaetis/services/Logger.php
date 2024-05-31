<?php

namespace agaetis\services;

use agaetis\constants\Config;

final class Logger implements Config
{
    private function __construct()
    {}

    public static function trace($str)
    {
        self::logger(self::LOG_TYPE_TRACE, $str);
    }

    public static function fatal($str)
    {
        self::logger(self::LOG_TYPE_FATAL, $str);
    }

    public static function warn($str)
    {
        self::logger(self::LOG_TYPE_WARN, $str);
    }

    private static function logger($level, $str)
    {
        if (!is_string($str)) {
            $str = var_export($str, 1);
        }
        $trace = debug_backtrace(2);
        $trace = $trace[1];
        self::logLine($str, $trace['file'], $trace['line'], $level);
    }

    public static function logLine($errstr, $errfile, $errline, $level)
    {
        $base = dirname(dirname(__DIR__)).'/';
        $errfile = str_replace($base, '', $errfile);
        $log = '[' . $level . '][' . $errfile . ':' . $errline . '] ' . $errstr;
        $log = '['.date(Config::LOG_TIME_FORMAT).']'.$log.PHP_EOL;
        error_log($log, 3, Config::LOG_FILE_PATH. date(Config::LOG_FILE_NAME) . Config::LOG_FILE_EXT);
    }
}
