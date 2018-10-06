<?php
/**
 * Created by PhpStorm.
 * User: mihalyfijanos
 * Date: 2018. 10. 06.
 * Time: 10:11
 */
namespace SmilingHorse;
class PokerPlayer
{
	public $name;
	public $stack;
	public $status;
	public $bet;
	public $hole_cards;
	public $version;
	public $id;

	public function __construct($player_array)
	{
		$this->name = $player_array['name'];
		$this->stack = $player_array['stack'];
		$this->status = $player_array['status'];
		$this->bet = $player_array['bet'];
		$this->hole_cards = $player_array['hole_cards'];
		$this->version = $player_array['version'];
		$this->id = $player_array['id'];
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getStack()
	{
		return $this->stack;
	}

	/**
	 * @return mixed
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getBet()
	{
		return $this->bet;
	}

	/**
	 * @return mixed
	 */
	public function getHoleCards()
	{
		return $this->hole_cards;
	}

	/**
	 * @return mixed
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
}