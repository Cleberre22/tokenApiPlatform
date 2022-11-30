<?php

namespace App\Controller;

use App\Entity\Tokens;
use App\Form\TokensType;
use App\Repository\TokensRepository;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Proxies\__CG__\App\Entity\Tokens as EntityTokens;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/articles')]
class ArticlesController extends AbstractController
{

    // public function tokenPermission(TokensRepository $tokensRepository,): Response
    // {
    //     $tokenpermission = ;
    // }


    #[Route('/', name: 'app_articles_index', methods: ['GET'])]
    // #[isGranted("ROLE_USER")]
    public function index(ArticlesRepository $articlesRepository, TokensRepository $tokensRepository): Response
    {
        
        $token = Tokens::class;
        dd($tokensRepository);
        if ($token) {
            return $this->render('articles/index.html.twig', [
                'articles' => $articlesRepository->findAll(),
            ]);
        }
    }

    #[Route('/new', name: 'app_articles_new', methods: ['GET', 'POST'])]
    #[isGranted("ROLE_USER")]
    public function new(Request $request, ArticlesRepository $articlesRepository, UsersRepository $usersRepository): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($this->getUser());
            // $this->user_id = $this->doctrine->getRepository(Users::class)->findOneBy([]);
            $articlesRepository->save($article, true);

            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_articles_show', methods: ['GET'])]
    public function show(Articles $article): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_articles_edit', methods: ['GET', 'POST'])]
    #[isGranted("ROLE_USER")]
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->save($article, true);

            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_articles_delete', methods: ['POST'])]
    #[isGranted("ROLE_USER")]
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
    }
}
