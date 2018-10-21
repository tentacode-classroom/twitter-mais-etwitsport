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
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="follows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $follower;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="follows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $followed;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollower(): ?Team
    {
        return $this->follower;
    }

    public function setFollower(?Team $follower): self
    {
        $this->follower = $follower;

        return $this;
    }

    public function getFollowed(): ?Team
    {
        return $this->followed;
    }

    public function setFollowed(?Team $followed): self
    {
        $this->followed = $followed;

        return $this;
    }
}
