<?php

require_once __DIR__ . '/../autoload.php';

use agaetis\models\TicTacToeModel;
use PHPUnit\Framework\TestCase;

class TicTacToeTest extends TestCase
{
    public function testValidMove()
    {
        $model = new TicTacToeModel;
        $this->assertEquals(TicTacToeModel::PLAYER_X, $model->getCurrentPlayer());
        $this->assertTrue($model->makeMove(0, 0));
        $this->assertEquals(TicTacToeModel::PLAYER_O, $model->getCurrentPlayer());
    }

    public function testInvalidMove()
    {
        $model = new TicTacToeModel;
        $model->makeMove(0, 0);
        $this->assertFalse($model->makeMove(0, 0));
    }

    public function testWinnerX()
    {
        $model = new TicTacToeModel;
        $model->makeMove(0, 0); // x
        $model->makeMove(1, 0); // o
        $model->makeMove(0, 1); // x
        $model->makeMove(1, 1); // o
        $model->makeMove(0, 2); // x
        $this->assertEquals(TicTacToeModel::PLAYER_X, $model->getWinner());
    }

    public function testDraw()
    {
        $model = new TicTacToeModel;
        $model->makeMove(1, 1); // x
        $model->makeMove(0, 0); // o
        $model->makeMove(2, 2); // x
        $model->makeMove(2, 0); // o
        $model->makeMove(1, 0); // x
        $model->makeMove(2, 1); // o
        $model->makeMove(0, 1); // x
        $model->makeMove(1, 2); // o
        $model->makeMove(0, 2); // x
        $this->assertEquals(TicTacToeModel::DRAW, $model->getWinner());
    }
}
