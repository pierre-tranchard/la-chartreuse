<?php

namespace App\Controller;

use App\Manager\UserManager;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class UserController
{
    private SerializerInterface $serializer;

    private UserManager $userManager;

    public function __construct(SerializerInterface $serializer, UserManager $userManager)
    {
        $this->serializer = $serializer;
        $this->userManager = $userManager;
    }

    public function readAction(Request $request, int $id): Response
    {
        $user = $this->userManager->findOne($id);

        return new Response($this->serializer->serialize($user, "json", ["groups" => ["user"]]));
    }

    public function updateAction(Request $request, int $id): Response
    {
        $payload = json_decode($request->getContent(), true);
        $user = $this->userManager->update($payload, $id);

        return new Response($this->serializer->serialize($user, "json", ["groups" => ["user"]]));
    }

    public function createAction(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);
        $user = $this->userManager->create($payload);

        return new Response($this->serializer->serialize($user, "json", ["groups" => ["user"]]));
    }

    public function deleteAction(Request $request, int $id): Response
    {
        $context = [];
        try {
            $success = $this->userManager->delete($id);
        } catch (\Throwable $exception) {
            $success = false;
            $context['exception'] = $exception;
        }

        return new Response($this->serializer->serialize(['success' => $success, 'context' => $context], 'json'), $success ? Response::HTTP_NO_CONTENT : Response::HTTP_BAD_REQUEST);
    }
}