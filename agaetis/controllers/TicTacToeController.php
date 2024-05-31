<?php

namespace agaetis\controllers;

use agaetis\constants\Config;
use agaetis\constants\Message;
use agaetis\models\TicTacToeModel;
use agaetis\services\Logger;
use agaetis\views\TicTacToeView;
use \PDOException;

/**
 *
 * @author Arvind Sharma
 *
 */
class TicTacToeController
{
    private $model;
    private $view;

    public function __construct(TicTacToeModel $model, TicTacToeView $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function start()
    {
        $choice = Config::MENU_EXIT;
        do {
            $this->view->showMenu();
            $choice = $this->view->userInput();
            Logger::trace(compact('choice'));
            switch ($choice) {
                case Message::MENU_PLAY:
                    $this->playGame();
                    break;
                case Message::MENU_SCORES:
                    $this->checkScores();
                    break;
                case Message::MENU_EXIT:
                    $this->exitGame();
                    break;
                default:
                    $this->view->showMessage(Message::MESSAGE_INVALID_MENU . PHP_EOL);
                    Logger::warn(Message::MESSAGE_INVALID_MENU);
            }
        } while (0 !== strcmp(Message::MENU_EXIT, $choice));
    }

    public function playGame()
    {
        $this->model->clearBoard();

        while (!$this->model->getWinner()) {
            $this->view->displayBoard($this->model->getBoard());
            $player = $this->model->getCurrentPlayer();
            list($row, $col) = $this->getUserInput($player);
            $moved = $this->model->makeMove($row, $col);
            Logger::trace(compact('player','row','col','moved'));
            if (!$moved) {
                $this->view->showMessage(Message::MESSAGE_INVALID_MOVE . PHP_EOL);
                Logger::warn(Message::MESSAGE_INVALID_MOVE);
                continue;
            }
        }
        $winner = $this->model->getWinner();
        $msg = sprintf(Message::MESSAGE_WINNER, $winner);
        if (Config::DRAW === $winner) {
            $msg = Message::MESSAGE_DRAW;
        }
        Logger::trace(compact('winner','msg'));
        $this->view->showMessage($msg);
        $this->model->storeGameResult();
    }

    private function getUserInput($player)
    {
        $msg = sprintf(Message::MESSAGE_PLAYER_TURN, $player);
        $quit = false;
        $row = $col = -1;
        do {
            $line = $this->view->userInput($msg);
            $count = preg_match_all('/\\d/', $line, $nums);
            Logger::trace(compact('count','line','nums','player'));
            if (2 <= $count && isset($nums[0][0]) && isset($nums[0][1])) {
                $row = $nums[0][0];
                $col = $nums[0][1];
                $quit = true;
            } else {
                $this->view->showMessage(Message::INVALID_INPUT . PHP_EOL);
                Logger::warn(Message::INVALID_INPUT);
            }
        } while (!$quit);
        return array($row, $col);
    }

    private function checkScores()
    {
        $this->view->showMessage(Message::SCORE_LIST_TITLE . PHP_EOL);
        $scores = null;
        try {
            $scores = $this->model->lastScores();
        } catch (PDOException $ex) {
            Logger::fatal($ex->getMessage());
        }
        if (empty($scores)) {
            $this->view->showMessage(Message::MESSAGE_NO_SCORES . PHP_EOL);
            Logger::warn(Message::MESSAGE_NO_SCORES);
        } else {
            foreach ($scores as $row) {
                $date_time = date(Message::DATETIME_FORMAT, $row['epoch']);
                $this->view->showMessage(
                    sprintf(Message::SCORE_ROW_FORMAT, $row['id'], $date_time, $row['outcome']) . PHP_EOL
                );
            }
        }

    }

    private function exitGame()
    {
        $this->view->showMessage(Message::MESSAGE_ON_EXIT . PHP_EOL);
    }
}
