<?php

declare(strict_types=1);

namespace App\Domain\Responder\Classes;

use App\Domain\Responder\Interfaces\IApiHttpResponder;
use Illuminate\Http\JsonResponse;

class ApiHttpResponder implements IApiHttpResponder
{
    /**
     * @param string|null $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     * @auther Mustafa Goda
     */
    public function response(string|null $message = null, array $data = [],int $status = 200) : JsonResponse
    {
       return response()->json(['message'=> $message,'data' => $data],$status);
    }
}
