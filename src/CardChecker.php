<?php

namespace SmilingHorse;

class CardChecker
{
    protected $handCards;
    protected $communityCards;
    protected $allCards;

    const NOTHING = 0;
    const PAIR = 1;
    const TWO_PAIR = 2;
    const DRILL = 3;
    const STRAIGHT = 4;
    const FLUSH = 5;
    const FULL_HOUSE = 6;
    const POKER = 7;
    const STRAIGHT_FLUSH = 8;
    const ROYAL_FLUSH = 9;

    public $card_number_map = array(
	    '2' => 2,
	    '3' => 3,
	    '4' => 4,
	    '5' => 5,
	    '6' => 6,
	    '7' => 7,
	    '8' => 8,
	    '9' => 9,
	    '10' => 10,
	    'J' => 11,
	    'Q' => 12,
	    'K' => 13,
	    'A' => 14
    );

    /**
     * CardChecker constructor.
     * @param $handCards
     * @param $communityCards
     */
    public function __construct($handCards, $communityCards)
    {
        $this->handCards = $this->convertCardRank($handCards);
        $this->communityCards = $this->convertCardRank($communityCards);
        $this->allCards = array_merge($this->handCards, $this->communityCards);
    }

    public function getWhatWeHave()
    {
        $weHave = static::NOTHING;

        if ($this->hasPoker()) {
            $weHave = static::POKER;
        } elseif ($this->hasFullHouse()) {
            $weHave = static::FULL_HOUSE;
        } elseif ($this->hasFlush()) {
            $weHave = static::FLUSH;
        } elseif ($this->hasStraight()) {
            $weHave = static::STRAIGHT;
        } elseif ($this->hasDrill()) {
            $weHave = static::DRILL;
        } elseif ($this->hasPair(true)) {
            $weHave = static::TWO_PAIR;
        } elseif ($this->hasPair()) {
            $weHave = static::PAIR;
        }

        return $weHave;
    }

    public function hasPair($double = false)
    {
        foreach ($this->getAllCardCounts() as $cardCount) {
            if ($cardCount == 2) {
                if ($double) {
                    $double = false;
                    continue;
                }

                return true;
            }
        }
        return false;
    }

    public function hasDrill()
    {
        foreach ($this->getAllCardCounts() as $cardCount) {
            if ($cardCount == 3) {
                return true;
            }
        }
        return false;
    }

    public function hasStraight()
    {
        $straightCount = 0;
        $lastCardRank = false;
        foreach ($this->allCards as $card) {
            if($lastCardRank === false || $lastCardRank != $card['rank'] - 1)
            {
                $lastCardRank = $card['rank'];
                $straightCount = 1;
                continue;
            }

            $lastCardRank = $card['rank'];
            $straightCount++;

            if($straightCount == 5)
            {
                return true;
            }
        }

        return false;
    }

    public function hasFlush()
    {
        foreach ($this->getAllCardSuitCounts() as $suitCount) {
            if($suitCount > 4)
            {
                return true;
            }
        }

        return false;
    }

    public function hasFullHouse()
    {
        return $this->hasDrill() && $this->hasPair();
    }

    public function hasPoker()
    {
        foreach ($this->getAllCardCounts() as $cardCount) {
            if ($cardCount == 4) {
                return true;
            }
        }
        return false;
    }

    public function getAllCardCounts()
    {
        $cards = [];

        foreach ($this->handCards as $handCard) {
            if (!isset($cards[$handCard['rank']])) {
                $cards[$handCard['rank']] = 1;
                continue;
            }

            $cards[$handCard['rank']]++;
        }

        foreach ($this->communityCards as $communityCard) {
            if (!isset($cards[$communityCard['rank']])) {
                $cards[$communityCard['rank']] = 1;
                continue;
            }

            $cards[$communityCard['rank']]++;
        }

        return $cards;
    }

    public function getAllCardSuitCounts()
    {
        $suits = [];

        foreach ($this->handCards as $handCard) {
            if (!isset($suits[$handCard['suit']])) {
                $suits[$handCard['suit']] = 1;
                continue;
            }

            $suits[$handCard['suit']]++;
        }

        foreach ($this->communityCards as $communityCard) {
            if (!isset($suits[$communityCard['suit']])) {
                $suits[$communityCard['suit']] = 1;
                continue;
            }

            $suits[$communityCard['suit']]++;
        }

        return $suits;
    }

    public function getCardCounts()
    {
        return [
            $this->handCards[0]['rank'] => $this->countCards($this->handCards[0]),
            $this->handCards[1]['rank'] => $this->countCards($this->handCards[1]),
        ];
    }

	public function countCards($single_card) {
		$count = 0;
		foreach ($this->allCards as $card) {
			if ($card['rank'] === $single_card['rand']) {
				$count++;
			}
		}
		return $count;
	}

	public function check9orHigher() {
		$card1 = $this->handCards[0]['rank'];
		$card2 = $this->handCards[1]['rank'];
		if (!is_numeric($card1)) {
			$card1 = $this->mapLetterToNumber($card1);
		}
		if (!is_numeric($card2)) {
			$card2 = $this->mapLetterToNumber($card2);
		}
		if ($card1 >= 9 && $card2 >= 9) {
			return true;
		}
		return false;
	}

	public function convertCardRank($cards) {
    	for ($i=0;$i<count($cards);$i++) {
    		$cards[$i]['rank'] = $this->mapLetterToNumber($cards[$i]['rank']);
	    }
	    return $cards;
	}

	public function mapLetterToNumber($letter) {
		return $this->card_number_map[$letter];
	}
}