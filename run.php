<?php

require_once('Constants.php');
require_once('Game.php');
require_once('Model/Room.php');
require_once('Model/Item.php');

$game = new Game();
$game->start();
