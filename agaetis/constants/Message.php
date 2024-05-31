<?php

namespace agaetis\constants;

use agaetis\constants\Config;

/**
 * @author Arvind Sharma
 */
interface Message extends Config
{
    const MESSAGE_INVALID_MOVE = 'Error: Invalid move! Try again.';
    const MESSAGE_PLAYER_TURN = 'Player %s\'s turn. Enter row and column (' . self::MIN_NUM . '-' . (self::MAX_NUM) . '): ';
    const MESSAGE_DRAW = 'It\'s a draw!';
    const MESSAGE_WINNER = 'Player %s wins!';
    const MESSAGE_MOVES_PLAYED = 'Moves played: ';
    const DRAW_LINE = PHP_EOL.'======================'.PHP_EOL;
    const MENU_TITLE = self::DRAW_LINE.'Menu'.self::DRAW_LINE;
    const MENU_PLAY_TEXT = self::MENU_PLAY . ') Play Game';
    const MENU_SCORES_TEXT = self::MENU_SCORES . ') Check Scores';
    const MENU_EXIT_TEXT = self::MENU_EXIT . ') Exit';
    const PROMPT_MENU = self::DRAW_LINE.'Enter your choice: ';
    const MESSAGE_INVALID_MENU = 'Error: Invalid choice! Please try again.';
    const MESSAGE_NO_SCORES = 'No games played yet.';
    const MESSAGE_ON_EXIT = 'Exiting the game. Goodbye!';
    const SCORE_ROW_FORMAT = '%03d) Date & Time: %s, Outcome: %s';
    const INVALID_INPUT = 'Error: Invalid input!';
    const SCORE_LIST_TITLE = self::DRAW_LINE.'Past Scores'.self::DRAW_LINE;
}
