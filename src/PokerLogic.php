<?php

namespace SmilingHorse;

use function PHPSTORM_META\type;

class PokerLogic {
	public $GameState;
	public $CardChecker;
	public $PokerPlayer;
	public $logger;

	public function __construct($game_state) {
		$this->logger = new \SmilingHorse\LoggerInterface();
		$this->logger->getMonolog()->debug('PokerLogic Player hole_cards', [$game_state[$game_state['in_action']]['hole_cards'], type($game_state[$game_state['in_action']]['hole_cards'])]);
		$this->logger->getMonolog()->debug('PokerLogic Community_cards', [$game_state['community_cards'], type($game_state['community_cards'])]);
		$this->GameState = new GameState($game_state);
		$this->CardChecker = new CardChecker($game_state[$game_state['in_action']]['hole_cards'], $game_state['community_cards']);
		$this->PokerPlayer = new PokerPlayer($game_state[$game_state['in_action']]);

	}

	public function goAllIn($own_cards, $community_cards) {
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

	public function getBet() {
		//$to_bet = $this->GameState->getCurrentBuyIn() + $this->GameState->getPlayers()[$this->GameState->getInAction()]->getBet();
		$to_bet = 10000;

		$to_call = 0;
		switch ($this->CardChecker->getWhatWeHave()) {
			case CardChecker::NOTHING:
				break;
			case CardChecker::PAIR:
			case CardChecker::TWO_PAIR:
			case CardChecker::DRILL:
			case CardChecker::STRAIGHT:
			case CardChecker::FLUSH:
			case CardChecker::FULL_HOUSE:
			case CardChecker::FOUR_OF_A_KIND:
			case CardChecker::STRAIGHT_FLUSH:
			case CardChecker::ROYAL_FLUSH:
				$to_call = $to_bet;
				break;
			default:
		}

		return $to_call;
	}
}