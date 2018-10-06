<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Player
{
    protected $monolog;

    const VERSION = "Smiling Horse 😁🐴";

    public function __construct()
    {
        $this->monolog = new Logger('player');
        $this->monolog->pushHandler(new StreamHandler("php://stderr", Logger::DEBUG));
    }

    public function betRequest($game_state)
    {
        $this->monolog->debug('Test log', $game_state[$game_state['in_action']]['hole_cards']);
    	//ALL IN
	    return 10000;

    	$all_in = $this->checkCards($game_state[$game_state['in_action']]['hole_cards'], $game_state['community_cards']);
    	if ($all_in) {
		    return 10000;
	    } else {
    		return 0;
	    }
    }

    public function checkCards($own_cards, $community_cards) {
		$cards = array_merge($own_cards, $community_cards);
		if ($this->check9orHigher($own_cards)) {
			return true;
		}
		return true;
    }

    public function check9orHigher($own_cards) {
    	if ($own_cards[0]['rank'] >= 9 && $own_cards[1]['rank'] >= 9) {
    		return true;
	    }
    	return false;
    }

    public function showdown($game_state)
    {
    }
}
