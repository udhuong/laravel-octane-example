<?php

namespace Core\Presentation\Http\Controllers;

use Core\Presentation\Http\Response\Responder;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends \Illuminate\Routing\Controller
{
    public function callAction($method, $parameters): JsonResponse|Response
    {
        try {
            return parent::callAction($method, $parameters);
        } catch (Exception $e) {
            return Responder::failWithException($e);
        }
    }
}
