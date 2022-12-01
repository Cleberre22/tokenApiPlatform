<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Entity\Tokens;
use App\Form\TokensType;
use App\Repository\TokensRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/tokens')]
class TokensController extends AbstractController
{
    
    #[Route('/', name: 'app_tokens_index', methods: ['GET'])]
    #[isGranted("ROLE_USER")]
    public function index(TokensRepository $tokensRepository): Response
    {
        return $this->render('tokens/index.html.twig', [
            'tokens' => $tokensRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tokens_new', methods: ['GET', 'POST'])]
    #[isGranted("ROLE_USER")]
    public function new(Request $request, TokensRepository $tokensRepository, UsersRepository $usersRepository): Response
    {   $strTotal = 35;
        $token = new Tokens();
        $form = $this->createForm(TokensType::class, $token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            // Stockez toutes les lettres possibles dans une chaîne.
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $key = '';
            // Générez un index aléatoire de 0 à la longueur de la chaîne -1.
            for ($i = 0; $i < $strTotal; $i++) {
                $index = rand(0, strlen($str) - 1);
                $key .= $str[$index];
            }
         
            $token->setKey($key); 
            $token->setUser($this->getUser());

            $tokensRepository->save($token, true);

            return $this->redirectToRoute('app_tokens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tokens/new.html.twig', [
            'token' => $token,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tokens_show', methods: ['GET'])]
    #[isGranted("ROLE_USER")]
    public function show(Tokens $token): Response
    {
        return $this->render('tokens/show.html.twig', [
            'token' => $token,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tokens_edit', methods: ['GET', 'POST'])]
    #[isGranted("ROLE_USER")]
    public function edit(Request $request, Tokens $token, TokensRepository $tokensRepository): Response
    {
        $form = $this->createForm(TokensType::class, $token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tokensRepository->save($token, true);

            return $this->redirectToRoute('app_tokens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tokens/edit.html.twig', [
            'token' => $token,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tokens_delete', methods: ['POST'])]
    #[isGranted("ROLE_USER")]
    public function delete(Request $request, Tokens $token, TokensRepository $tokensRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $token->getId(), $request->request->get('_token'))) {
            $tokensRepository->remove($token, true);
        }

        return $this->redirectToRoute('app_tokens_index', [], Response::HTTP_SEE_OTHER);
    }
}
