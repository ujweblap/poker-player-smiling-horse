<?php

namespace SmilingHorse;

class PokerLogic {
	public $GameState;
	public $CardChecker;
	public $PokerPlayer;

	public function __construct($game_state) {
		$this->GameState = new GameState($game_state);
		$this->CardChecker = new CardChecker($game_state['players'][$game_state['in_action']]['hole_cards'], $game_state['community_cards']);
		$this->PokerPlayer = new PokerPlayer($game_state['players'][$game_state['in_action']]);

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
		$to_bet = $this->GameState->getCurrentBuyIn() - $this->GameState->getPlayers()[$this->GameState->getInAction()]->getBet();

		$multiplier = 0;
		switch ($this->CardChecker->getWhatWeHave()) {
			case CardChecker::NOTHING:
				$multiplier = 0;
				break;
			case CardChecker::PAIR:
				$multiplier = 1;
				break;
			case CardChecker::TWO_PAIR:
				$multiplier = 1.2;
				break;
			case CardChecker::DRILL:
				$multiplier = 1.4;
				break;
			case CardChecker::STRAIGHT:
				$multiplier = 1.6;
				break;
			case CardChecker::FLUSH:
				$multiplier = 1.8;
				break;
			case CardChecker::FULL_HOUSE:
				$multiplier = 2;
				break;
			case CardChecker::POKER:
				$multiplier = 2.2;
				break;
			case CardChecker::STRAIGHT_FLUSH:
				$multiplier = 2.4;
				break;
			case CardChecker::ROYAL_FLUSH:
				$multiplier = 2.6;
				break;
			default:
		}
		return (int) $to_bet * $multiplier;
	}
}