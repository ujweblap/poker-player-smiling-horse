<?php

namespace SmilingHorse;

class PokerLogic {
	public $GameState;
	public $CardChecker;
	public $PokerPlayer;
	public $logger;

	public function __construct($game_state) {
		$this->logger = new \SmilingHorse\LoggerInterface();
		$this->logger->getMonolog()->debug('PokerLogic Player hole_cards', [$game_state[$game_state['in_action']]['hole_cards'], gettype($game_state[$game_state['in_action']]['hole_cards'])]);
		$this->logger->getMonolog()->debug('PokerLogic Community_cards', [$game_state['community_cards'], gettype($game_state['community_cards'])]);
		$this->GameState = new GameState($game_state);
		$this->CardChecker = new CardChecker($game_state['players'][$game_state['in_action']]['hole_cards'], (is_array($game_state['community_cards'])?$game_state['community_cards']:[]));
		$this->PokerPlayer = new PokerPlayer($game_state['players'][$game_state['in_action']]);

	}

	public function getBet() {
		$to_bet = $this->GameState->getCurrentBuyIn() - $this->GameState->getPlayers()[$this->GameState->getInAction()]->getBet();

		$multiplier = 0;
		if (empty($this->GameState->getCommunityCards())) {
			if ($this->CardChecker->getWhatWeHave() == CardChecker::HIGH_CARDS && $this->CardChecker->getWhatWeHave() == CardChecker::PAIR) {
				$multiplier = 2;
			} else if ($this->CardChecker->getWhatWeHave() == CardChecker::HIGH_CARDS) {
				$multiplier = 1;
			} else if ($this->CardChecker->getWhatWeHave() == CardChecker::PAIR) {
				$multiplier = 1.1;
			}
		} else {
			switch ($this->CardChecker->getWhatWeHave()) {
				case CardChecker::NOTHING:
					$multiplier = 0;
					break;
				case CardChecker::HIGH_CARDS:
					$multiplier = 1;
					break;
				case CardChecker::PAIR:
					$multiplier = 1.1;
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
		}

		return $to_bet * $multiplier;
	}
}