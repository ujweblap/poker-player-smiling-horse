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
		return 0;
	}
}