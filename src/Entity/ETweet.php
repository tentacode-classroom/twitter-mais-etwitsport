<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ETweetRepository")
 */
class ETweet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="eTweets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RT", mappedBy="ETweet")
     */
    private $rTs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="eTweet")
     */
    private $votes;

    public function __construct()
    {
        $this->rTs = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDating(): ?\DateTimeInterface
    {
        return $this->dating;
    }

    public function setDating(\DateTimeInterface $dating): self
    {
        $this->dating = $dating;

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

    public function __toString(): string
    {
        return $this->content;
    }

    /**
     * @return Collection|RT[]
     */
    public function getRTs(): Collection
    {
        return $this->rTs;
    }

    public function addRT(RT $rT): self
    {
        if (!$this->rTs->contains($rT)) {
            $this->rTs[] = $rT;
            $rT->setETweet($this);
        }

        return $this;
    }

    public function removeRT(RT $rT): self
    {
        if ($this->rTs->contains($rT)) {
            $this->rTs->removeElement($rT);
            // set the owning side to null (unless already changed)
            if ($rT->getETweet() === $this) {
                $rT->setETweet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setETweet($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getETweet() === $this) {
                $vote->setETweet(null);
            }
        }

        return $this;
    }
}
