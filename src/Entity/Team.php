<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @UniqueEntity("email", message = "Cette addresse mail est déjà utilisée")
 */
class Team
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ETweet", mappedBy="team")
     */
    private $eTweets;

    public function __construct()
    {
        $this->eTweets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|ETweet[]
     */
    public function getETweets(): Collection
    {
        return $this->eTweets;
    }

    public function addETweet(ETweet $eTweet): self
    {
        if (!$this->eTweets->contains($eTweet)) {
            $this->eTweets[] = $eTweet;
            $eTweet->setTeam($this);
        }

        return $this;
    }

    public function removeETweet(ETweet $eTweet): self
    {
        if ($this->eTweets->contains($eTweet)) {
            $this->eTweets->removeElement($eTweet);
            // set the owning side to null (unless already changed)
            if ($eTweet->getTeam() === $this) {
                $eTweet->setTeam(null);
            }
        }

        return $this;
    }
}
