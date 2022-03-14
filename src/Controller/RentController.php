<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Manager\HousingManager;
use App\Manager\RentManager;
use App\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class RentController
{
    private SerializerInterface $serializer;

    private RentManager $rentManager;

    private UserManager $userManager;

    private HousingManager $housingManager;

    public function __construct(SerializerInterface $serializer, RentManager $rentManager, UserManager $userManager, HousingManager $housingManager)
    {
        $this->serializer = $serializer;
        $this->rentManager = $rentManager;
        $this->userManager = $userManager;
        $this->housingManager = $housingManager;
    }

    public function bookAction(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);
        $housing = $this->housingManager->findOne($payload['housing']);
        $user = $this->userManager->findOne($payload['user']);
        $from = \DateTime::createFromFormat("Y-m-d", $payload['from']);
        $to = \DateTime::createFromFormat("Y-m-d", $payload['to']);

        $rent = $this->rentManager->make($user, $from, $to, $housing);

        return new Response($this->serializer->serialize($rent, 'json', ['groups' => ['rent']]));
    }

    /**
     * @ParamConverter("rent", class="App\Entity\Rent")
     */
    public function readAction(Request $request, Rent $rent): Response
    {
        return new Response($this->serializer->serialize($rent, 'json', ['groups' => ['rent', 'user']]));
    }

    public function cancelAction(Request $request, Rent $rent): Response
    {
        return new JsonResponse();
    }
}