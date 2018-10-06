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
    const FOUR_OF_A_KIND = 7;
    const STRAIGHT_FLUSH = 8;
    const ROYAL_FLUSH = 9;

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
}