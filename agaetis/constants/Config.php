<?php

namespace agaetis\constants;

/**
 * @author Arvind Sharma
 */
interface Config
{
    const DATETIME_FORMAT = 'd M, h:i a';
    const LOG_TIME_FORMAT = 'H:i:s';
    const TIME_ZONE = 'Asia/Kolkata';
    const BOARD_SIZE = 3;
    const MENU_PLAY = '1';
    const MENU_SCORES = '2';
    const MENU_EXIT = '3';
    const MIN_NUM = 0;
    const MAX_NUM = self::BOARD_SIZE - 1;
    const STORE_PATH = __DIR__ . '/../store/tictactoe.db';
    const STORE_DRIVER = 'sqlite';
    const SHOW_ERROR = 0;
    const LOG_ERROR = 1;
    const REPORT_ERROR = E_ALL;
    const LOG_TYPE_FATAL = 'Fatal';
    const LOG_TYPE_TRACE = 'Trace';
    const LOG_TYPE_WARN = 'Warn';
    const TIME_LIMIT = 0;
    const COLS_SEPARATOR = ' | ';
    const ROWS_SEPARATOR = '---';
    const LOG_FILE_PATH =  __DIR__ . '/../logs/debug-';
    const LOG_FILE_NAME =  'dMY'; #file date pattern
    const LOG_FILE_EXT =  '.log';
    const PLAYER_X = 'x';
    const PLAYER_O = 'o';
    const BLANK_SPACE = ' ';
    const DRAW = 'draw';
}
