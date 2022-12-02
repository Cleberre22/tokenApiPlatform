<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use App\Entity\ApiUser;

use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RequestListener
{
    private $sam;
    private $tokenStorage;
    private $session;

    // public function __construct(TokenStorageInterface $sam)
    // {
    //     $this->sam = $sam;
    // }

    // public function __construct(
    //     private TokenStorageInterface $tokenStorage,
    // ) {
    // }

    public function __construct(
        TokenStorageInterface $tokenStorage
    ) {
        $this->tokenStorage = $tokenStorage;
        // $this->session = $session;
    }

    public function onKernelRequest(RequestEvent $event): void
    {

        $request = $event->getRequest();

        $currentUri = $request->getRequestUri();

        if (str_starts_with($currentUri, "/api/")) {
            // // dd("ok");

            // // $roles = ["ROLE_USER"];
            $roles = ["ROLE_BROWSE"];

            // // $Role_Categories = ["Browse", "Read"];

            $apiUser = new ApiUser();
            $apiUser->setRoles($roles);
            $token = new UsernamePasswordToken($apiUser, 'api', $apiUser->getRoles());
            $this->tokenStorage->setToken($token);
            // $sess = $this->session->set('_security_main', serialize($token));

            // $token = new UsernamePasswordToken($apiUser, 'main', $apiUser->getRoles());
            // $authenticatedToken = $this->authenticationManager->authenticate($token);
            // $this->tokenStorage->setToken($authenticatedToken);

            // $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            // $this->get("security.token_storage")->setToken($token);

            // // $roles = [''];

            

        }
    }
}
