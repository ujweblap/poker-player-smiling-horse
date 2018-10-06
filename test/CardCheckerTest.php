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
                    'suit' => 'spades',
                ],
                [
                    'rank' => 'A',
                    'suit' => 'spades',
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

        $this->assertEquals(CardChecker::TWO_PAIR, $cardChecker->getWhatWeHave());
    }
}