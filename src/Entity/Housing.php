<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serialization;

/**
 * @ORM\Entity()
 */
class Housing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serialization\Groups({"housing"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serialization\Groups({"user", "housing"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serialization\Groups({"user", "housing"})
     */
    private string $address;

    /**
     * @ORM\Column(type="string", length=10)
     * @Serialization\Groups({"user", "housing"})
     */
    private string $zipCode;

    /**
     * @ORM\Column(type="string", length=50)
     * @Serialization\Groups({"user", "housing"})
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=150)
     * @Serialization\Groups({"user", "housing"})
     */
    private string $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Availability", mappedBy="housing")
     * @Serialization\Groups({"housing"})
     * @Serialization\MaxDepth(2)
     */
    private Collection $availabilities;

    /**
     * @ORM\Column(type="integer", length=3)
     * @Serialization\Groups({"user", "housing"})
     */
    private int $capacity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="housings")
     * @Serialization\Groups({"housing"})
     */
    private User $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rent", mappedBy="housing")
     * @Serialization\Groups({"housing"})
     */
    private Collection $rents;

    public function __construct()
    {
        $this->availabilities = new ArrayCollection();
        $this->rents = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Housing
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Housing
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): Housing
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): Housing
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Housing
    {
        $this->country = $country;

        return $this;
    }

    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function setAvailabilities(Collection $availabilities): Housing
    {
        $this->availabilities = $availabilities;

        return $this;
    }

    public function addAvailability(Availability $availability): bool
    {
        if (!$this->availabilities->containsKey($availability->getId())) {
            $this->availabilities->set($availability->getId(), $availability);

            return true;
        }

        return false;
    }

    public function removeAvailability(Availability $availability): bool
    {
        if ($this->availabilities->containsKey($availability->getId())) {
            return $this->availabilities->remove($availability->getId());
        }

        return false;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): Housing
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): Housing
    {
        $this->owner = $owner;

        return $this;
    }


    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function setRents(Collection $rents): self
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