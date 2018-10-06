<?php

namespace SmilingHorse;

class PokerLogic
{
    public $GameState;
    public $CardChecker;
    public $PokerPlayer;
    public $logger;

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

        $multiplier = 0;
        if (empty($this->GameState->getCommunityCards())) {
            if ($this->CardChecker->hasHighCards() && $this->CardChecker->getWhatWeHave() == CardChecker::PAIR) {
                $multiplier = 2;
            } elseif ($this->CardChecker->getWhatWeHave() == CardChecker::HIGH_CARDS) {
                $multiplier = 1;
            } elseif ($this->CardChecker->getWhatWeHave() == CardChecker::PAIR) {
                $multiplier = 1.1;
            } elseif ($this->CardChecker->canBeStraightFromHand() && $this->CardChecker->getCountMaxSameColor() == 2) {
                $multiplier = 1.2;
            } elseif ($this->CardChecker->getCountMaxSameColor() == 2 && $this->GameState->getPlayers()[$this->GameState->getInAction()]->getBet() < $this->GameState->getSmallBlind() * 2) {
                $multiplier = 1;
            }
        } else {
            switch ($this->CardChecker->getWhatWeHave()) {
                case CardChecker::ROYAL_FLUSH:
                    $multiplier = 2.6;
                    break;
                case CardChecker::STRAIGHT_FLUSH:
                    $multiplier = 2.4;
                    break;
                case CardChecker::POKER:
                    $multiplier = 2.2;
                    break;
                case CardChecker::FULL_HOUSE:
                    $multiplier = 2;
                    break;
                case CardChecker::FLUSH:
                    $multiplier = 1.8;
                    break;
                case CardChecker::STRAIGHT:
                    $multiplier = 1.6;
                    break;
                case CardChecker::DRILL:
                    $multiplier = 1.4;
                    break;
                case CardChecker::TWO_PAIR:
                    $multiplier = 1.2;
                    break;
                case CardChecker::PAIR:
                    $multiplier = 1.0;
                    break;
                case CardChecker::NOTHING:
                case CardChecker::HIGH_CARDS:
                default:
                    $multiplier = 0;
                    break;
            }
            if ($multiplier == 0 && sizeof($this->GameState->getCommunityCards()) == 3) {
                if ($this->CardChecker->getCountMaxSameColor() == 4 || $this->CardChecker->canBeStraight()) {
                    $multiplier = 1;
                }
            }
            if ($multiplier == 0 && sizeof($this->GameState->getCommunityCards()) >= 3) {
                if ($this->CardChecker->canBeStraight()) {
                    $multiplier = 1;
                }
            }
        }


        if ($this->CardChecker->getWhatWeHave() >= CardChecker::DRILL) {
            $multiplier = 3;
        }

		return $multiplier > 0 ? ($to_bet) * ($multiplier * ($this->GameState->minimum_raise)) : 0;
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