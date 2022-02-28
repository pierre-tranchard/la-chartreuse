<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class UserController
{
    private SerializerInterface $serializer;

    private UserRepository $repository;

    public function __construct(SerializerInterface $serializer, UserRepository $repository)
    {
        $this->serializer = $serializer;
        $this->repository = $repository;
    }

    public function readAction(Request $request, int $id): Response
    {
        $user = $this->repository
            ->findOneBy(["id" => $id]);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return new Response($this->serializer->serialize($user, "json", ["groups" => ["user"]]));
    }

    public function updateAction(Request $request): Response
    {

    }
}