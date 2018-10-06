<?php

class Player
{
    protected $logger;

    const VERSION = "Smiling Horse";

    public function __construct()
    {
        $this->logger = new \SmilingHorse\LoggerInterface();
    }

    public function betRequest($game_state)
    {
        $this->logger->getMonolog()->debug('Game state', $game_state);
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
    	$card1 = $own_cards[0]['rank'];
    	$card2 = $own_cards[1]['rank'];
    	if (!is_numeric($card1)) {
    		$card1 = $this->mapLetterToNumber($card1);
	    }
	    if (!is_numeric($card2)) {
		    $card2 = $this->mapLetterToNumber($card2);
	    }
    	if ($card1 >= 9 && $card2 >= 9) {
    		return true;
	    }
    	return false;
    }

    public function mapLetterToNumber($letter) {
    	$map = array(
    		'J' => 11,
		    'Q' => 12,
		    'K' => 13,
		    'A' => 14
	    );
    	return $map[$letter];
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
