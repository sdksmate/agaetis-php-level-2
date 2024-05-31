<?php

namespace agaetis\views;

use agaetis\constants\Message;
use agaetis\services\Logger;

/**
 * @author Arvind Sharma
 * only presentation logic for the board
 */
class TicTacToeView
{
    private $outfile;
    private $infile;

    public function __construct($outfile, $infile)
    {
        $this->outfile = $outfile;
        $this->infile = $infile;
    }

    public function displayBoard($board)
    {
        $this->showMessage(PHP_EOL);
        $line = str_repeat(Message::ROWS_SEPARATOR, Message::BOARD_SIZE);
        foreach ($board as $i => $row) {
            if ($i) { # skip first row
                $this->showMessage($line . PHP_EOL);
            }
            $this->showMessage(implode(Message::COLS_SEPARATOR, $row) . PHP_EOL);
        }
        $this->showMessage(PHP_EOL);
    }

    public function showMessage($message = PHP_EOL)
    {
        if (null === $message) {
            $message = '';
        }
        fprintf($this->outfile, $message);
        Logger::trace($message);
    }

    public function showMenu()
    {
        $this->showMessage(Message::MENU_TITLE . PHP_EOL);
        $this->showMessage(Message::MENU_PLAY_TEXT . PHP_EOL);
        $this->showMessage(Message::MENU_SCORES_TEXT . PHP_EOL);
        $this->showMessage(Message::MENU_EXIT_TEXT . PHP_EOL);
        $this->showMessage(Message::PROMPT_MENU);
    }

    public function userInput($msg = null)
    {
        $this->showMessage($msg);
        $line = fgets($this->infile);
        if ($line) {
            $line = trim($line);
        }
        return $line;
    }
}
