<?php

namespace App\Services\League\Classes;

class CalculateGoals
{
    private const WON_POINT = 3;

    private const LOSE_POINT = 2;

    /**
     * @param \App\Services\League\Entities\Team[] $teams
     */
    public function __construct(private array $teams)
    {
    }

    public function calculate(): array
    {
        $team_0_result = $this->calculatePoints(0);

        $team_1_result = $this->calculatePoints(1);

        if($team_0_result && $team_1_result){
            return [self::WON_POINT, self::WON_POINT];
        }elseif(!$team_1_result && !$team_0_result){
            return [self::LOSE_POINT, self::LOSE_POINT];
        }elseif($team_0_result){
            return [self::WON_POINT, self::LOSE_POINT];
        }else{
            return [self::LOSE_POINT, self::WON_POINT];
        }

    }

    protected function calculatePoints(int $index): bool
    {
        return rand(1, 100) <= $this->teams[$index]->getPrediction();
    }
}