<?php

use PHPUnit\Framework\TestCase;
use SmilingHorse\CardChecker;

class CardCheckerTest extends TestCase {
    protected $cardChecker;

    public function setUp()
    {
        parent::setUp();
    }

    public function testHasPair()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '6',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
            ],
            [
                [
                    'rank' => '8',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '9',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '10',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '4',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ]
        );

        $this->assertEquals(CardChecker::PAIR, $cardChecker->getWhatWeHave());
    }

    public function testHasTwoPair()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '6',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
            ],
            [
                [
                    'rank' => '8',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '8',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '10',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '4',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ]
        );

        $this->assertEquals(CardChecker::TWO_PAIR, $cardChecker->getWhatWeHave());
    }

    public function testHasDrill()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '6',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
            ],
            [
                [
                    'rank' => '9',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '8',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '4',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ]
        );

        $this->assertEquals(CardChecker::DRILL, $cardChecker->getWhatWeHave());
    }

    public function testHasStraight()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '2',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '3',
                    'suit' => 'spades',
                ],
            ],
            [
                [
                    'rank' => '4',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '5',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'K',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ]
        );

        $this->assertEquals(CardChecker::STRAIGHT, $cardChecker->getWhatWeHave());
    }

    public function testHasStraightWithAceAtTheStart()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '3',
                    'suit' => 'spades',
                ],
            ],
            [
                [
                    'rank' => '4',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '2',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'K',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '5',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ]
        );

        $this->assertEquals(CardChecker::STRAIGHT, $cardChecker->getWhatWeHave());
    }

    public function testHasFlush()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '2',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '3',
                    'suit' => 'spades',
                ],
            ],
            [
                [
                    'rank' => 'J',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '5',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'K',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'spades',
                ],
            ]
        );

        $this->assertEquals(CardChecker::FLUSH, $cardChecker->getWhatWeHave());
    }

    public function testHasFullHouse()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '6',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
            ],
            [
                [
                    'rank' => '8',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '8',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '4',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ]
        );

        $this->assertEquals(CardChecker::FULL_HOUSE, $cardChecker->getWhatWeHave());
    }

    public function testHasPoker()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '6',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
            ],
            [
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '8',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '4',
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'spades',
                ],
            ]
        );

        $this->assertEquals(CardChecker::POKER, $cardChecker->getWhatWeHave());
    }

    public function testHasStraightFlush()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '2',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '3',
                    'suit' => 'hearts',
                ],
            ],
            [
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '4',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'spades',
                ],
                [
                    'rank' => '5',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'hearts',
                ],
            ]
        );

        $this->assertEquals(CardChecker::STRAIGHT_FLUSH, $cardChecker->getWhatWeHave());
    }

    public function testHasRoyalFlush()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ],
            [
                [
                    'rank' => '10',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => 'J',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => 'Q',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => 'K',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
            ]
        );

        $this->assertEquals(CardChecker::ROYAL_FLUSH, $cardChecker->getWhatWeHave());
    }

    public function testCanBeStraightFromHandAceBeginning()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '5',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ],
            [
                [
                    'rank' => '2',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '3',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '4',
                    'suit' => 'club',
                ],
                [
                    'rank' => 'K',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
            ]
        );

        $this->assertTrue($cardChecker->canBeStraightFromHand());
    }

    public function testCanBeStraightFromHandAceEnding()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '10',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ],
            [
                [
                    'rank' => '2',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '3',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '4',
                    'suit' => 'club',
                ],
                [
                    'rank' => 'K',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
            ]
        );

        $this->assertTrue($cardChecker->canBeStraightFromHand());
    }

    public function testCanBeStraightFromHand()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '5',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => '9',
                    'suit' => 'hearts',
                ],
            ],
            [
                [
                    'rank' => '2',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '3',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '4',
                    'suit' => 'club',
                ],
                [
                    'rank' => 'K',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
            ]
        );

        $this->assertTrue($cardChecker->canBeStraightFromHand());
    }

    public function testCannotBeStraightFromHand()
    {
        $cardChecker = new \SmilingHorse\CardChecker(
            [
                [
                    'rank' => '9',
                    'suit' => 'clubs',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'hearts',
                ],
            ],
            [
                [
                    'rank' => '2',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '3',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '4',
                    'suit' => 'club',
                ],
                [
                    'rank' => 'K',
                    'suit' => 'hearts',
                ],
                [
                    'rank' => '6',
                    'suit' => 'clubs',
                ],
            ]
        );

        $this->assertFalse($cardChecker->canBeStraightFromHand());
    }
}