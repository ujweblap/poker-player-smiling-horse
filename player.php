<?php

class Player
{
    protected $logger;

    const VERSION = "Smiling Horse 😁🐴";

    public function __construct()
    {
        $this->logger = new \SmilingHorse\LoggerInterface();
    }

    public function betRequest($game_state)
    {
        $this->logger->getMonolog()->debug('Test log', $game_state[$game_state['in_action']]['hole_cards']);
    	//ALL IN
	    //return 10000;

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
		//check pair in hand
		if ($this->hasPair($own_cards)) {
			return true;
		}
	    //check pair
	    if ($this->hasPair($cards)) {
			return true;
	    }
		return false;
    }

    public function check9orHigher($own_cards) {
    	if ($own_cards[0]['rank'] >= 9 && $own_cards[1]['rank'] >= 9) {
    		return true;
	    }
    	return false;
    }

    public function hasPair($cards) {
    	$has_pair = false;
    	foreach ($cards as $i=>$card) {
		    foreach ($cards as $i2=>$card2) {
				if ($i!==$i2) {
					if ($card['rank']==$card2['rank']) {
						$has_pair = true;
					}
				}
		    }
	    }
	    return $has_pair;
    }

    public function showdown($game_state)
    {
    }
}
