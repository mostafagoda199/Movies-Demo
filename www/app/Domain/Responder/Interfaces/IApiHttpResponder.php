<?php

declare(strict_types=1);

namespace App\Domain\Responder\Interfaces;

use Illuminate\Http\JsonResponse;

interface IApiHttpResponder
{
    /**
     * @param string|null $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     * @auther Mustafa Goda
     */
    public function response(string|null $message, array $data = [],int $status = 200) : JsonResponse;
}
