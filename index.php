<?php

require_once('vendor/autoload.php');
require_once('player.php');
require_once ('PokerPlayer.php');
require_once ('GameState.php');


$player = new Player();

switch($_POST['action'])
{
    case 'bet_request':
        echo $player->betRequest(json_decode($_POST['game_state'], true));
        break;
    case 'showdown':
        $player->showdown(json_decode($_POST['game_state'], true));
        break;
    case 'version':
        echo Player::VERSION;
}
