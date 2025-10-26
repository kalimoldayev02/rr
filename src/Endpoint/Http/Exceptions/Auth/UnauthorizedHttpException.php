<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Exceptions\Auth;

use App\Endpoint\Http\Exceptions\HttpException;

final class UnauthorizedHttpException extends HttpException
{
    protected $code = 401;

    public function __construct(string $message = 'Unauthorized')
    {
        parent::__construct($message);
    }
}
