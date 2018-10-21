<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ETweet", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eTweet;

    /**
     * @ORM\Column(type="integer")
     */
    private $voteValue = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getETweet(): ?ETweet
    {
        return $this->eTweet;
    }

    public function setETweet(?ETweet $eTweet): self
    {
        $this->eTweet = $eTweet;

        return $this;
    }

    public function getVoteValue(): ?int
    {
        return $this->voteValue;
    }

    public function setVoteValue(int $voteValue = 0): self
    {
        $this->voteValue = $voteValue;

        return $this;
    }
}
