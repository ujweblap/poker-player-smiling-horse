<?php

namespace SmilingHorse;

/**
 * Class CardChecker
 * @package SmilingHorse
 */
class CardChecker
{
    protected $handCards;
    protected $communityCards;
    protected $allCards;

    const NOTHING = 0;
    const HIGH_CARDS = 1;
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

        if ($this->hasRoyalFlush()) {
            $weHave = static::ROYAL_FLUSH;
        } elseif ($this->hasStraightFlush() !== false) {
            $weHave = static::STRAIGHT_FLUSH;
        } elseif ($this->hasPoker()) {
            $weHave = static::POKER;
        } elseif ($this->hasFullHouse()) {
            $weHave = static::FULL_HOUSE;
        } elseif ($this->hasFlush() !== false) {
            $weHave = static::FLUSH;
        } elseif ($this->hasStraight() !== false) {
            $weHave = static::STRAIGHT;
        } elseif ($this->hasDrill()) {
            $weHave = static::DRILL;
        } elseif ($this->hasPair(true)) {
            $weHave = static::TWO_PAIR;
        } elseif ($this->hasPair()) {
            $weHave = static::PAIR;
        } elseif ($this->hasHighCards()) {
            $weHave = static::HIGH_CARDS;
        }

        return $weHave;
    }

    public function hasHighCards()
    {
        $card1 = $this->handCards[0]['rank'];
        $card2 = $this->handCards[1]['rank'];
        if ($card1 >= 10 && $card2 >= 10) {
            return true;
        }
        return false;
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

    public function canBeStraightFromHand()
    {
        $biggerCard = max($this->handCards[0]['rank'], $this->handCards[1]['rank']);
        $smallerCard = min($this->handCards[0]['rank'], $this->handCards[1]['rank']);
        if($biggerCard == 14)
        {
            return $biggerCard - $smallerCard < 5 || $smallerCard - 1 < 5;
        }

        return $biggerCard - $smallerCard < 5;
    }

    public function hasStraight()
    {
        $sortedCards = $this->sortCardsByRank($this->addAceToTheBeginning($this->allCards));
        $lastCardRank = false;
        $cards = [];
        foreach ($sortedCards as $card) {
            if ($lastCardRank === false || $lastCardRank != $card['rank'] - 1) {
                $cards = [$card];
                $lastCardRank = $card['rank'];
                continue;
            }

            $cards[] = $card;
            $lastCardRank = $card['rank'];

            if (count($cards) == 5) {
                return $cards;
            }
        }

        return false;
    }

    /**
     * @param bool|array $cards
     * @return bool|int|string
     */
    public function hasFlush($cards = false)
    {
        if (!$cards) {
            $cards = $this->allCards;
        } else {
            $baseCards = $cards;
            $cards = [];
            foreach ($this->allCards as $cardFromAllCard) {
                foreach ($baseCards as $baseCard) {
                    if ($cardFromAllCard['rank'] == $baseCard['rank'] && $cardFromAllCard['suit'] == $baseCard['suit']) {
                        $cards[$cardFromAllCard['suit'] . $cardFromAllCard['rank']] = $cardFromAllCard;
                        continue;
                    }

                    if ($cardFromAllCard['suit'] == $baseCard['suit']) {
                        $cards[$cardFromAllCard['suit'] . $cardFromAllCard['rank']] = $cardFromAllCard;
                    }
                }
            }
        }

        foreach ($this->getAllCardSuitCounts($cards) as $suit => $suitCards) {
            if (count($suitCards) >= min(count($cards), 5)) {
                return $suitCards;
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

    public function hasStraightFlush()
    {
        $straightCards = $this->hasStraight();
        if ($straightCards !== false) {
            return $this->hasFlush($straightCards);
        }

        return false;
    }

    public function hasRoyalFlush()
    {
        $straightCards = $this->hasStraight();
        if ($straightCards !== false) {
            $flushCards = $this->hasFlush($straightCards);
            if($flushCards !== false)
            {
                $flushCards = $this->sortCardsByRank($flushCards);
                return array_shift($flushCards)['rank'] === 10;
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

    public function getAllCardSuitCounts($cards)
    {
        $suits = [];

        foreach ($cards as $card) {
            if (!isset($suits[$card['suit']])) {
                $suits[$card['suit']] = [$card];
                continue;
            }

            $suits[$card['suit']][] = $card;
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

    public function check9orHigher()
    {
        $card1 = $this->handCards[0]['rank'];
        $card2 = $this->handCards[1]['rank'];
        if ($card1 >= 9 && $card2 >= 9) {
            return true;
        }
        return false;
    }

    public function convertCardRank($cards)
    {
        for ($i = 0; $i < count($cards); $i++) {
            $cards[$i]['rank'] = $this->mapLetterToNumber($cards[$i]['rank']);
        }
        return $cards;
    }

    public function mapLetterToNumber($letter)
    {
        return $this->card_number_map[$letter];
    }

    protected function sortCardsByRank($cards)
    {
        usort($cards, function ($a, $b) {
            return $a['rank'] <=> $b['rank'];
        });

        return $cards;
    }

    protected function addAceToTheBeginning($cards)
    {
        foreach ($cards as $card) {
            if($card['rank'] == 13)
            {
                $cards[] = [
                    'rank' => 1,
                    'suit' => $card['suit'],
                ];
            }
        }

        return $cards;
    }
}