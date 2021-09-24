<?php

namespace App\Exceptions\CustomExceptions;

use App\Domain\Responder\Interfaces\IApiHttpResponder;
use Exception;
use Illuminate\Http\JsonResponse;

class ApiNotFoundException extends Exception
{


    /**
     * @return JsonResponse
     * @author Mustafa Goda
     */
    public function render(): JsonResponse
    {
       return resolve(IApiHttpResponder::class)
           ->response(
               message:$this->message,
               status: 404,
           );
    }
}
