<?php

namespace GroupDuaPBD\Management\Login\Php\Middleware;

use GroupDuaPBD\Management\Login\Php\App\View;
use GroupDuaPBD\Management\Login\Php\Config\Database;
use GroupDuaPBD\Management\Login\Php\Repository\SessionRepository;
use GroupDuaPBD\Management\Login\Php\Repository\UserRepository;
use GroupDuaPBD\Management\Login\Php\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::redirect('/users/login');
        }
    }
}