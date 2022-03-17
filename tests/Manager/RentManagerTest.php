<?php

namespace App\Tests\Manager;

use App\Entity\Housing;
use App\Entity\Rent;
use App\Entity\User;
use App\Exception\UnavailableHousingException;
use App\Manager\RentManager;
use App\Repository\RentRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class RentManagerTest extends TestCase
{
    private RentManager $rentManager;

    protected function setUp(): void
    {
        $entityManager = $this->createStub(EntityManagerInterface::class);
        $entityManager
            ->method('persist');
        $entityManager
            ->method('flush');

        $rentRepository = $this->createMock(RentRepository::class);
        $rentRepository->expects(self::any())
            ->method('isAvailable')
            ->willReturnOnConsecutiveCalls(
                true,
                false
            );

        $this->rentManager = new RentManager($entityManager, $rentRepository);
    }

    public function testItCreatesRent(): void
    {
        $from = new \DateTime();
        $to = clone $from;
        $to->add(\DateInterval::createFromDateString("tomorrow"));
        $housing = new Housing();
        $housing->setName("Penthouse");

        self::assertInstanceOf(Rent::class, $this->rentManager->make(new User(), $from, $to, $housing));

        $this->expectException(UnavailableHousingException::class);
        $this->rentManager->make(new User(), $from, $to, $housing);
    }
}
