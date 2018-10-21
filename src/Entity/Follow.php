<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FollowRepository")
 */
class Follow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $followCounter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="follows")
     */
    private $team;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowCounter(): ?int
    {
        return $this->followCounter;
    }

    public function setFollowCounter(int $followCounter): self
    {
        $this->followCounter = $followCounter;

        return $this;
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
}
