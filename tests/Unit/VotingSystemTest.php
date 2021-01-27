<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class VotingSystemTest extends TestCase
{


    public function testWinnerWithTimestamp()
    {

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetFirstWinner()
    {

        $input = ["ben", "alice", "alice", "alice", "ben", "jack"];

        $this->assertEquals('alice', $this->getFirstWinner($input));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGeMultiWinner()
    {
        $input = ["james", "alice", "alice", "ben", "ben", "jack"];
        $this->assertEqualsCanonicalizing(['ben', 'alice'], $this->getMultiWinner($input));
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWinnerByAlphabetically()
    {
        $input = ["james", "ben", "ben", "ben", "alice", "alice", "alice", "jack"];
        $this->assertEquals('alice', $this->getWinnerByAlphabetically($input));
    }


    public function getWinnerByAlphabetically(array $votes)
    {
        $voteMapper = $this->getMultiWinner($votes);
        sort($voteMapper);
        return $voteMapper[0];
    }

    // return
    public function getMultiWinner($votes): array
    {
        $voteMapper = $this->generateVotingMapper($votes);
        $highest = $voteMapper[array_key_first($voteMapper)];

        $newFilter = [];

        foreach ($voteMapper as $name => $voteCounter) {
            if ($voteCounter === $highest) {
                $newFilter[] = $name;
            } else {
                break;
            }
        }

        return $newFilter;
    }

    // this doesn't handle tie problem
    public function getFirstWinner($votes): string
    {
        $voteMapper = $this->generateVotingMapper($votes);

        return array_key_first($voteMapper);
    }


    public function generateVotingMapper($votes): array
    {
        $voteMapper = [];

        foreach ($votes as $vote) {
            if (!isset($voteMapper[$vote])) {
                $voteMapper[$vote] = 1;
                continue;
            }
            $voteMapper[$vote]++;
        }
        uksort(
            $voteMapper,
            function ($nameA, $nameB) use ($voteMapper) {
                return $voteMapper[$nameB] - $voteMapper[$nameA];
            }
        );
        return $voteMapper;
    }

}
