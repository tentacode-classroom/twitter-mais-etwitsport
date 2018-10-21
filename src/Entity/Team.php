<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @UniqueEntity("email", message = "Cette addresse mail est déjà utilisée")
 */
class Team implements UserInterface, \Serializable
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatarFileName;

    /**
     * @Assert\Image(
     *     maxSize = "2048k",
     *     mimeTypesMessage = "Max size is 2Mb."
     * )
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RT", mappedBy="team")
     */
    private $rTs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="team")
     */
    private $votes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Follow", mappedBy="follower")
     */
    private $follows;

    public function __construct()
    {
        $this->eTweets = new ArrayCollection();
        $this->rTs = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->follows = new ArrayCollection();
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

    public function getAvatarFileName(): ?string
    {
        return $this->avatarFileName;
    }

    public function setAvatarFileName(?string $avatarFileName): self
    {
        $this->avatarFileName = $avatarFileName;

        return $this;
    }

    public function getAvatar(): ?UploadedFile
    {
        return $this->avatar;
    }

    public function setAvatar(UploadedFile $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    public function eraseCredentials()
    {
    }

    /**
     * @Assert\IsTrue(message="The password cannot match your name")
     */
    public function isPasswordSafe()
    {
        return $this->name !== $this->password;
    }


    public function __toString(): string
    {
        return $this->name;
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
            $rT->setTeam($this);
        }

        return $this;
    }

    public function removeRT(RT $rT): self
    {
        if ($this->rTs->contains($rT)) {
            $this->rTs->removeElement($rT);
            // set the owning side to null (unless already changed)
            if ($rT->getTeam() === $this) {
                $rT->setTeam(null);
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
            $vote->setTeam($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getTeam() === $this) {
                $vote->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Follow[]
     */
    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function addFollow(Follow $follow): self
    {
        if (!$this->follows->contains($follow)) {
            $this->follows[] = $follow;
            $follow->setFollower($this);
        }

        return $this;
    }

    public function removeFollow(Follow $follow): self
    {
        if ($this->follows->contains($follow)) {
            $this->follows->removeElement($follow);
            // set the owning side to null (unless already changed)
            if ($follow->getFollower() === $this) {
                $follow->setFollower(null);
            }
        }

        return $this;
    }
}
