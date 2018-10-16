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
}

