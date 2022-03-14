<?php

namespace App\Exception;

use App\Entity\Housing;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UnavailableHousingException extends HttpException
{
    public static function housingNotAvailable(Housing $housing, \DateTime $from, \DateTime $to): UnavailableHousingException
    {
        return new self(Response::HTTP_BAD_REQUEST, sprintf("Housing %s is not available from %s to %s", $housing->getName(), $from->format("Y-m-d"), $to->format("Y-m-d")));
    }
}