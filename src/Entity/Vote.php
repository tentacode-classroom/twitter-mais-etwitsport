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
    private $TotalVote;

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

    public function getTotalVote(): ?int
    {
        return $this->TotalVote;
    }

    public function setTotalVote(int $TotalVote): self
    {
        $this->TotalVote = $TotalVote;

        return $this;
    }

    public function upVote()
    {
        $this->TotalVote+=1;
    }

    public function downVote()
    {
        $this->TotalVote-=1;
    }
}
