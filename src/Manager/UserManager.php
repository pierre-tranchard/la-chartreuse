<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private EntityManagerInterface $entityManager;

    private PropertyAccessor $propertyAccessor;

    private ValidatorInterface $validator;

    private PasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, PasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
                ->enableExceptionOnInvalidIndex()
                ->getPropertyAccessor();
        $this->validator = $validator;
        $this->passwordHasher = $passwordHasher;
    }

    public function create(array $payload): User
    {
        $password = $this->passwordHasher->hash($this->propertyAccessor->getValue($payload, '[password]'));
        $birthDate = \DateTime::createFromFormat('Y-m-d', $this->propertyAccessor->getValue($payload, '[birthDate]'));

        $user = new User();
        $user->setPassword($password)
            ->setUsername($this->propertyAccessor->getValue($payload, '[username]'))
            ->setFirstName($this->propertyAccessor->getValue($payload, '[firstName]'))
            ->setLastName($this->propertyAccessor->getValue($payload, '[lastName]'))
            ->setEmail($this->propertyAccessor->getValue($payload, '[email]'))
            ->setBirthDate($birthDate);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function update(array $payload, int $id): User
    {
        $user = $this->findOne($id);

        foreach ($payload as $property => $value) {
            $this->propertyAccessor->setValue($user, $property, $value);
        }
        $violations = $this->validator->validate($user);
        if (count($violations) > 0) {
            throw new ValidationFailedException($user, $violations);
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function findOne(int $id): User
    {
        $user = $this->entityManager->find(User::class, $id);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return $user;     
    }

    public function delete(int $id): bool
    {
        $user = $this->findOne($id);

        foreach ($user->getHousings() as $housing) {
            $this->entityManager->remove($housing);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        try {
            $this->findOne($id);

            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }
}
