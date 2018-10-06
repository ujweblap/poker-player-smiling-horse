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

        if ($this->hasPoker()) {
            $weHave = static::POKER;
        } elseif ($this->hasFullHouse()) {
            $weHave = static::FULL_HOUSE;
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

    public function getCardCounts()
    {
        return [
            $this->handCards[0]['rank'] => $this->countCards($this->handCards[0]),
            $this->handCards[1]['rank'] => $this->countCards($this->handCards[1]),
        ];
    }

    public function countCards($single_card)
    {
        $count = 0;
        foreach ($this->allCards as $card) {
            if ($card['rank'] === $single_card['rand']) {
                $count++;
            }
        }
        return $count;
    }
}