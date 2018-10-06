<?php

class Player
{
    protected $logger;

    const VERSION = "Hot water for the Lobster";

    public function __construct()
    {
        $this->logger = new \SmilingHorse\LoggerInterface();
    }

    public function betRequest($game_state)
    {
    	try {
		    $this->logger->getMonolog()->debug('Game state', $game_state);
		    $pokerLogic = new \SmilingHorse\PokerLogic($game_state);
		    $bet = $pokerLogic->getBet();
		    if (!is_numeric($bet)) {
			    $this->logger->getMonolog()->debug('Bet not a number! ', [$bet]);
			    return 0;
		    }
			return (int) ceil($bet);
	    } catch (Exception $e) {
		    $this->logger->getMonolog()->debug('Exception! ', [$e->getMessage()]);
    		return 0;
	    }
    }

    public function showdown($game_state)
    {
    }
}
