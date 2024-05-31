<?php
/**
 * @author Arvind Sharma
 * auto loads necessary files to run the game
 */
require_once __DIR__.'/constants/Config.php';
require_once __DIR__.'/constants/Message.php';

require_once __DIR__.'/views/TicTacToeView.php';

require_once __DIR__.'/services/StorageFactory.php';
require_once __DIR__.'/services/Logger.php';

require_once __DIR__.'/models/AbstractModel.php';
require_once __DIR__.'/models/TicTacToeModel.php';

require_once __DIR__.'/controllers/TicTacToeController.php';