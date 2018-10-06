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
		$pokerLogic = new \SmilingHorse\PokerLogic($game_state);
		$bet = $pokerLogic->getBet();
		if (!is_numeric($bet)) {
			$this->logger->getMonolog()->debug('Bet not a number! ', [$bet]);
			return 0;
		}
		return $bet;
    }

    public function showdown($game_state)
    {
    }
}
