<?php

namespace Tests\Unit\League\Strategies;

use App\Services\League\Strategies\PlayWeekStrategy;

class PlayWeekStrategyTest extends StrategyPlay
{
    public function providerForFourTeams()
    {
        return [
            [
                [
                    'a123' => 2,
                    'b234' => 3,
                    'c12345' => 2,
                    'd12346' => 3
                ]
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->match->method('getTeams')->willReturn([
            $this->team, $this->team
        ]);
    }

    /**
     * @dataProvider providerForFourTeams
     */
    public function testThatResultsAreWithCorrectStructure($teams)
    {
        $this->checkThatResultsAreWithCorrectStructure($teams, new PlayWeekStrategy());
    }

    /**
     * @dataProvider providerForFourTeams
     */
    public function testThatCurrentWeekIsLastAfterPlayWhenStarted($teams)
    {
        $this->addConsecutiveCalls($teams);

        $playWeekStrategy = new PlayWeekStrategy();

        $current_week = 0;

        $results = $playWeekStrategy->play(
            1,
            $current_week,
            [$this->match, $this->match]
        );

        $this->assertEquals($current_week + 1, $results['week']);
    }

    /**
     * @dataProvider providerForFourTeams
     */
    public function testThatCurrentWeekIsLastAfterPlayWhenAnyAllowed($teams)
    {
        $this->addConsecutiveCalls($teams);

        $playWeekStrategy = new PlayWeekStrategy();

        $results = $playWeekStrategy->play(
            1,
            1,
            [$this->match, $this->match]
        );

        $this->assertEquals(2, $results['week']);
    }
}
