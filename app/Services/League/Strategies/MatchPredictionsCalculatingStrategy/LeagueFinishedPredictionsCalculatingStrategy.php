<?php

namespace App\Services\League\Strategies\MatchPredictionsCalculatingStrategy;

use App\Services\League\Entities\Team;
use Illuminate\Support\Arr;

class LeagueFinishedPredictionsCalculatingStrategy implements PredictionsCalculatingInterface
{
    public function calculate(array $teams)
    {
        $sorted_teams = $this->getSortedTeams($teams);

        $winner_team = $sorted_teams[0];

        $winner_team->setPrediction(100);

        $other_teams = $this->getOtherTeams($teams, $winner_team);

        foreach ($other_teams as $other_team) {
            $other_team->setPrediction(0);
        }
    }

    /**
     * @param Team[] $teams
     * @return Team[]
     */
    private function getSortedTeams(array $teams): array
    {
        return Arr::sort($teams, function (Team $team) {
            return $team->getPTS();
        });
    }

    /**
     * @param Team[] $teams
     * @param Team $excluded_team
     * @return Team[]
     */
    private function getOtherTeams(array $teams, Team $excluded_team): array
    {
        return Arr::where($teams, function (Team $team) use ($excluded_team) {
            return $team->getUuid() !== $excluded_team->getUuid();
        });
    }
}
