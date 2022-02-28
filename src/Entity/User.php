<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serialization;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serialization\Groups({"user"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serialization\Groups({"user"})
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serialization\Groups({"user"})
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serialization\Groups({"user"})
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serialization\Groups({"user"})
     */
    private string $email;

    /**
     * @ORM\Column(type="datetime")
     * @Serialization\Groups({"user"})
     */
    private \DateTime $birthDate;

    /**
     * @ORM\Column(type="datetime")
     * @Serialization\Groups({"user"})
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string")
     */
    private string $salt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Housing", mappedBy="owner")
     * @Serialization\Groups({"user"})
     * @Serialization\MaxDepth(2)
     */
    private Collection $housings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rent", mappedBy="renter")
     * @Serialization\Groups({"user"})
     * @Serialization\MaxDepth(2)
     */
    private Collection $rents;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->salt = uniqid();
        $this->housings = new ArrayCollection();
        $this->rents = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate): User
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): User
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): User
    {
        $this->salt = $salt;

        return $this;
    }

    public function getHousings(): Collection
    {
        return $this->housings;
    }

    public function setHousings(Collection $housings): User
    {
        $this->housings = $housings;

        return $this;
    }

    public function addHousing(Housing $housing): bool
    {
        if (!$this->housings->containsKey($housing->getId())) {
            $this->housings->set($housing->getId(), $housing);

            return true;
        }

        return false;
    }

    public function removeHousing(Housing $housing): bool
    {
        if ($this->housings->containsKey($housing->getId())) {
            return $this->housings->remove($housing->getId());
        }

        return false;
    }

    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function setRents(Collection $rents): User
    {
        $this->rents = $rents;

        return $this;
    }

    public function addRent(Rent $rent): bool
    {
        if (!$this->rents->containsKey($rent->getId())) {
            $this->rents->set($rent->getId(), $rent);

            return true;
        }

        return false;
    }

    public function removeRent(Rent $rent): bool
    {
        if ($this->rents->containsKey($rent->getId())) {
            return $this->rents->remove($rent->getId());
        }

        return false;
    }
}
