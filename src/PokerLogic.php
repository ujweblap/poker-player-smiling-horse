<?php

namespace SmilingHorse;

class PokerLogic {
	public $GameState;
	public $CardChecker;
	public $PokerPlayer;

	public function __construct($game_state) {
		$this->GameState = new GameState($game_state);
		$this->CardChecker = new CardChecker($game_state[$game_state['in_action']]['hole_cards'], $game_state['community_cards']);
		$this->PokerPlayer = new PokerPlayer($game_state[$game_state['in_action']]);

	}
	
	public function getBet() {
		$to_bet = $this->GameState->getCurrentBuyIn() + $this->GameState->getPlayers()[$this->GameState->getInAction()]->getBet();

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