<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serialization;

/**
 * @ORM\Entity()
 */
class Availability
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serialization\Groups({"housing"})
     */
    private int $id;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Housing", inversedBy="availabilities")
     */
    private Housing $housing;

    /**
     * @ORM\Column(type="datetime")
     * @Serialization\Groups({"housing"})
     */
    private \DateTime $dateFrom;


    /**
     * @ORM\Column(type="datetime")
     * @Serialization\Groups({"housing"})
     */
    private \DateTime $dateTo;

    /**
     * @ORM\Column(type="float")
     * @Serialization\Groups({"housing"})
     */
    private float $pricePerDay;

    public function __construct(Housing $housing, \DateTime $dateFrom, \DateTime $dateTo)
    {
        $this->housing = $housing;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHousing(): Housing
    {
        return $this->housing;
    }

    public function setHousing(Housing $housing): Availability
    {
        $this->housing = $housing;

        return $this;
    }

    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTime $dateFrom): Availability
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTime $dateTo): Availability
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    public function getPricePerDay(): float
    {
        return $this->pricePerDay;
    }

    public function setPricePerDay(float $pricePerDay): Availability
    {
        $this->pricePerDay = $pricePerDay;

        return $this;
    }
}