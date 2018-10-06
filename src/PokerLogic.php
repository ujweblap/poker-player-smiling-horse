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

	const STRAIGHT = 4;
	const FLUSH = 5;
	const FULL_HOUSE = 6;
	const FOUR_OF_A_KIND = 7;
	const STRAIGHT_FLUSH = 8;
	const ROYAL_FLUSH = 9;
	public function getBet() {
		$to_bet = $this->GameState->getCurrentBuyIn() + $this->GameState->getPlayers()[$this->GameState->getInAction()]->getBet();

		switch ($this->CardChecker->getWhatWeHave()) {
			case CardChecker::NOTHING:
			case CardChecker::PAIR:
			case CardChecker::TWO_PAIR:
			case CardChecker::DRILL:
			case CardChecker::STRAIGHT:
			case CardChecker::FLUSH:
			case CardChecker::FULL_HOUSE:
			case CardChecker::FOUR_OF_A_KIND:
			case CardChecker::STRAIGHT_FLUSH:
			case CardChecker::ROYAL_FLUSH:

			default:
				return 0;
		}

		return 0;
	}
}