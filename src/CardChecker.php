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

    /**
     * CardChecker constructor.
     * @param $handCards
     * @param $communityCards
     */
    public function __construct($handCards, $communityCards)
    {
        $this->handCards = $handCards;
        $this->communityCards = $communityCards;
        $this->allCards = array_merge($handCards, $communityCards);
    }

    public function getWhatWeHave()
    {
        $weHave = static::NOTHING;

        $firstPair = $this->hasPair();
        if($firstPair !== false) {
            if($this->hasPair($firstPair) !== false)
            {
                $weHave = static::TWO_PAIR;
            } else {
                $weHave = static::PAIR;
            }
        }

        return $weHave;
    }

    public function hasPair($expectRank = false)
    {
        foreach ($this->allCards as $i => $card) {
            foreach ($this->allCards as $i2 => $card2) {
                if ($i !== $i2) {
                    if ($card['rank'] == $card2['rank'] && (!$expectRank || $card['rank'] != $expectRank)) {
                        return $card['rank'];
                    }
                }
            }
        }
        return false;
    }

	public function getCardCounts() {
		return array(
			$this->handCards[0]['rank'] => $this->countCards($this->handCards[0]),
			$this->handCards[1]['rank'] => $this->countCards($this->handCards[1]),
		);
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
}