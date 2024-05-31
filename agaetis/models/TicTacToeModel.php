<?php
namespace agaetis\models;

use agaetis\constants\Config;
use agaetis\constants\Message;
use agaetis\services\Logger;

/**
 *
 * @author Arvind Sharma
 */
class TicTacToeModel extends AbstractModel implements Config
{

    const TABLE_SCORES = 'scores';

    const CREATE_TABLE_SCORES_SQL = '
      CREATE TABLE IF NOT EXISTS ' . self::TABLE_SCORES . ' (
        id INTEGER PRIMARY KEY,
        moves TEXT NOT NULL,
        outcome TEXT NOT NULL,
        epoch INTEGER
      )
    ';

    const SAVE_SCORES_SQL = 'INSERT INTO ' . self::TABLE_SCORES . ' (moves, outcome, epoch) VALUES (?, ?, ?)';
    const LAST_SCORES_SQL = 'select id, moves, outcome, epoch from ' . self::TABLE_SCORES . ' order by epoch desc limit 10';

    private $board;
    private $players;
    private $winner;
    private $moves;
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->clearBoard();
    }

    protected function prepareStore()
    {
        $this->exec(self::CREATE_TABLE_SCORES_SQL);
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function getCurrentPlayer()
    {
        return $this->players[0];
    }

    private function invalidMove($row, $col)
    {
        return (
            $row < 0 ||
            $row >= self::BOARD_SIZE ||
            $col < 0 ||
            $col >= self::BOARD_SIZE ||
            $this->board[$row][$col] !== self::BLANK_SPACE
        );
    }

    public function makeMove($row, $col)
    {
        if ($this->invalidMove($row, $col)) {
            return false;
        }
        $player = $this->getCurrentPlayer();
        $this->board[$row][$col] = $player;
        $this->moves[] = [$row, $col, $player];
        $this->checkWinner();
        $this->nextPlayer();
        return true;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    private function checkWinner()
    {
        // Check rows
        for ($i = 0; $i < self::BOARD_SIZE; $i++) {
            if ($this->board[$i][0] !== self::BLANK_SPACE && $this->board[$i][0] === $this->board[$i][1] && $this->board[$i][1] === $this->board[$i][2]) {
                $this->winner = $this->board[$i][0];
                return;
            }
        }

        // Check columns
        for ($j = 0; $j < self::BOARD_SIZE; $j++) {
            if ($this->board[0][$j] !== self::BLANK_SPACE && $this->board[0][$j] === $this->board[1][$j] && $this->board[1][$j] === $this->board[2][$j]) {
                $this->winner = $this->board[0][$j];
                return;
            }
        }

        // Check diagonals
        if ($this->board[0][0] !== self::BLANK_SPACE && $this->board[0][0] === $this->board[1][1] && $this->board[1][1] === $this->board[2][2]) {
            $this->winner = $this->board[0][0];
            return;
        }

        if ($this->board[0][self::BOARD_SIZE - 1] !== self::BLANK_SPACE && $this->board[0][self::BOARD_SIZE - 1] === $this->board[1][1] && $this->board[1][1] === $this->board[2][0]) {
            $this->winner = $this->board[0][self::BOARD_SIZE - 1];
            return;
        }
        // Check for draw
        $draw = true;
        foreach ($this->board as $row) {
            if (in_array(self::BLANK_SPACE, $row)) {
                $draw = false;
                break;
            }
        }
        if ($draw) {
            $this->winner = self::DRAW;
        }
    }

    public function storeGameResult()
    {
        $moves_json = json_encode($this->moves);
        $outcome = $this->winner;
        $epoch = time();
        $params = array($moves_json, $outcome, $epoch);
        Logger::trace(array('sql'=>self::SAVE_SCORES_SQL, 'params' => $params));
        $this->exec(self::SAVE_SCORES_SQL, $params);
    }

    public function clearBoard()
    {
        $this->board = array_fill(0, self::BOARD_SIZE, array_fill(0, self::BOARD_SIZE, self::BLANK_SPACE));
        $this->players = [self::PLAYER_X, self::PLAYER_O];
        $this->winner = null;
        $this->moves = [];
    }

    public function lastScores()
    {
        return $this->fetchAll(self::LAST_SCORES_SQL);
    }

    private function nextPlayer()
    {
        $player = array_shift($this->players);
        array_push($this->players, $player);
    }
}
