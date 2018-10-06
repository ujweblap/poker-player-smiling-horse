<?php

namespace SmilingHorse;

class PokerLogic
{
    public $GameState;
    public $CardChecker;
    public $PokerPlayer;
    public $logger;
    public $aggression = 1;

    public function __construct($game_state)
    {
        $this->logger = new \SmilingHorse\LoggerInterface();
        $this->logger->getMonolog()->debug('PokerLogic Player hole_cards', [
            $game_state[$game_state['in_action']]['hole_cards'],
            gettype($game_state[$game_state['in_action']]['hole_cards'])
        ]);
        $this->logger->getMonolog()->debug('PokerLogic Community_cards',
            [$game_state['community_cards'], gettype($game_state['community_cards'])]);
        $this->GameState = new GameState($game_state);
        $this->CardChecker = new CardChecker($game_state['players'][$game_state['in_action']]['hole_cards'],
            (is_array($game_state['community_cards']) ? $game_state['community_cards'] : []));
        $this->PokerPlayer = new PokerPlayer($game_state['players'][$game_state['in_action']]);

    }

    public function getBet()
    {
        $to_bet = $this->GameState->getCurrentBuyIn() - $this->GameState->getPlayers()[$this->GameState->getInAction()]->getBet();

        $multiplier = $this->fold();
        if (empty($this->GameState->getCommunityCards())) {
            if ($this->CardChecker->hasHighCards() && $this->CardChecker->getWhatWeHave() == CardChecker::PAIR) {
                $multiplier = $this->raise(2);
            } elseif ($this->CardChecker->getWhatWeHave() == CardChecker::HIGH_CARDS) {
                $multiplier = $this->check();
            } elseif ($this->CardChecker->getWhatWeHave() == CardChecker::PAIR) {
                $multiplier = $this->raise(1.1);
            } elseif ($this->CardChecker->canBeStraightFromHand() && $this->CardChecker->getCountMaxSameColor() == 2) {
                $multiplier = $this->raise(1.2);
            } elseif ($this->CardChecker->getCountMaxSameColor() == 2 && $this->GameState->getPlayers()[$this->GameState->getInAction()]->getBet() < $this->GameState->getSmallBlind() * 2) {
                $multiplier = $this->check();
            }
        } else {
            switch ($this->CardChecker->getWhatWeHave()) {
                case CardChecker::ROYAL_FLUSH:
                    $multiplier = $this->raise(2.6);
                    break;
                case CardChecker::STRAIGHT_FLUSH:
                    $multiplier = $this->raise(2.4);
                    break;
                case CardChecker::POKER:
                    $multiplier = $this->raise(2.2);
                    break;
                case CardChecker::FULL_HOUSE:
                    $multiplier = $this->raise(2);
                    break;
                case CardChecker::FLUSH:
                    $multiplier = $this->raise(1.8);
                    break;
                case CardChecker::STRAIGHT:
                    $multiplier = $this->raise(1.6);
                    break;
                case CardChecker::DRILL:
                    $multiplier = $this->raise(1.4);
                    break;
                case CardChecker::TWO_PAIR:
                    $multiplier = $this->raise(1.3);
                    break;
                case CardChecker::PAIR:
                    $multiplier = $this->check();
                    break;
                case CardChecker::NOTHING:
                case CardChecker::HIGH_CARDS:
                default:
                    $multiplier = $this->fold();
                    break;
            }
            if ($multiplier == $this->fold() && sizeof($this->GameState->getCommunityCards()) == 3) {
                if ($this->CardChecker->getCountMaxSameColor() == 4 || $this->CardChecker->canBeStraight()) {
                    $multiplier = $this->check();
                }
            }
            if ($multiplier == $this->fold() && sizeof($this->GameState->getCommunityCards()) >= 3) {
                if ($this->CardChecker->canBeStraight()) {
                    $multiplier = $this->check();
                }
            }
        }


        if ($this->CardChecker->getWhatWeHave() >= CardChecker::DRILL) {
            $multiplier = $this->raise(3);
        }
        
		if ($multiplier == $this->check()) return $to_bet;
		if ($multiplier <= 1.2) return $to_bet;
		return $multiplier > 1.2 ? ($to_bet) + ($multiplier * ($this->GameState->minimum_raise)) : 0;
    }

    protected function fold()
    {
        return 0;
    }

    public function check()
    {
        return 1;
    }

    public function raise($multiplier)
    {
        return $this->aggression * $multiplier;
    }

    public function doBluff()
    {
        $random = rand(0, $this->GameState->getRound()) * rand(10, 50);

        if ($random == 0) {
            return false;
        }

        return $random % 3;
    }
}