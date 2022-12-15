<?php

namespace App\EventListener;

use App\Entity\Tokens;
use App\Repository\TokensRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RequestListener
{
    private $entityManager;
    private $tokenStorage;

    public function __construct(
        TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }


    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $currentUri = $request->getRequestUri();

        if (str_starts_with($currentUri, "/api/")) {
            // // dd("ok");
            $roles = ["ROLE_BROWSE"];
            
            $tokenUserRepository = $this->entityManager->getRepository(Tokens::class);

            $tokenUser = $tokenUserRepository->findOneByToken("NSRjZVwqXHYKPqnuDbnPrScrIka8npjNvfX");
            dd($tokenUser);
            $token = new UsernamePasswordToken($tokenUser, 'api', $roles);
            // $token->
            $this->tokenStorage->setToken($token);
         
        }
    }
}
