<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RTRepository")
 */
class RT
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="rTs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ETweet", inversedBy="rTs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ETweet;

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
        return $this->ETweet;
    }

    public function setETweet(?ETweet $ETweet): self
    {
        $this->ETweet = $ETweet;

        return $this;
    }
}
