<?php
/**
 * Created by PhpStorm.
 * User: mihalyfijanos
 * Date: 2018. 10. 06.
 * Time: 10:10
 */
namespace SmilingHorse;
class GameState
{
	public $players = array();
	public $tournament_id;
	public $game_id;
	public $round;
	public $bet_index;
	public $small_blind;
	public $orbits;
	public $in_action;
	public $dealer;
	public $community_cards;
	public $current_buy_in;
	public $pot;

	public function __construct($game_state_array)
	{
		foreach ($game_state_array['player'] as $player_data) {
			$this->players[] = new Player($player_data);
		}
		$this->tournament_id = $game_state_array['tournament_id'];
		$this->game_id = $game_state_array['game_id'];
		$this->round = $game_state_array['round'];
		$this->bet_index = $game_state_array['bet_index'];
		$this->small_blind = $game_state_array['small_blind'];
		$this->orbits = $game_state_array['orbits'];
		$this->in_action = $game_state_array['in_action'];
		$this->dealer = $game_state_array['dealer'];
		$this->community_cards = $game_state_array['community_cards'];
		$this->current_buy_in = $game_state_array['current_buy_in'];
		$this->pot = $game_state_array['pot'];
	}

	/**
	 * @return array
	 */
	public function getPlayers()
	{
		return $this->players;
	}

	/**
	 * @param Player $player
	 */
	public function addPlayer($player)
	{
		$this->players[] = $player;
	}

	/**
	 * @return mixed
	 */
	public function getTournamentId()
	{
		return $this->tournament_id;
	}

	/**
	 * @param mixed $tournament_id
	 */
	public function setTournamentId($tournament_id)
	{
		$this->tournament_id = $tournament_id;
	}

	/**
	 * @return mixed
	 */
	public function getGameId()
	{
		return $this->game_id;
	}

	/**
	 * @param mixed $game_id
	 */
	public function setGameId($game_id)
	{
		$this->game_id = $game_id;
	}

	/**
	 * @return mixed
	 */
	public function getRound()
	{
		return $this->round;
	}

	/**
	 * @param mixed $round
	 */
	public function setRound($round)
	{
		$this->round = $round;
	}

	/**
	 * @return mixed
	 */
	public function getBetIndex()
	{
		return $this->bet_index;
	}

	/**
	 * @param mixed $bet_index
	 */
	public function setBetIndex($bet_index)
	{
		$this->bet_index = $bet_index;
	}

	/**
	 * @return mixed
	 */
	public function getSmallBlind()
	{
		return $this->small_blind;
	}

	/**
	 * @param mixed $small_blind
	 */
	public function setSmallBlind($small_blind)
	{
		$this->small_blind = $small_blind;
	}

	/**
	 * @return mixed
	 */
	public function getOrbits()
	{
		return $this->orbits;
	}

	/**
	 * @param mixed $orbits
	 */
	public function setOrbits($orbits)
	{
		$this->orbits = $orbits;
	}

	/**
	 * @return mixed
	 */
	public function getInAction()
	{
		return $this->in_action;
	}

	/**
	 * @param mixed $in_action
	 */
	public function setInAction($in_action)
	{
		$this->in_action = $in_action;
	}

	/**
	 * @return mixed
	 */
	public function getDealer()
	{
		return $this->dealer;
	}

	/**
	 * @param mixed $dealer
	 */
	public function setDealer($dealer)
	{
		$this->dealer = $dealer;
	}

	/**
	 * @return mixed
	 */
	public function getCommunityCards()
	{
		return $this->community_cards;
	}

	/**
	 * @param mixed $community_cards
	 */
	public function setCommunityCards($community_cards)
	{
		$this->community_cards = $community_cards;
	}

	/**
	 * @return mixed
	 */
	public function getCurrentBuyIn()
	{
		return $this->current_buy_in;
	}

	/**
	 * @param mixed $current_buy_in
	 */
	public function setCurrentBuyIn($current_buy_in)
	{
		$this->current_buy_in = $current_buy_in;
	}

	/**
	 * @return mixed
	 */
	public function getPot()
	{
		return $this->pot;
	}

	/**
	 * @param mixed $pot
	 */
	public function setPot($pot)
	{
		$this->pot = $pot;
	}



}