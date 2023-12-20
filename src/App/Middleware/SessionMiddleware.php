<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use App\Exceptions\SessionException;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        // * 45. check if a session is already active or not
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException("Session Already Active!");
        }


        // * 46. Check if headers are sent 
        if (headers_sent()) {
            throw new SessionException("Headers already Sent");
        }

        // * 47. Start a session
        session_start();
        // * 48. invoke next function
        $next();
        session_write_close();
    }
}
