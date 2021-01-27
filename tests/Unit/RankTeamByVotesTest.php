<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class RankTeamByVotesTest extends TestCase
{

    /**
     * @param String[] $votes
     * @return String
     */
    public function testRankTeams2()
    {
        $votes = ["ABC", "ACB", "ABC", "ACB", "ACB"];
        $positions = strlen($votes[0]);

        $participants = str_split($votes[0]);

        $votingMapper = [];

        // o(n)
        foreach ($participants as $name) {
            $votingMapper[$name] = array_fill(0, $positions, 0);
        }

        // O(n)
        foreach ($votes as $voteString) {
            $voteStringArray = str_split($voteString);
            foreach ($voteStringArray as $position => $vote) {
                $votingMapper[$vote][$position]++;
            }
        }

        uksort($votingMapper,
            function ($keyA, $keyB) use ($votingMapper) {
                $keyAValues = $votingMapper[$keyA];
                $keyBValues = $votingMapper[$keyB];
                foreach ($keyAValues as $key => $position) {
                    $cmp = $keyBValues[$key] - $position;

                    if ($cmp === 0) {
                        continue;
                    }
                    return $cmp;
                }
                return $keyA > $keyB ? 1 : -1;
            }
        );
        $res = implode(array_keys($votingMapper));

        return $res;
    }

}
