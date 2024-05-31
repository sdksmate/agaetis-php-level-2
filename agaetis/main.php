<?php

/**
 * @author Arvind Sharma
 * runs console(text interface) game tic-tac-toe
 */

require_once __DIR__ . '/autoload.php';

use agaetis\constants\Config;
use agaetis\services\Logger;

ini_set('display_startup_errors', Config::SHOW_ERROR);
ini_set('error_reporting', Config::REPORT_ERROR);
ini_set('date.timezone', Config::TIME_ZONE);
ini_set('display_errors', Config::SHOW_ERROR);
ini_set('log_errors', Config::LOG_ERROR);
ini_set('max_execution_time', Config::TIME_LIMIT);

Logger::trace('running game ...');
register_shutdown_function(function(){
    Logger::trace('game stopped ...');
});

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    Logger::logLine($errstr, $errfile, $errline, Config::LOG_TYPE_FATAL);
});

set_exception_handler(function ($ex) {
    $errfile = $ex->getFile();
    $errline = $ex->getLine();
    $errstr = $ex->getMessage();
    Logger::logLine($errstr, $errfile, $errline, Config::LOG_TYPE_FATAL);
});

(new agaetis\controllers\TicTacToeController(
    new agaetis\models\TicTacToeModel,
    new agaetis\views\TicTacToeView(STDOUT, STDIN) # later can change for other streams as required
))->start();
