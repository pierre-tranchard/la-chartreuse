<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serialization;

/**
 * @ORM\Entity()
 */
class Rent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serialization\Groups({"user", "housing", "rent"})
     */
    private int $id;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Housing", inversedBy="rents")
     * @Serialization\Groups({"user", "housing", "rent"})
     * @Serialization\MaxDepth(2)
     */
    private Housing $housing;

    /**
     * @ORM\Column(type="datetime")
     * @Serialization\Groups({"user", "housing", "rent"})
     */
    private \DateTime $dateFrom;

    /**
     * @ORM\Column(type="datetime")
     * @Serialization\Groups({"user", "housing", "rent"})
     */
    private \DateTime $dateTo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rents")
     * @Serialization\Groups({"housing", "rent"})
     */
    private User $renter;

    public function __construct(Housing $housing, \DateTime $dateFrom, \DateTime $dateTo, User $renter)
    {
        $this->housing = $housing;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->renter = $renter;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHousing(): Housing
    {
        return $this->housing;
    }

    public function setHousing(Housing $housing): Rent
    {
        $this->housing = $housing;

        return $this;
    }

    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTime $dateFrom): Rent
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTime $dateTo): Rent
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    public function getRenter(): User
    {
        return $this->renter;
    }

    public function setRenter(User $renter): Rent
    {
        $this->renter = $renter;

        return $this;
    }
}